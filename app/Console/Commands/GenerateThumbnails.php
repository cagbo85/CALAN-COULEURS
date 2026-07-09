<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class GenerateThumbnails extends Command
{
    protected $signature = 'gallery:thumbnails';
    protected $description = 'Génère des miniatures WebP pour un dossier de photos';

    public function handle()
    {
        $folder = $this->ask("Nom du dossier à traiter (ex: 2026). Le nom du dossier doit être dans public/img/galerie/:");

        $sourcePath = public_path("img/galerie/$folder");
        $thumbPath = public_path("img/galerie/thumbnails/$folder");

        if (!File::exists($sourcePath)) {
            $this->error("❌ Le dossier $folder n'existe pas !");
            return;
        }

        if (!File::exists($thumbPath)) {
            File::makeDirectory($thumbPath, 0755, true);
        }

        $manager = ImageManager::usingDriver(Driver::class);

        $files = File::files($sourcePath);

        foreach ($files as $file) {
            $filename = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            $thumbFile = $thumbPath . '/' . $filename . '.webp';

            // Lire l'image
            $img = $manager->decode($file->getRealPath());

            // Redimensionner proportionnellement sans dépasser la taille originale
            $img->scaleDown(width: 800);

            // Encoder en WebP
            $encoded = $img->encode(new WebpEncoder(quality: 80));

            // Sauvegarder
            $encoded->save($thumbFile);

            $this->info("Miniature générée : $thumbFile");
        }

        $this->info("✔ Miniatures générées pour le dossier $folder !");
    }
}
