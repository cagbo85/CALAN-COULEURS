<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //
        $this->call([
            EditionSeeder::class,
            ArtisteSeeder::class,
            StandSeeder::class,
            PartenaireSeeder::class,
            SizeSeeder::class,
            ColorSeeder::class,
            FaqSeeder::class,
            ProductSeeder::class,
            EditionArtistesSeeder::class,
            EditionStandsSeeder::class,
            EditionPartenairesSeeder::class,
        ]);
    }
}
