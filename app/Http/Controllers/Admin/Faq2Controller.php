<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Faq2Controller extends Controller
{
    /**
     * Afficher la liste des FAQ
     */
    public function getAllFaqs2()
    {
        $faqs = Faq::with(['updatedBy', 'createdBy'])->orderBy('ordre')->get();

        return view('admin.faqs.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nextOrder = (Faq::max('ordre') ?? 0) + 1;

        return view('admin.faqs.create', compact('nextOrder'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validation simplifiée
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:500',
            'answer' => 'required|string|max:2000',
            'ordre' => 'nullable|integer|min:1|max:999',
            'actif' => 'nullable|boolean',
        ], [
            'question.required' => 'La question est requise.',
            'question.max' => 'La question ne peut pas dépasser 500 caractères.',
            'answer.required' => 'La réponse est requise.',
            'answer.max' => 'La réponse ne peut pas dépasser 2000 caractères.',
            'ordre.integer' => 'L\'ordre doit être un nombre entier.',
            'ordre.min' => 'L\'ordre doit être au minimum 1.',
            'ordre.max' => 'L\'ordre ne peut pas dépasser 999.',
        ]);

        if ($validator->fails()) {
            $errorMessages = [];
            foreach ($validator->errors()->messages() as $field => $messages) {
                $fieldNames = [
                    'question' => 'Question',
                    'answer' => 'Réponse',
                    'ordre' => 'Ordre',
                ];

                $fieldName = $fieldNames[$field] ?? $field;
                foreach ($messages as $message) {
                    $errorMessages[] = "$fieldName : $message";
                }
            }

            $errorSummary = implode(' | ', $errorMessages);
            notify()->error(
                "Erreurs de validation détectées : {$errorSummary}",
                'Validation échouée'
            );

            return back()->withErrors($validator->errors())->withInput();
        }

        try {
            DB::beginTransaction();

            $actif = $request->input('actif', 1) == '1';
            $requestedOrder = $request->input('ordre');

            if ($requestedOrder) {
                $existingFaq = Faq::where('ordre', $requestedOrder)->first();

                if ($existingFaq) {
                    Faq::where('ordre', '>=', $requestedOrder)
                        ->update(['ordre' => DB::raw('ordre + 1')]);

                    Log::info('Décalage des ordres lors de création FAQ', [
                        'requested_order' => $requestedOrder,
                        'user_id' => $user->id,
                        'affected_faqs' => Faq::where('ordre', '>', $requestedOrder)->count(),
                    ]);
                }

                $ordre = $requestedOrder;
            } else {
                $ordre = (Faq::max('ordre') ?? 0) + 1;
            }

            $faq = Faq::create([
                'question' => trim($request->input('question')),
                'answer' => trim($request->input('answer')),
                'ordre' => $ordre,
                'actif' => $actif,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            DB::commit();

            if ($requestedOrder && $existingFaq) {
                notify()->success(
                    "La FAQ #{$faq->id} a été créée à l'ordre {$ordre}. Les autres FAQs ont été automatiquement décalées.",
                    $actif ? 'Publication avec réorganisation ! 🎉' : 'Brouillon avec réorganisation ! 📝'
                );
            } else {
                if ($actif) {
                    notify()->success(
                        "La FAQ #{$faq->id} a été créée et publiée avec succès à l'ordre {$ordre}!",
                        'Publication réussie ! 🎉'
                    );
                } else {
                    notify()->success(
                        "La FAQ #{$faq->id} a été enregistrée en brouillon à l'ordre {$ordre}.",
                        'Brouillon sauvegardé ! 📝'
                    );
                }
            }

            Log::info('Création d\'une nouvelle FAQ', [
                'faq_id' => $faq->id,
                'question' => $faq->question,
                'ordre' => $faq->ordre,
                'actif' => $faq->actif,
                'user_id' => $user->id,
                'user_name' => $user->firstname.' '.$user->lastname,
            ]);

            return redirect()->route('admin.faqs.show', $faq->id);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            Log::error('Erreur de base de données lors de la création d\'une FAQ', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'question' => $request->input('question'),
                'user_id' => $user->id,
            ]);

            if (config('app.debug')) {
                notify()->error(
                    "Erreur de base de données : {$e->getMessage()}",
                    'Erreur technique détaillée'
                );
            } else {
                notify()->error(
                    'Une erreur de base de données s\'est produite lors de la création d\'une FAQ. L\'équipe technique a été notifiée.',
                    'Erreur de base de données'
                );
            }

            return back()->withInput();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erreur générale lors de la création d\'une FAQ', [
                'message' => $e->getMessage(),
                'question' => $request->input('question'),
                'user_id' => $user->id,
            ]);

            if (config('app.debug')) {
                notify()->error(
                    "Erreur technique : {$e->getMessage()} (Ligne {$e->getLine()})",
                    'Erreur technique détaillée'
                );
            } else {
                notify()->error(
                    'Une erreur inattendue s\'est produite lors de la création d\'une FAQ. L\'équipe technique a été notifiée.',
                    'Erreur technique'
                );
            }

            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $faq = Faq::with(['createdBy', 'updatedBy'])->findOrFail($id);

        return view('admin.faqs.show', compact('faq'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $faq = Faq::findOrFail($id);
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:500',
            'answer' => 'required|string|max:2000',
            'ordre' => 'integer|min:1',
            'actif' => 'boolean',
        ], [
            'question.required' => 'La question est requise.',
            'question.string' => 'La question doit être une chaîne de caractères.',
            'question.max' => 'La question ne peut pas dépasser 500 caractères.',
            'answer.required' => 'La réponse est requise.',
            'answer.string' => 'La réponse doit être une chaîne de caractères.',
            'answer.max' => 'La réponse ne peut pas dépasser 2000 caractères.',
            'ordre.integer' => 'L\'ordre doit être un nombre entier.',
            'ordre.min' => 'L\'ordre doit être au minimum 1.',
            'actif.boolean' => 'Le statut actif doit être vrai ou faux.',
        ]);

        if ($validator->fails()) {
            $errorMessages = [];
            foreach ($validator->errors()->messages() as $field => $messages) {
                $fieldNames = [
                    'question' => 'Question',
                    'answer' => 'Réponse',
                    'ordre' => 'Ordre',
                    'actif' => 'Actif',
                ];

                $fieldName = $fieldNames[$field] ?? $field;
                foreach ($messages as $message) {
                    $errorMessages[] = "$fieldName : $message";
                }
            }

            $errorSummary = implode(' | ', $errorMessages);
            notify()->error(
                "Erreurs de validation détectées : {$errorSummary}",
                'Validation échouée'
            );

            Log::warning('Erreur de validation lors de la création de la question fréquente', [
                'errors' => $validator->errors(),
                'user_id' => $user->id,
            ]);

            return back()->withErrors($validator->errors())->withInput();
        }

        try {
            DB::beginTransaction();

            $updateData = [
                'question' => $request->input('question'),
                'answer' => $request->input('answer'),
                'ordre' => $request->input('ordre', $faq->ordre),
                'actif' => $request->has('actif') && $request->input('actif') == '1',
                'updated_by' => $user->id,
            ];

            $faq->update($updateData);

            DB::commit();

            notify()->success("La FAQ #{$faq->id} a été modifiée avec succès.", 'Modification réussie ! 🎉');

            return redirect()->route('admin.faqs.show', $faq->id);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            Log::error('Erreur de base de données lors de la modification de la FAQ', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'question' => $request->input('question'),
                'user_id' => $user->id,
            ]);

            if (config('app.debug')) {
                notify()->error(
                    "Erreur de base de données : {$e->getMessage()}",
                    'Erreur technique détaillée'
                );
            } else {
                notify()->error(
                    'Une erreur de base de données s\'est produite lors de la modification de la FAQ. L\'équipe technique a été notifiée.',
                    'Erreur de base de données'
                );
            }

            return back()->withInput();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erreur générale lors de la modification de la FAQ', [
                'message' => $e->getMessage(),
                'question' => $request->input('question'),
                'user_id' => $user->id,
            ]);

            if (config('app.debug')) {
                notify()->error(
                    "Erreur technique : {$e->getMessage()} (Ligne {$e->getLine()})",
                    'Erreur technique détaillée'
                );
            } else {
                notify()->error(
                    'Une erreur inattendue s\'est produite lors de la modification de la FAQ. L\'équipe technique a été notifiée.',
                    'Erreur technique'
                );
            }

            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $faq = Faq::findOrFail($id);
        $user = Auth::user();
        try {
            DB::beginTransaction();

            $faq->update([
                'actif' => false,
                'updated_by' => $user->id,
            ]);

            DB::commit();

            notify()->success("La FAQ #{$faq->id} a été masquée avec succès.", 'Masquage réussi ! 🎉');

            return redirect()->route('admin.faqs.index');
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            Log::error('Erreur de base de données lors de la modification du statut de la FAQ', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'question' => $faq->question,
                'user_id' => $user->id,
            ]);

            if (config('app.debug')) {
                notify()->error(
                    "Erreur de base de données : {$e->getMessage()}",
                    'Erreur technique détaillée'
                );
            } else {
                notify()->error(
                    'Une erreur de base de données s\'est produite lors de la modification du statut de la FAQ. L\'équipe technique a été notifiée.',
                    'Erreur de base de données'
                );
            }

            return back()->withInput();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erreur générale lors de la modification du statut de la FAQ', [
                'message' => $e->getMessage(),
                'question' => $faq->question,
                'user_id' => $user->id,
            ]);

            if (config('app.debug')) {
                notify()->error(
                    "Erreur technique : {$e->getMessage()} (Ligne {$e->getLine()})",
                    'Erreur technique détaillée'
                );
            } else {
                notify()->error(
                    'Une erreur inattendue s\'est produite lors de la modification du statut de la FAQ. L\'équipe technique a été notifiée.',
                    'Erreur technique'
                );
            }

            return back()->withInput();
        }
    }

    /**
     * Masquer plusieurs FAQs en lot
     */
    public function bulkMask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:faqs,id',
        ], [
            'ids.required' => 'Aucune FAQ sélectionnée.',
            'ids.array' => 'Format de données invalide.',
            'ids.*.integer' => 'ID de FAQ invalide.',
            'ids.*.exists' => 'Une ou plusieurs FAQs n\'existent pas.',
        ]);

        if ($validator->fails()) {
            notify()->error(
                'Erreur de validation : '.$validator->errors()->first(),
                'Données invalides'
            );

            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $ids = $request->input('ids');

        try {
            DB::beginTransaction();

            // Récupérer les FAQs avant masquage (pour les logs)
            $faqsToMask = Faq::whereIn('id', $ids)->get();

            // Masquer toutes les FAQs sélectionnées
            $maskedCount = Faq::whereIn('id', $ids)
                ->update([
                    'actif' => 0,  // Masquer
                    'updated_by' => $user->id,
                ]);

            // Log de l'action
            Log::info('Masquage en lot de FAQs', [
                'user_id' => $user->id,
                'user_name' => $user->firstname.' '.$user->lastname,
                'masked_count' => $maskedCount,
                'faq_ids' => $ids,
                'faq_questions' => $faqsToMask->pluck('question')->toArray(),
            ]);

            DB::commit();

            notify()->success(
                "{$maskedCount} FAQ(s) ont été masquées avec succès.",
                'Modification réussie ! 🎉'
            );

            return redirect()->route('admin.faqs.index');
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            Log::error('Erreur de base de données lors de la modification des FAQs', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'faq_ids' => $ids,
                'user_id' => $user->id,
            ]);

            if (config('app.debug')) {
                notify()->error(
                    "Erreur de base de données : {$e->getMessage()}",
                    'Erreur technique détaillée'
                );
            } else {
                notify()->error(
                    'Une erreur de base de données s\'est produite lors de la modification des FAQs. L\'équipe technique a été notifiée.',
                    'Erreur de base de données'
                );
            }

            return back()->withInput();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erreur générale lors de la modification des FAQs', [
                'message' => $e->getMessage(),
                'faq_ids' => $ids,
                'user_id' => $user->id,
            ]);

            if (config('app.debug')) {
                notify()->error(
                    "Erreur technique : {$e->getMessage()} (Ligne {$e->getLine()})",
                    'Erreur technique détaillée'
                );
            } else {
                notify()->error(
                    'Une erreur inattendue s\'est produite lors de la modification des FAQs. L\'équipe technique a été notifiée.',
                    'Erreur technique'
                );
            }

            return back()->withInput();
        }
    }

    /**
     * Activer plusieurs FAQs en lot
     */
    public function bulkActivate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:faqs,id',
        ], [
            'ids.required' => 'Aucune FAQ sélectionnée.',
            'ids.array' => 'Format de données invalide.',
            'ids.*.integer' => 'ID de FAQ invalide.',
            'ids.*.exists' => 'Une ou plusieurs FAQs n\'existent pas.',
        ]);

        if ($validator->fails()) {
            notify()->error(
                'Erreur de validation : '.$validator->errors()->first(),
                'Données invalides'
            );

            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $ids = $request->input('ids');

        try {
            DB::beginTransaction();

            // Récupérer les FAQs avant activation (pour les logs)
            $faqsToActivate = Faq::whereIn('id', $ids)->get();

            // Activer toutes les FAQs sélectionnées
            $activatedCount = Faq::whereIn('id', $ids)
                ->update([
                    'actif' => 1,  // Activer
                    'updated_by' => $user->id,
                ]);

            // Log de l'action
            Log::info('Activation en lot de FAQs', [
                'user_id' => $user->id,
                'user_name' => $user->firstname.' '.$user->lastname,
                'activated_count' => $activatedCount,
                'faq_ids' => $ids,
                'faq_questions' => $faqsToActivate->pluck('question')->toArray(),
            ]);

            DB::commit();

            notify()->success(
                "{$activatedCount} FAQ(s) ont été activées avec succès.",
                'Modification réussie ! 🎉'
            );

            return redirect()->route('admin.faqs.index');
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            Log::error('Erreur de base de données lors de la modification des FAQs', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'faq_ids' => $ids,
                'user_id' => $user->id,
            ]);

            if (config('app.debug')) {
                notify()->error(
                    "Erreur de base de données : {$e->getMessage()}",
                    'Erreur technique détaillée'
                );
            } else {
                notify()->error(
                    'Une erreur de base de données s\'est produite lors de la modification des FAQs. L\'équipe technique a été notifiée.',
                    'Erreur de base de données'
                );
            }

            return back()->withInput();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erreur générale lors de la modification des FAQs', [
                'message' => $e->getMessage(),
                'faq_ids' => $ids,
                'user_id' => $user->id,
            ]);

            if (config('app.debug')) {
                notify()->error(
                    "Erreur technique : {$e->getMessage()} (Ligne {$e->getLine()})",
                    'Erreur technique détaillée'
                );
            } else {
                notify()->error(
                    'Une erreur inattendue s\'est produite lors de la modification des FAQs. L\'équipe technique a été notifiée.',
                    'Erreur technique'
                );
            }

            return back()->withInput();
        }
    }

    /**
     * Changer l'ordre d'une FAQ (AJAX)
     */
    public function changeOrder(Request $request, string $id)
    {
        $faq = Faq::findOrFail($id);
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'direction' => 'required|in:up,down',
        ], [
            'direction.required' => 'La direction est requise.',
            'direction.in' => 'Direction invalide. Utilisez "up" ou "down".',
        ]);

        if ($validator->fails()) {
            $errorMessages = [];
            foreach ($validator->errors()->messages() as $field => $messages) {
                $fieldNames = [
                    'direction' => 'Direction',
                ];

                $fieldName = $fieldNames[$field] ?? $field;
                foreach ($messages as $message) {
                    $errorMessages[] = "$fieldName : $message";
                }
            }

            $errorSummary = implode(' | ', $errorMessages);
            notify()->error(
                "Erreurs de validation détectées : {$errorSummary}",
                'Validation échouée'
            );

            Log::warning('Erreur de validation lors de la création de la question fréquente', [
                'errors' => $validator->errors(),
                'user_id' => $user->id,
            ]);

            return back()->withErrors($validator->errors())->withInput();
        }

        $direction = $request->input('direction');

        try {
            DB::beginTransaction();

            $currentOrder = $faq->ordre;
            $newOrder = $currentOrder;

            if ($direction === 'up') {
                // Monter dans la liste (ordre plus petit)
                $newOrder = max(1, $currentOrder - 1);

                // Si on peut effectivement monter
                if ($newOrder < $currentOrder) {
                    // Trouver la FAQ qui a cet ordre et l'échanger
                    $otherFaq = Faq::where('ordre', $newOrder)->first();
                    if ($otherFaq) {
                        $otherFaq->update(['ordre' => $currentOrder, 'updated_by' => $user->id]);
                    }
                }
            } else {
                // Descendre dans la liste (ordre plus grand)
                $maxOrder = Faq::max('ordre') ?? 1;
                $newOrder = min($maxOrder + 1, $currentOrder + 1);

                // Si on peut effectivement descendre
                if ($newOrder > $currentOrder) {
                    // Trouver la FAQ qui a cet ordre et l'échanger
                    $otherFaq = Faq::where('ordre', $newOrder)->first();
                    if ($otherFaq) {
                        $otherFaq->update(['ordre' => $currentOrder, 'updated_by' => $user->id]);
                    }
                }
            }
            // Mettre à jour la FAQ actuelle
            $faq->update([
                'ordre' => $newOrder,
                'updated_by' => $user->id,
            ]);

            DB::commit();

            // Log de l'action
            Log::info('Changement d\'ordre FAQ', [
                'user_id' => $user->id,
                'faq_id' => $faq->id,
                'old_order' => $currentOrder,
                'new_order' => $newOrder,
                'direction' => $direction,
            ]);

            notify()->success("L'ordre de la FAQ #{$faq->id} a été modifié avec succès.", 'Modification réussie ! 🎉');

            return back()->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            Log::error('Erreur de base de données lors de la modification de l\'ordre de la FAQ', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'old_order' => $currentOrder,
                'new_order' => $newOrder,
                'faq_id' => $faq->id,
                'direction' => $direction,
                'user_id' => $user->id,
            ]);

            if (config('app.debug')) {
                notify()->error(
                    "Erreur de base de données : {$e->getMessage()}",
                    'Erreur technique détaillée'
                );
            } else {
                notify()->error(
                    'Une erreur de base de données s\'est produite lors de la modification de l\'ordre de la FAQ. L\'équipe technique a été notifiée.',
                    'Erreur de base de données'
                );
            }

            return back()->withInput();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erreur générale lors de la modification de l\'ordre de la FAQ', [
                'message' => $e->getMessage(),
                'old_order' => $currentOrder,
                'new_order' => $newOrder,
                'faq_id' => $faq->id,
                'direction' => $direction,
                'user_id' => $user->id,
            ]);

            if (config('app.debug')) {
                notify()->error(
                    "Erreur technique : {$e->getMessage()} (Ligne {$e->getLine()})",
                    'Erreur technique détaillée'
                );
            } else {
                notify()->error(
                    'Une erreur inattendue s\'est produite lors de la modification de l\'ordre de la FAQ. L\'équipe technique a été notifiée.',
                    'Erreur technique'
                );
            }

            return back()->withInput();
        }
    }
}
