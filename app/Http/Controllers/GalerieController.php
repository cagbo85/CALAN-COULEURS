<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class GalerieController extends Controller
{
    /**
     * Afficher la galerie d'images pour les éditions archivées et passées
     */
    public function index()
    {
        $editions = $this->getArchivedAndPastEditions();

        if ($editions->isEmpty()) {
            return view('galerie', ['editions' => collect(), 'galleryByYear' => []]);
        }

        $galleryByYear = [];
        foreach ($editions as $edition) {
            $galleryByYear[$edition->year] = $this->loadGalleryImages('img/galerie/'.$edition->year.'/');
        }

        return view('galerie', compact('editions', 'galleryByYear'));
    }

    /**
     * Récupérer les éditions archivées et passées pour pouvoir afficher les photos associées dans la galerie
     */
    private function getArchivedAndPastEditions()
    {
        return DB::table('editions')
            ->select('id', 'year', 'name')
            ->whereIn('status', ['past', 'archived'])
            ->where('actif', true)
            ->orderByDesc('year')
            ->get();
    }

    /**
     * Récupérer toutes les images de la galerie dans le dossier donné.
     *
     * @param  string  $imgPath  Le chemin du dossier.
     * @return Collection<int, string> Collection des chemins relatifs des fichiers.
     */
    public function loadGalleryImages(string $imgPath)
    {
        $path = public_path($imgPath);

        if (! File::exists($path)) {
            return collect();
        }

        return collect(File::files($path))
            ->map(fn ($file) => $imgPath.$file->getFilename());
    }
}
