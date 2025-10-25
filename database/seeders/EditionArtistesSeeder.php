<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EditionArtistesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Désactiver contraintes FK pour permettre truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('edition_artistes')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $now = Carbon::now();

        // Récupère la première édition
        $edition = DB::table('editions')->first();

        if (!$edition) {
            $this->command->warn('⚠️ Aucune édition trouvée. Exécute d’abord le EditionSeeder.');
            return;
        }

        $artistes = DB::table('artistes')->get();

        foreach ($artistes as $artiste) {
            DB::table('edition_artistes')->insert([
                'edition_id' => $edition->id,
                'artiste_id' => $artiste->id,
                'actif' => true,
                'created_at' => $now,
            ]);
        }
    }
}
