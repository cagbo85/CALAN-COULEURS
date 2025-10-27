<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artiste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArtisteController extends Controller
{
    /**
     * Afficher la liste des artistes
     */
    public function getAllArtistes()
    {
        $artistes = Artiste::orderBy('name')->get();

        return view('admin.artistes.index', compact('artistes'));
    }

    /**
     * Récupérer tous les artistes actifs pour l'édition active.
     */
    public function getActiveArtistes()
    {
        $artists = DB::table('artistes as a')
            ->join('edition_artistes as ea', 'a.id', '=', 'ea.artiste_id')
            ->join('editions as e', 'ea.edition_id', '=', 'e.id')
            ->select('a.*')
            ->where('ea.actif', 1)
            ->where('e.actif', 1)
            ->orderBy('a.begin_date')
            ->get()
            ->groupBy('day');

        return $artists;
    }

    public function getArtistsGroupedByDay()
    {
        return DB::table('artistes as a')
            ->join('edition_artistes as ea', 'a.id', '=', 'ea.artiste_id')
            ->join('editions as e', 'ea.edition_id', '=', 'e.id')
            ->select(
                'a.day',
                DB::raw('MIN(DATE_FORMAT(a.begin_date, "%W %e %M")) as jour_rep'),
                DB::raw('DATE_FORMAT(MIN(a.begin_date), "%Hh") as heu_min'),
                DB::raw('DATE_FORMAT(MAX(a.ending_date), "%Hh") as heu_max'),
                DB::raw('GROUP_CONCAT(a.name ORDER BY a.begin_date SEPARATOR ", ") as artistes')
            )
            ->where('ea.actif', 1)
            ->where('e.actif', 1)
            ->groupBy('a.day')
            ->orderBy(DB::raw('MIN(a.begin_date)'))
            ->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.artistes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'style' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'photo' => 'required|file|mimes:webp|max:4096',
            'day' => 'nullable|in:Vendredi,Samedi,Dimanche',
            'begin_date' => 'required|date',
            'ending_date' => 'required|date|after:begin_date',
            'scene' => 'nullable|string|max:500',
            'soundcloud_url' => 'nullable|url|max:500',
            'spotify_url' => 'nullable|url|max:500',
            'youtube_url' => 'nullable|url|max:500',
            'deezer_url' => 'nullable|url|max:500',
            'actif' => 'boolean',
        ], [
            'name.required' => 'Le nom de l\'artiste est obligatoire.',
            'begin_date.required' => 'La date de début de représentation est obligatoire.',
            'ending_date.required' => 'La date de fin de représentation est obligatoire.',
            'ending_date.after' => 'La date de fin de représentation doit être après la date de début.',
            'photo.required' => 'La photo est obligatoire.',
            'photo.mimes' => 'La photo doit être au format WEBP uniquement.',
            'photo.max' => 'La photo ne doit pas dépasser 4MB.',
        ]);

        if ($validator->fails()) {
            $errorMessages = [];
            foreach ($validator->errors()->messages() as $field => $messages) {
                $fieldNames = [
                    'name' => 'Nom',
                    'style' => 'Style',
                    'description' => 'Description',
                    'photo' => 'Photo',
                    'day' => 'Jour',
                    'begin_date' => 'Date de début',
                    'ending_date' => 'Date de fin',
                    'scene' => 'Scène',
                    'soundcloud_url' => 'URL SoundCloud',
                    'spotify_url' => 'URL Spotify',
                    'youtube_url' => 'URL YouTube',
                    'deezer_url' => 'URL Deezer',
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

            Log::warning("Erreur de validation lors de la crétion de l'artiste", [
                'errors' => $validator->errors(),
                'user_id' => $user->id,
            ]);

            return back()->withErrors($validator->errors())->withInput();
        }
        try {
            DB::beginTransaction();

            // 📸 GESTION PHOTO PERSONNALISÉE
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');

                // Nom de fichier personnalisé : NOM_ARTISTE en UPPERCASE
                $filename = strtoupper($request->input('name')) . '.webp';

                // Dossier de destination personnalisé
                $destinationPath = public_path('img/artists/photos/Photos_artistes');

                // Créer le dossier s'il n'existe pas
                if (! File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                // Déplacer le fichier
                $file->move($destinationPath, $filename);

                // Stocker le chemin relatif dans la DB
                $updateData['photo'] = 'img/artists/photos/Photos_artistes/' . $filename;
            }

            $artiste = Artiste::create([
                'name' => $request->input('name'),
                'style' => $request->input('style'),
                'description' => $request->input('description'),
                'photo' => $request->file('photo')->store('artistes', 'public'),
                'day' => $request->input('day'),
                'begin_date' => $request->input('begin_date'),
                'ending_date' => $request->input('ending_date'),
                'scene' => $request->input('scene'),
                'soundcloud_url' => $request->input('soundcloud_url'),
                'spotify_url' => $request->input('spotify_url'),
                'youtube_url' => $request->input('youtube_url'),
                'deezer_url' => $request->input('deezer_url'),
                'actif' => $request->has('actif') && $request->input('actif') == '1',
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            DB::commit();

            notify()->success("L'artiste " . $artiste->name . ' a été créé avec succès.', 'Création réussie !🎉');

            return redirect()->route('admin.artistes.show', ['artisteId' => $artiste->id]);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            Log::error('Erreur de base de données lors de la création d\'un artiste', [
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
                    'Une erreur de base de données s\'est produite lors de la création de l\'artiste. L\'équipe technique a été notifiée.',
                    'Erreur de base de données'
                );
            }

            return back()->withInput();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erreur générale lors de la création d\'un artiste', [
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
                    'Une erreur inattendue s\'est produite lors de la création de l\'artiste. L\'équipe technique a été notifiée.',
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
        $artiste = Artiste::findOrFail($id);

        return view('admin.artistes.show', compact('artiste'));
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
        $artiste = Artiste::findOrFail($id);
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'style' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'photo' => 'nullable|file|mimes:webp|max:4096',
            'day' => 'nullable|in:Vendredi,Samedi,Dimanche',
            'begin_date' => 'required|date',
            'ending_date' => 'required|date|after:begin_date',
            'scene' => 'nullable|string|max:500',
            'soundcloud_url' => 'nullable|url|max:500',
            'spotify_url' => 'nullable|url|max:500',
            'youtube_url' => 'nullable|url|max:500',
            'deezer_url' => 'nullable|url|max:500',
            'actif' => 'boolean',
        ], [
            'name.required' => 'Le nom de l\'artiste est obligatoire.',
            'begin_date.required' => 'La date de début est obligatoire.',
            'ending_date.required' => 'La date de fin est obligatoire.',
            'ending_date.after' => 'La date de fin doit être après la date de début.',
            'photo.mimes' => 'La photo doit être au format WEBP uniquement.',
            'photo.max' => 'La photo ne doit pas dépasser 4MB.',
        ]);

        if ($validator->fails()) {
            $errorMessages = [];
            foreach ($validator->errors()->messages() as $field => $messages) {
                $fieldNames = [
                    'name' => 'Nom',
                    'style' => 'Style',
                    'description' => 'Description',
                    'photo' => 'Photo',
                    'day' => 'Jour',
                    'begin_date' => 'Date de début',
                    'ending_date' => 'Date de fin',
                    'scene' => 'Scène',
                    'soundcloud_url' => 'URL SoundCloud',
                    'spotify_url' => 'URL Spotify',
                    'youtube_url' => 'URL YouTube',
                    'deezer_url' => 'URL Deezer',
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

            Log::warning("Erreur de validation lors de la crétion de l'artiste", [
                'errors' => $validator->errors(),
                'user_id' => $user->id,
            ]);

            return back()->withErrors($validator->errors())->withInput();
        }

        try {
            DB::beginTransaction();

            $updateData = [
                'name' => $request->input('name'),
                'style' => $request->input('style'),
                'description' => $request->input('description'),
                'day' => $request->input('day'),
                'begin_date' => $request->input('begin_date'),
                'ending_date' => $request->input('ending_date'),
                'scene' => $request->input('scene'),
                'soundcloud_url' => $request->input('soundcloud_url'),
                'spotify_url' => $request->input('spotify_url'),
                'youtube_url' => $request->input('youtube_url'),
                'deezer_url' => $request->input('deezer_url'),
                'actif' => $request->has('actif') && $request->input('actif') == '1',
                'updated_by' => $user->id,
            ];

            // 📸 GESTION PHOTO MISE À JOUR
            if ($request->hasFile('photo')) {
                // Supprimer l'ancienne photo si elle existe
                if ($artiste->photo) {
                    $oldPhotoPath = public_path($artiste->photo);
                    if (File::exists($oldPhotoPath)) {
                        File::delete($oldPhotoPath);
                    }
                }

                $file = $request->file('photo');

                // Nouveau nom basé sur le nom modifié
                $filename = strtoupper($request->input('name')) . '.webp';

                // Dossier de destination
                $destinationPath = public_path('img/artists/photos/Photos_artistes');

                // Créer le dossier s'il n'existe pas
                if (! File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                // Déplacer le fichier
                $file->move($destinationPath, $filename);

                // Mettre à jour le chemin
                $updateData['photo'] = 'img/artists/photos/Photos_artistes/' . $filename;
            }
            // Si le nom a changé mais pas de nouvelle photo, renommer l'ancienne
            elseif ($artiste->name !== $request->input('name') && $artiste->photo) {
                $oldPhotoPath = public_path($artiste->photo);
                $newFilename = strtoupper($request->input('name')) . '.webp';
                $newPhotoPath = public_path('img/artists/photos/Photos_artistes/' . $newFilename);

                if (File::exists($oldPhotoPath)) {
                    File::move($oldPhotoPath, $newPhotoPath);
                    $updateData['photo'] = 'img/artists/photos/Photos_artistes/' . $newFilename;
                }
            }

            $artiste->update($updateData);

            DB::commit();

            notify()->success("L'artiste {$artiste->name} a été modifié avec succès.", 'Modification réussie ! 🎉');

            return redirect()->route('admin.artistes.show', $artiste->id);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            Log::error('Erreur de base de données lors de la modification d\'un artiste', [
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
                    'Une erreur de base de données s\'est produite lors de la modification de l\'artiste. L\'équipe technique a été notifiée.',
                    'Erreur de base de données'
                );
            }

            return back()->withInput();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erreur générale lors de la modification d\'un artiste', [
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
                    'Une erreur inattendue s\'est produite lors de la modification de l\'artiste. L\'équipe technique a été notifiée.',
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
        $artiste = Artiste::findOrFail($id);
        $user = Auth::user();
        try {
            DB::beginTransaction();

            $artiste->update([
                'actif' => false,
                'updated_by' => $user->id,
            ]);

            DB::commit();

            notify()->success("L'artiste {$artiste->name} a été masqué avec succès.", 'Masquage réussi ! 🎉');

            return redirect()->route('admin.artistes.index');
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            Log::error('Erreur de base de données lors de la modification du statut de l\'artiste', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'name' => $artiste->name,
                'user_id' => $user->id,
            ]);

            if (config('app.debug')) {
                notify()->error(
                    "Erreur de base de données : {$e->getMessage()}",
                    'Erreur technique détaillée'
                );
            } else {
                notify()->error(
                    'Une erreur de base de données s\'est produite lors de la modification du statut de l\'artiste. L\'équipe technique a été notifiée.',
                    'Erreur de base de données'
                );
            }

            return back()->withInput();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erreur générale lors de la modification du statut de l\'artiste', [
                'message' => $e->getMessage(),
                'name' => $artiste->name,
                'user_id' => $user->id,
            ]);

            if (config('app.debug')) {
                notify()->error(
                    "Erreur technique : {$e->getMessage()} (Ligne {$e->getLine()})",
                    'Erreur technique détaillée'
                );
            } else {
                notify()->error(
                    'Une erreur inattendue s\'est produite lors de la modification du statut de l\'artiste. L\'équipe technique a été notifiée.',
                    'Erreur technique'
                );
            }

            return back()->withInput();
        }
    }
}
