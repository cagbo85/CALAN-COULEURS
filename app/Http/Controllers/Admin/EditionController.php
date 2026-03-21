<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Edition;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class EditionController extends Controller
{
    public function index()
    {
        $editions = $this->getAllEditions();

        return view('admin.editions.index', compact('editions'));
    }

    /**
     * Afficher la liste des éditions
     */
    public function getAllEditions()
    {
        return DB::table('editions as e')
            ->select(
                'e.*',
                DB::raw('DATE_FORMAT(e.begin_date, "%d/%m/%Y %H:%i") as formatted_begin_date'),
                DB::raw('DATE_FORMAT(e.ending_date, "%d/%m/%Y %H:%i") as formatted_ending_date'),
                DB::raw("CASE
                        WHEN e.status = 'draft' THEN 'En projet'
                        WHEN e.status = 'upcoming' THEN 'À venir'
                        WHEN e.status = 'ongoing' THEN 'En cours'
                        WHEN e.status = 'past' THEN 'Passée'
                        WHEN e.status = 'archived' THEN 'Archivée'
                    ELSE 'Non répertoriée'
                END as statusLabel
                "),
                DB::raw("CASE
                        WHEN e.status LIKE 'draft' THEN 'fa-solid fa-pencil'
                        WHEN e.status LIKE 'upcoming' THEN 'fa-solid fa-clock'
                        WHEN e.status LIKE 'ongoing' THEN 'fa-solid fa-fire'
                        WHEN e.status LIKE 'past' THEN 'fa-solid fa-circle-check'
                        WHEN e.status LIKE 'archived' THEN 'fa-solid fa-box-archive'
                    ELSE 'fa-solid fa-circle-question'
                END as statusIcon
                "),
                DB::raw("CASE
                        WHEN e.status LIKE 'draft' THEN 'purple'
                        WHEN e.status LIKE 'upcoming' THEN 'green'
                        WHEN e.status LIKE 'ongoing' THEN 'yellow'
                        WHEN e.status LIKE 'past' THEN 'gray'
                        WHEN e.status LIKE 'archived' THEN 'red'
                    ELSE 'gray'
                END as statusColor
                ")
            )
            ->orderByDesc('e.year')
            ->get();
    }

    /**
     * Récupérer les détails d'une édition
     */
    public function getEditionDetails(string $id)
    {
        return DB::table('editions as e')
            ->select(
                'e.*',
                DB::raw('DATE_FORMAT(e.begin_date, "%d/%m/%Y %H:%i") as formatted_begin_date'),
                DB::raw('DATE_FORMAT(e.ending_date, "%d/%m/%Y %H:%i") as formatted_ending_date'),
                DB::raw("CASE
                        WHEN e.status = 'draft' THEN 'En projet'
                        WHEN e.status = 'upcoming' THEN 'À venir'
                        WHEN e.status = 'ongoing' THEN 'En cours'
                        WHEN e.status = 'past' THEN 'Passée'
                        WHEN e.status = 'archived' THEN 'Archivée'
                    ELSE 'Non répertoriée'
                END as statusLabel
                "),
                DB::raw("CASE
                        WHEN e.status LIKE 'draft' THEN 'fa-solid fa-pencil'
                        WHEN e.status LIKE 'upcoming' THEN 'fa-solid fa-clock'
                        WHEN e.status LIKE 'ongoing' THEN 'fa-solid fa-fire'
                        WHEN e.status LIKE 'past' THEN 'fa-solid fa-circle-check'
                        WHEN e.status LIKE 'archived' THEN 'fa-solid fa-box-archive'
                    ELSE 'fa-solid fa-circle-question'
                END as statusIcon
                "),
                DB::raw("CASE
                        WHEN e.status LIKE 'draft' THEN 'purple'
                        WHEN e.status LIKE 'upcoming' THEN 'green'
                        WHEN e.status LIKE 'ongoing' THEN 'yellow'
                        WHEN e.status LIKE 'past' THEN 'gray'
                        WHEN e.status LIKE 'archived' THEN 'red'
                    ELSE 'gray'
                END as statusColor
                "),
                DB::raw('DATE_FORMAT(e.updated_at, "%d/%m/%Y %H:%i") as formatted_updated_at'),
                'u.login as updated_by_login',
                'u2.login as created_by_login'
            )
            ->join('users as u', 'u.id', '=', 'e.updated_by')
            ->join('users as u2', 'u2.id', '=', 'e.created_by')
            ->where('e.id', $id)
            ->first();
    }

    /**
     * Afficher les détails d'une édition
     */
    public function show(string $id)
    {
        $edition = $this->getEditionDetails($id);

        $otherEditions = Edition::where('id', '!=', $edition->id)
            ->select('status', 'name', 'year', 'id')
            ->get();

        return view('admin.editions.show', compact('edition', 'otherEditions'));
    }

    /**
     * Mettre à jour les informations d'une édition
     */
    public function update(Request $request, string $id)
    {
        $edition = Edition::findOrFail($id);
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'year' => 'required|integer|between:2000,2100',
            'name' => 'nullable|string|max:255',
            'reservation_url' => 'nullable|url|max:255',
            'status' => 'required|in:draft,upcoming,ongoing,past,archived',
            'actif' => 'required|boolean',
            'begin_date' => 'required|date',
            'ending_date' => 'required|date|after:begin_date',
        ], [
            'year.required' => 'L\'année de l\'édition est obligatoire.',
            'name.string' => 'Le nom de l\'édition est obligatoire.',
            'reservation_url.url' => 'L\'URL de réservation doit être une URL valide.',
            'status.required' => 'Le statut de l\'édition est obligatoire.',
            'status.in' => 'Le statut sélectionné est invalide.',
            'actif.required' => 'Le champ activation est obligatoire.',
            'begin_date.required' => 'La date de début est obligatoire.',
            'ending_date.required' => 'La date de fin est obligatoire.',
            'ending_date.after' => 'La date de fin doit être après la date de début.',
        ]);

        if ($validator->fails()) {
            notify()->error(
                'Un problème a été détecté dans le formulaire. Veuillez vérifier les champs marqués en rouge.',
                'Erreur de validation'
            );

            Log::warning("Erreur de validation lors de la création d'une édition", [
                'errors' => $validator->errors(),
                'user_id' => $user->id,
            ]);

            return back()->withErrors($validator->errors())->withInput();
        }

        try {
            DB::beginTransaction();

            $updateData = [
                'year' => $request->input('year'),
                'name' => $request->input('name'),
                'reservation_url' => $request->input('reservation_url'),
                'status' => $request->input('status'),
                'actif' => $request->input('actif'),
                'begin_date' => $request->input('begin_date'),
                'ending_date' => $request->input('ending_date'),
                'updated_by' => $user->id,
            ];

            $edition->update($updateData);

            // 1. À venir = archive TOUT sauf elle-même
            if ($edition->status === 'upcoming') {
                $edition->update(['actif' => 1, 'updated_by' => $user->id]);

                Edition::whereIn('status', ['upcoming', 'ongoing', 'past'])
                    ->where('id', '!=', $edition->id)
                    ->update(['status' => 'archived', 'actif' => 1, 'updated_by' => $user->id]);
            }

            // 2. En cours = archive TOUT sauf elle-même
            if ($edition->status === 'ongoing') {
                $edition->update(['actif' => 1, 'updated_by' => $user->id]);

                Edition::whereIn('status', ['upcoming', 'ongoing', 'past'])
                    ->where('id', '!=', $edition->id)
                    ->update(['status' => 'archived', 'actif' => 1, 'updated_by' => $user->id]);
            }

            // 3. Passée = archive upcoming + ongoing (pas les autres past)
            if ($edition->status === 'past') {
                // Actif par défaut pour afficher les souvenirs
                $edition->update(['actif' => 1, 'updated_by' => $user->id]);

                Edition::whereIn('status', ['upcoming', 'ongoing'])
                    ->where('id', '!=', $edition->id)
                    ->update(['status' => 'archived', 'actif' => 1, 'updated_by' => $user->id]);
            }

            // 4. En projet = forcer inactif
            if ($edition->status === 'draft') {
                $edition->update(['actif' => 0, 'updated_by' => $user->id]);
            }

            // 5. Archivée = respecter le choix utilisateur
            if ($edition->status === 'archived') {
                $edition->update(['actif' => $request->input('actif'), 'updated_by' => $user->id]);
            }

            DB::commit();

            notify()->success("L'édition {$edition->name} a été modifiée avec succès.", 'Modification réussie ! 🎉');

            return redirect()->route('admin.editions.show', $edition->id);
        } catch (QueryException $e) {
            DB::rollBack();

            Log::error('Erreur de base de données lors de la modification d\'une édition', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'name' => $request->input('name'),
                'user_id' => $user->id,
            ]);

            if (config('app.debug')) {
                notify()->error(
                    "Erreur de base de données : {$e->getMessage()}",
                    'Erreur technique détaillée'
                );
            } else {
                notify()->error(
                    'Une erreur de base de données s\'est produite lors de la modification d\'une édition. L\'équipe technique a été notifiée.',
                    'Erreur de base de données'
                );
            }

            return back()->withInput();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erreur générale lors de la modification d\'une édition', [
                'message' => $e->getMessage(),
                'name' => $request->input('name'),
                'user_id' => $user->id,
            ]);

            if (config('app.debug')) {
                notify()->error(
                    "Erreur technique : {$e->getMessage()} (Ligne {$e->getLine()})",
                    'Erreur technique détaillée'
                );
            } else {
                notify()->error(
                    'Une erreur inattendue s\'est produite lors de la modification d\'une édition. L\'équipe technique a été notifiée.',
                    'Erreur technique'
                );
            }

            return back()->withInput();
        }
    }

    /**
     * Afficher le formulaire pour la création d'une nouvelle édition
     */
    public function create()
    {
        return view('admin.editions.create');
    }

    /**
     * Enregistrer une nouvelle édition
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'year' => 'required|integer|between:2000,2100',
            'name' => 'nullable|string|max:255',
            'reservation_url' => 'nullable|url|max:255',
            'status' => 'required|in:draft,upcoming,ongoing,past,archived',
            'actif' => 'required|boolean',
            'begin_date' => 'nullable|date',
            'ending_date' => 'nullable|date|after:begin_date',
        ], [
            'year.required' => 'L\'année de l\'édition est obligatoire.',
            'name.string' => 'Le nom de l\'édition est obligatoire.',
            'reservation_url.url' => 'L\'URL de réservation doit être une URL valide.',
            'status.required' => 'Le statut de l\'édition est obligatoire.',
            'status.in' => 'Le statut sélectionné est invalide.',
            'actif.required' => 'Le champ activation est obligatoire.',
            'ending_date.after' => 'La date de fin doit être après la date de début.',
        ]);

        if ($validator->fails()) {
            notify()->error(
                'Un problème a été détecté dans le formulaire. Veuillez vérifier les champs marqués en rouge.',
                'Erreur de validation'
            );

            Log::warning("Erreur de validation lors de la création d'une édition", [
                'errors' => $validator->errors(),
                'user_id' => $user->id,
            ]);

            return back()->withErrors($validator->errors())->withInput();
        }

        try {
            DB::beginTransaction();

            $edition = Edition::create([
                'year' => $request->input('year'),
                'name' => $request->input('name'),
                'reservation_url' => $request->input('reservation_url'),
                'status' => $request->input('status'),
                'actif' => $request->input('actif'),
                'begin_date' => $request->input('begin_date'),
                'ending_date' => $request->input('ending_date'),
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            // 1. À venir = archive TOUT sauf elle-même
            if ($edition->status === 'upcoming') {
                $edition->update(['actif' => 1, 'updated_by' => $user->id]);

                Edition::whereIn('status', ['upcoming', 'ongoing', 'past'])
                    ->where('id', '!=', $edition->id)
                    ->update(['status' => 'archived', 'actif' => 1, 'updated_by' => $user->id]);
            }

            // 2. En cours = archive TOUT sauf elle-même
            if ($edition->status === 'ongoing') {
                $edition->update(['actif' => 1, 'updated_by' => $user->id]);

                Edition::whereIn('status', ['upcoming', 'ongoing', 'past'])
                    ->where('id', '!=', $edition->id)
                    ->update(['status' => 'archived', 'actif' => 1, 'updated_by' => $user->id]);
            }

            // 3. Passée = archive upcoming + ongoing (pas les autres past)
            if ($edition->status === 'past') {
                // Actif par défaut pour afficher les souvenirs
                $edition->update(['actif' => 1, 'updated_by' => $user->id]);

                Edition::whereIn('status', ['upcoming', 'ongoing'])
                    ->where('id', '!=', $edition->id)
                    ->update(['status' => 'archived', 'actif' => 1, 'updated_by' => $user->id]);
            }

            // 4. En projet = forcer inactif
            if ($edition->status === 'draft') {
                $edition->update(['actif' => 0, 'updated_by' => $user->id]);
            }

            // 5. Archivée = respecter le choix utilisateur
            if ($edition->status === 'archived') {
                $edition->update(['actif' => $request->input('actif'), 'updated_by' => $user->id]);
            }

            DB::commit();

            notify()->success("L'édition {$edition->name} a été créée avec succès.", 'Création réussie ! 🎉');

            return redirect()->route('admin.editions.show', $edition->id);
        } catch (QueryException $e) {
            DB::rollBack();

            Log::error('Erreur de base de données lors de la création d\'une édition', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'name' => $request->input('name'),
                'reservation_url' => $request->input('reservation_url'),
                'user_id' => $user->id,
            ]);

            if (config('app.debug')) {
                notify()->error(
                    "Erreur de base de données : {$e->getMessage()}",
                    'Erreur technique détaillée'
                );
            } else {
                notify()->error(
                    'Une erreur de base de données s\'est produite lors de la création d\'une édition. L\'équipe technique a été notifiée.',
                    'Erreur de base de données'
                );
            }

            return back()->withInput();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erreur générale lors de la création d\'une édition', [
                'message' => $e->getMessage(),
                'name' => $request->input('name'),
                'reservation_url' => $request->input('reservation_url'),
                'user_id' => $user->id,
            ]);

            if (config('app.debug')) {
                notify()->error(
                    "Erreur technique : {$e->getMessage()} (Ligne {$e->getLine()})",
                    'Erreur technique détaillée'
                );
            } else {
                notify()->error(
                    'Une erreur inattendue s\'est produite lors de la création d\'une édition. L\'équipe technique a été notifiée.',
                    'Erreur technique'
                );
            }

            return back()->withInput();
        }
    }

    /**
     * Récupérer l'édition courante pour le site public
     */
    public function getCurrentEdition()
    {
        $currentEdition = Edition::getCurrentEdition();

        if (! $currentEdition) {
            return response()->json([
                'message' => 'Aucune édition courante disponible',
            ], 404);
        }

        return response()->json($currentEdition);
    }
}
