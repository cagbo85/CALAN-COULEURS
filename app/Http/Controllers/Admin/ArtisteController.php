<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artiste;
use App\Models\Edition;
use App\Models\Performance;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
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
     * Récupérer les artistes groupés par jour pour l'édition courante UNIQUEMENT
     */
    public function getArtistsGroupedByDayCurrentEdition()
    {
        $currentEdition = Edition::getCurrentEdition();

        if (! $currentEdition) {
            return response()->json([
                'message' => 'Aucune édition courante disponible',
            ], 404);
        }

        $artists = DB::table('artistes as a')
            ->join('performances as p', 'a.id', '=', 'p.artiste_id')
            ->join('editions as e', 'p.edition_id', '=', 'e.id')
            ->select(
                'p.day',
                DB::raw('DATE_FORMAT(MIN(p.begin_date), "%W %e %M") AS jour_rep'),
                DB::raw('DATE_FORMAT(MIN(p.begin_date), "%Hh") as heu_min'),
                DB::raw('DATE_FORMAT(MAX(p.ending_date), "%Hh") as heu_max'),
                DB::raw('GROUP_CONCAT(DISTINCT a.name ORDER BY p.begin_date SEPARATOR ", ") as artistes'),
                DB::raw('GROUP_CONCAT(DISTINCT a.id ORDER BY p.begin_date SEPARATOR ",") as artist_ids')
            )
            ->where('p.actif', 1)
            ->where('e.id', $currentEdition->id)
            ->groupBy('p.day')
            ->orderBy(DB::raw('MIN(p.begin_date)'))
            ->get();

        return response()->json([
            'edition' => $currentEdition,
            'artists' => $artists,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.artistes.create');
    }

    /**
     * Afficher le formulaire de création d'une performance pour une édition
     */
    public function createPerformance($editionId)
    {
        $edition = Edition::findOrFail($editionId);
        $artistes = Artiste::orderBy('name')->get();

        return view('admin.editions.performances.create', compact('edition', 'artistes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storePerformance(Request $request, $editionId)
    {
        Edition::findOrFail($editionId);
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'artiste_id' => 'required|integer|exists:artistes,id',
            'day' => 'nullable|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi,Dimanche',
            'scene' => 'nullable|in:Extérieur,Intérieur',
            'begin_date' => 'nullable|date',
            'ending_date' => 'nullable|date|after:begin_date',
            'actif' => 'boolean',
        ], [
            'artiste_id.required' => 'L\'artiste est obligatoire.',
            'artiste_id.integer' => 'L\'ID de l\'artiste doit être un entier.',
            'artiste_id.exists' => 'L\'artiste sélectionné n\'existe pas.',
            'day.in' => 'Le jour de la performance doit être un jour de la semaine valide.',
            'scene.in' => 'La scène de la performance doit être "Extérieur" ou "Intérieur".',
            'begin_date.date' => 'La date de début doit être une date valide.',
            'ending_date.date' => 'La date de fin doit être une date valide.',
            'ending_date.after' => 'La date de fin doit être après la date de début.',
        ]);

        if ($validator->fails()) {
            notify()->error(
                'Un problème a été détecté dans le formulaire. Veuillez vérifier les champs marqués en rouge.',
                'Erreur de validation'
            );

            Log::warning("Erreur de validation lors de la création d'une performance", [
                'errors' => $validator->errors(),
                'user_id' => $user->id,
            ]);

            return back()->withErrors($validator->errors())->withInput();
        }

        try {
            DB::beginTransaction();

            $beginDate = $request->date('begin_date');
            $endingDate = $request->date('ending_date');

            // Calcul du jour de la semaine basé sur la date de début
            $dayMap = [
                1 => 'Lundi',
                2 => 'Mardi',
                3 => 'Mercredi',
                4 => 'Jeudi',
                5 => 'Vendredi',
                6 => 'Samedi',
                7 => 'Dimanche',
            ];
            $computedDay = $dayMap[$beginDate->dayOfWeekIso];

            // Doublon exact
            $exactDuplicate = Performance::query()
                ->where('edition_id', $editionId)
                ->where('artiste_id', $request->input('artiste_id'))
                ->where('scene', $request->input('scene'))
                ->where('begin_date', $beginDate)
                ->where('ending_date', $endingDate)
                ->exists();

            if ($exactDuplicate) {
                DB::rollBack();
                notify()->warning('Cette performance existe déjà exactement à l\'identique.', 'Doublon détecté ! ⚠️');

                return back()->withErrors([
                    'begin_date' => 'Cette performance existe déjà (même artiste, même scène, mêmes horaires).',
                ])->withInput();
            }

            // Chevauchement artiste, impossible de jouer 2 sets en même temps
            $artistConflict = Performance::query()
                ->where('edition_id', $editionId)
                ->where('artiste_id', $request->input('artiste_id'))
                ->where('begin_date', '<', $endingDate)
                ->where('ending_date', '>', $beginDate)
                ->exists();

            if ($artistConflict) {
                DB::rollBack();
                notify()->warning('Cet artiste est déjà programmé sur un créneau qui se chevauche.', 'Conflit artiste ! ⚠️');

                return back()->withErrors([
                    'artiste_id' => 'Cet artiste est déjà programmé sur ce créneau (ou un créneau qui se chevauche).',
                ])->withInput();
            }

            // Chevauchement scène: la scène ne peut accueillir qu'une perf à la fois
            $sceneConflict = Performance::query()
                ->where('edition_id', $editionId)
                ->where('scene', $request->input('scene'))
                ->where('begin_date', '<', $endingDate)
                ->where('ending_date', '>', $beginDate)
                ->exists();

            if ($sceneConflict) {
                DB::rollBack();
                notify()->warning('Le créneau est déjà occupé sur cette scène.', 'Conflit scène ! ⚠️');

                return back()->withErrors([
                    'scene' => 'Ce créneau est déjà pris sur cette scène (chevauchement détecté).',
                ])->withInput();
            }

            Performance::create([
                'edition_id' => $editionId,
                'artiste_id' => $request->input('artiste_id'),
                'begin_date' => $beginDate,
                'ending_date' => $endingDate,
                'scene' => $request->input('scene'),
                'day' => $computedDay,
                'actif' => $request->boolean('actif'),
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            DB::commit();

            notify()->success("La performance de l'artiste a été créée avec succès.", 'Création réussie ! 🎉');

            return redirect()->route('admin.artistes.show', ['artisteId' => $request->input('artiste_id')]);
        } catch (QueryException $e) {
            DB::rollBack();

            Log::error('Erreur de base de données lors de la création d\'une performance', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'artiste_id' => $request->input('artiste_id'),
                'user_id' => $user->id,
            ]);

            if (config('app.debug')) {
                notify()->error(
                    "Erreur de base de données : {$e->getMessage()}",
                    'Erreur technique détaillée'
                );
            } else {
                notify()->error(
                    'Une erreur de base de données s\'est produite lors de la création d\'une performance. L\'équipe technique a été notifiée.',
                    'Erreur de base de données'
                );
            }

            return back()->withInput();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erreur générale lors de la création d\'une performance', [
                'message' => $e->getMessage(),
                'artiste_id' => $request->input('artiste_id'),
                'user_id' => $user->id,
            ]);

            if (config('app.debug')) {
                notify()->error(
                    "Erreur technique : {$e->getMessage()} (Ligne {$e->getLine()})",
                    'Erreur technique détaillée'
                );
            } else {
                notify()->error(
                    'Une erreur inattendue s\'est produite lors de la création d\'une performance. L\'équipe technique a été notifiée.',
                    'Erreur technique'
                );
            }

            return back()->withInput();
        }
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
            'photo' => 'nullable|file|mimes:webp|max:4096',
            'soundcloud_url' => 'nullable|url|max:500',
            'spotify_url' => 'nullable|url|max:500',
            'youtube_url' => 'nullable|url|max:500',
            'deezer_url' => 'nullable|url|max:500',
        ], [
            'name.required' => 'Le nom de l\'artiste est obligatoire.',
            'photo.mimes' => 'La photo doit être au format WEBP uniquement.',
            'photo.max' => 'La photo ne doit pas dépasser 4MB.',
            'soundcloud_url.url' => 'L\'URL SoundCloud doit être valide.',
            'spotify_url.url' => 'L\'URL Spotify doit être valide.',
            'youtube_url.url' => 'L\'URL YouTube doit être valide.',
            'deezer_url.url' => 'L\'URL Deezer doit être valide.',
        ]);

        if ($validator->fails()) {
            notify()->error(
                'Un problème a été détecté dans le formulaire. Veuillez vérifier les champs marqués en rouge.',
                'Erreur de validation'
            );

            Log::warning("Erreur de validation lors de la création d'un(e) artiste", [
                'errors' => $validator->errors(),
                'user_id' => $user->id,
            ]);

            return back()->withErrors($validator->errors())->withInput();
        }

        $storedPhotoPath = null;

        try {
            DB::beginTransaction();

            if ($request->hasFile('photo')) {
                $storedPhotoPath = $this->storeArtistPhoto($request->file('photo'), $request->input('name'));
            }

            $artiste = Artiste::create([
                'name' => trim((string) $request->input('name')),
                'style' => $request->filled('style') ? trim((string) $request->input('style')) : null,
                'description' => $request->filled('description') ? trim((string) $request->input('description')) : null,
                'photo' => $storedPhotoPath,
                'soundcloud_url' => $request->filled('soundcloud_url') ? trim((string) $request->input('soundcloud_url')) : null,
                'spotify_url' => $request->filled('spotify_url') ? trim((string) $request->input('spotify_url')) : null,
                'youtube_url' => $request->filled('youtube_url') ? trim((string) $request->input('youtube_url')) : null,
                'deezer_url' => $request->filled('deezer_url') ? trim((string) $request->input('deezer_url')) : null,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            DB::commit();

            notify()->success("L'artiste {$artiste->name} a été créé avec succès.", 'Création réussie ! 🎉');

            return redirect()->route('admin.artistes.show', ['artisteId' => $artiste->id]);
        } catch (QueryException $e) {
            DB::rollBack();

            if ($storedPhotoPath) {
                $absolutePath = public_path($storedPhotoPath);
                if (File::exists($absolutePath)) {
                    File::delete($absolutePath);
                }
            }

            Log::error('Erreur de base de données lors de la création d\'un artiste', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'name' => $request->input('name'),
                'user_id' => $user->id,
            ]);

            notify()->error(
                config('app.debug')
                    ? "Erreur de base de données : {$e->getMessage()}"
                    : 'Une erreur de base de données s\'est produite lors de la création de l\'artiste. L\'équipe technique a été notifiée.',
                config('app.debug') ? 'Erreur technique détaillée' : 'Erreur de base de données'
            );

            return back()->withInput();
        } catch (\Exception $e) {
            DB::rollBack();

            if ($storedPhotoPath) {
                $absolutePath = public_path($storedPhotoPath);
                if (File::exists($absolutePath)) {
                    File::delete($absolutePath);
                }
            }

            Log::error('Erreur générale lors de la création d\'un artiste', [
                'message' => $e->getMessage(),
                'name' => $request->input('name'),
                'user_id' => $user->id,
            ]);

            notify()->error(
                config('app.debug')
                    ? "Erreur technique : {$e->getMessage()} (Ligne {$e->getLine()})"
                    : 'Une erreur inattendue s\'est produite lors de la création de l\'artiste. L\'équipe technique a été notifiée.',
                config('app.debug') ? 'Erreur technique détaillée' : 'Erreur technique'
            );

            return back()->withInput();
        }
    }

    /**
     * Stocker la photo d'un artiste et retourner le chemin relatif pour la base de données
     */
    private function storeArtistPhoto($file, string $artistName): string
    {
        $filename = mb_strtoupper($artistName, 'UTF-8') . '.webp';
        $destinationPath = public_path('img/artists/photos/Photos_artistes');

        if (! File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        $file->move($destinationPath, $filename);

        return 'img/artists/photos/Photos_artistes/' . $filename;
    }

    /**
     * Afficher les détails d'un artiste
     */
    public function show(string $id)
    {
        $artiste = $this->getArtisteDetails($id);
        $performances = $this->getArtistePerformances($id);

        return view('admin.artistes.show', compact('artiste', 'performances'));
    }

    /**
     * Récupérer les détails d'un artiste
     */
    public function getArtisteDetails(string $id)
    {
        return DB::table('artistes as a')
            ->select(
                'a.*',
                DB::raw('DATE_FORMAT(a.updated_at, "%d/%m/%Y %H:%i") AS formatted_updated_at'),
                'u.login as updated_by_login',
                'u2.login as created_by_login'
            )
            ->join('users as u', 'u.id', '=', 'a.updated_by')
            ->join('users as u2', 'u2.id', '=', 'a.created_by')
            ->where('a.id', $id)
            ->first();
    }

    /**
     * Récupérer les performances d'un artiste
     */
    public function getArtistePerformances(string $id)
    {
        return DB::table('performances as p')
            ->join('editions as e', 'e.id', '=', 'p.edition_id')
            ->select(
                'p.id',
                'p.edition_id',
                'p.artiste_id',
                'p.day',
                'p.scene',
                'p.actif',
                'e.year as edition_year',
                'e.name as edition_name',
                DB::raw("CASE
                        WHEN e.status LIKE 'draft' THEN 'En projet'
                        WHEN e.status LIKE 'upcoming' THEN 'À venir'
                        WHEN e.status LIKE 'ongoing' THEN 'En cours'
                        WHEN e.status LIKE 'past' THEN 'Passée'
                        WHEN e.status LIKE 'archived' THEN 'Archivée'
                    ELSE 'Non répertoriée'
                END as status
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
                'e.actif',
                DB::raw("CASE
                        WHEN e.actif = 1 THEN 'fa-solid fa-eye'
                        WHEN e.actif = 0 THEN 'fa-solid fa-eye-slash'
                        ELSE 'fa-solid fa-eye'
                END as actifIcon
                "),
                DB::raw("CASE
                        WHEN e.actif = 1 THEN 'Visible'
                        WHEN e.actif = 0 THEN 'Masquée'
                        ELSE 'Non défini'
                END as actifLabel
                "),
                DB::raw("CASE
                        WHEN e.actif = 1 THEN 'green'
                        WHEN e.actif = 0 THEN 'gray'
                        ELSE 'green'
                END as actifColor
                "),
                DB::raw('DATE_FORMAT(p.begin_date, "%d/%m/%Y %H:%i") as formatted_begin_date'),
                DB::raw('DATE_FORMAT(p.ending_date, "%d/%m/%Y %H:%i") as formatted_ending_date'),
                'p.begin_date',
                'p.ending_date'
            )
            ->where('p.artiste_id', $id)
            ->orderByDesc('e.year')
            ->orderByDesc('p.begin_date')
            ->orderByDesc('p.id')
            ->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Modifier les détails d'un artiste (Info générales & ses performances associées)
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
            'soundcloud_url' => 'nullable|url|max:500',
            'spotify_url' => 'nullable|url|max:500',
            'youtube_url' => 'nullable|url|max:500',
            'deezer_url' => 'nullable|url|max:500',
            'performances' => 'nullable|array',
            'performances.*.day' => 'nullable|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi,Dimanche',
            'performances.*.scene' => 'nullable|in:Extérieur,Intérieur',
            'performances.*.begin_date' => 'nullable|date',
            'performances.*.ending_date' => 'nullable|date|after_or_equal:performances.*.begin_date',
            'performances.*.actif' => 'nullable|boolean',
            'performances.*.id' => 'required|integer|exists:performances,id',
        ], [
            'name.required' => 'Le nom de l\'artiste est obligatoire.',
            'photo.mimes' => 'La photo doit être au format WEBP uniquement.',
            'photo.max' => 'La photo ne doit pas dépasser 4MB.',
            'performances.*.day.in' => 'Le jour de la performance doit être un jour de la semaine valide.',
            'performances.*.scene.in' => 'La scène de la performance doit être "Extérieur" ou "Intérieur".',
            'performances.*.ending_date.after_or_equal' => 'La date de fin de la performance doit être après ou égale à la date de début.',
            'performances.*.id.exists' => 'La performance spécifiée n\'existe pas.',
            'soundcloud_url.url' => 'L\'URL SoundCloud doit être valide.',
            'spotify_url.url' => 'L\'URL Spotify doit être valide.',
            'youtube_url.url' => 'L\'URL YouTube doit être valide.',
            'deezer_url.url' => 'L\'URL Deezer doit être valide.',
        ]);

        if ($validator->fails()) {
            notify()->error(
                'Un problème a été détecté dans le formulaire. Veuillez vérifier les champs marqués en rouge.',
                'Erreur de validation'
            );

            Log::warning("Erreur de validation lors de la modification d'un artiste", [
                'errors' => $validator->errors(),
                'user_id' => $user->id,
            ]);

            return back()->withErrors($validator->errors())->withInput();
        }

        try {
            DB::beginTransaction();

            $updateArtistsData = [
                'name' => $request->input('name'),
                'style' => $request->input('style'),
                'description' => $request->input('description'),
                'soundcloud_url' => $request->input('soundcloud_url'),
                'spotify_url' => $request->input('spotify_url'),
                'youtube_url' => $request->input('youtube_url'),
                'deezer_url' => $request->input('deezer_url'),
                'actif' => $request->has('actif') && $request->input('actif') == '1',
                'updated_by' => $user->id,
            ];

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
                $filename = mb_strtoupper(trim($request->input('name')), 'UTF-8') . '.webp';

                // Dossier de destination
                $destinationPath = public_path('img/artists/photos/Photos_artistes');

                // Créer le dossier s'il n'existe pas
                if (! File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                // Déplacer le fichier
                $file->move($destinationPath, $filename);

                // Mettre à jour le chemin
                $updateArtistsData['photo'] = 'img/artists/photos/Photos_artistes/' . $filename;
            }
            // Si le nom a changé mais pas de nouvelle photo, renommer l'ancienne
            elseif ($artiste->name !== $request->input('name') && $artiste->photo) {
                $oldPhotoPath = public_path($artiste->photo);
                $newFilename = mb_strtoupper(trim($request->input('name')), 'UTF-8') . '.webp';
                $newPhotoPath = public_path('img/artists/photos/Photos_artistes/' . $newFilename);

                if (File::exists($oldPhotoPath)) {
                    File::move($oldPhotoPath, $newPhotoPath);
                    $updateArtistsData['photo'] = 'img/artists/photos/Photos_artistes/' . $newFilename;
                }
            }

            $artiste->update($updateArtistsData);

            foreach ($request->input('performances', []) as $performanceId => $data) {
                $beginDate = ! empty($data['begin_date']) ? str_replace('T', ' ', $data['begin_date']) : null;
                $endingDate = ! empty($data['ending_date']) ? str_replace('T', ' ', $data['ending_date']) : null;

                Performance::where('id', $performanceId)
                    ->where('artiste_id', $artiste->id)
                    ->update([
                        'day' => $data['day'] ?? null,
                        'scene' => $data['scene'] ?? null,
                        'begin_date' => $beginDate,
                        'ending_date' => $endingDate,
                        'actif' => isset($data['actif']) ? $data['actif'] : 0,
                        'updated_by' => $user->id,
                    ]);
            }

            DB::commit();

            notify()->success("L'artiste {$artiste->name} a été modifié avec succès.", 'Modification réussie ! 🎉');

            return redirect()->route('admin.artistes.show', $artiste->id);
        } catch (QueryException $e) {
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
        } catch (QueryException $e) {
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

    /**
     * Récupérer les performances d'une édition spécifique
     */
    public function getPerformancesByEdition($editionId)
    {
        $edition = Edition::findOrFail($editionId);

        $performancesAssocies = DB::table('performances as p')
            ->join('artistes as a', 'p.artiste_id', '=', 'a.id')
            ->join('editions as e', 'p.edition_id', '=', 'e.id')
            ->select(
                'a.id as artiste_id',
                'a.name',
                'a.style',
                'a.photo',
                'p.id as performance_id',
                'p.begin_date',
                DB::raw('DATE_FORMAT(p.begin_date, "%H:%i") AS formatted_begin_date'),
                DB::raw('DATE_FORMAT(p.ending_date, "%H:%i") AS formatted_ending_date'),
                DB::raw('DATE_FORMAT(p.updated_at, "%d/%m/%Y %H:%i") AS formatted_updated_at'),
                'p.ending_date',
                'p.scene',
                'p.day',
                'p.actif',
                'p.created_by',
                'p.updated_by',
                'p.created_at',
                'p.updated_at'
            )
            ->where('e.id', $edition->id)
            ->orderBy('p.begin_date')
            ->get();

        $performancesDisponibles = Artiste::orderBy('name')->get();

        return view('admin.editions.performances.index', compact('edition', 'performancesAssocies', 'performancesDisponibles'));
    }

    /**
     * Associer une performance d'un artiste à une édition
     */
    public function attachPerformToEdition($editionId, $artisteId)
    {
        Edition::findOrFail($editionId);
        Artiste::findOrFail($artisteId);
        $user = Auth::user();

        Performance::create([
            'edition_id' => $editionId,
            'artiste_id' => $artisteId,
            'actif' => false,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        notify()->success('La performance de l\'artiste a été ajoutée à l\'édition avec succès.', 'Association réussie ! 🎉');

        return redirect()->route('admin.artistes.show', ['artisteId' => $artisteId]);
    }

    /**
     * Masquer une performance d'une édition sans la supprimer
     */
    public function hidePerformFromEdition($editionId, $artisteId)
    {
        $detach = DB::table('performances')
            ->where('edition_id', $editionId)
            ->where('artiste_id', $artisteId)
            ->update(['actif' => false]);

        if ($detach > 0) {
            notify()->success('La performance de l\'artiste a été masquée de l\'édition avec succès.', 'Masquage réussi ! 🎉');
        } else {
            notify()->warning('Aucune performance à masquer pour cet(te) artiste et cette édition.', 'Rien à masquer ⚠️');
        }

        return back();
    }

    /**
     * Rendre visible une performance d'une édition
     */
    public function showPerformFromEdition($editionId, $artisteId)
    {
        $show = DB::table('performances')
            ->where('edition_id', $editionId)
            ->where('artiste_id', $artisteId)
            ->update(['actif' => true]);

        if ($show > 0) {
            notify()->success('La performance de l\'artiste a été rendue visible pour l\'édition avec succès.', 'Affichage réussi ! 🎉');
        } else {
            notify()->warning('Aucune performance à afficher pour cet(te) artiste et cette édition.', 'Rien à afficher ⚠️');
        }

        return back();
    }

    /**
     * Supprimer définitivement une performance d'une édition
     */
    public function deletePerformFromEdition($editionId, $performanceId)
    {
        $performance = Performance::findOrFail($performanceId);

        try {
            $performance->delete();

            notify()->success('La performance a été supprimée avec succès.', 'Suppression réussie ! 🎉');

            return back();
        } catch (\Exception $e) {
            notify()->error('Erreur lors de la suppression de la performance.', 'Erreur ❌');
            Log::error('Erreur suppression performance', ['error' => $e->getMessage()]);

            return back();
        }
    }
}
