<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class GalerieController extends Controller
{
    /**
     * Load gallery images and display them.
     * 
     * @param Request $request The user HTTP request.
     * @return view The gallery view.
     */
    public function index(Request $request)
    {
        // User selected year, otherwise; select past year.
        $selectedYear = $request->input('year', date("Y",strtotime("-1 year")));

        $yearsPath = 'img/galerie/';

        $archivedYears = $this->getArchivedYears($yearsPath);

        $imgPath = 'img/galerie/' . $selectedYear . '/';

        $images = $this->loadGalleryImages($imgPath);

        return view('galerie', compact('archivedYears', 'images', 'selectedYear'));
    }


    /**
     * Get all gallery images in the given folder.
     * 
     * @param string $imgPath The folder path.
     * @return \Illuminate\Support\Collection<int, string>  Collection of relative file paths.
     */
    public function loadGalleryImages(string $imgPath){

        $path = public_path($imgPath);

        if (!File::exists($path)) {
            return collect();
        }

        return collect(File::files($path))
            ->map(fn ($file) => $imgPath . $file->getFilename());
    }


    /**
     * Return all the archived years of photos.
     * 
     * @param string $folderPath The path to the photos archive.
     * @return array All the archived years.
     */
    public function getArchivedYears(string $folderPath) : array
    {

        $path = public_path($folderPath);

        return collect(File::directories($path))
            ->map(fn ($folder) => basename($folder))
            ->toArray();
    }
}
