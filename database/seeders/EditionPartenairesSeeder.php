<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EditionPartenairesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Désactiver contraintes FK pour permettre truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('edition_partenaires')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $now = Carbon::now();

        // Récupère la première édition
        $edition = DB::table('editions')->first();

        if (!$edition) {
            $this->command->warn('⚠️ Aucune édition trouvée. Exécute d’abord le EditionSeeder.');
            return;
        }

        // Récupère tous les partenaires
        $partenaires = DB::table('partenaires')->get();

        if ($partenaires->isEmpty()) {
            $this->command->warn('⚠️ Aucun partenaire trouvé. Exécute d’abord le PartenaireSeeder.');
            return;
        }

        foreach ($partenaires as $partenaire) {
            DB::table('edition_partenaires')->insert([
                'edition_id' => $edition->id,
                'partenaire_id' => $partenaire->id,
                'actif' => true,
                'created_at' => $now,
            ]);
        }
    }
}
