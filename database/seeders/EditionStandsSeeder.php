<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EditionStandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Désactiver contraintes FK pour permettre truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('edition_stands')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $now = Carbon::now();

        // Récupère la première édition
        $edition = DB::table('editions')->first();

        if (!$edition) {
            $this->command->warn('⚠️ Aucune édition trouvée. Exécute d’abord le EditionSeeder.');
            return;
        }

        // Récupère tous les stands
        $stands = DB::table('stands')->get();

        if ($stands->isEmpty()) {
            $this->command->warn('⚠️ Aucun stand trouvé. Exécute d’abord le StandSeeder.');
            return;
        }

        foreach ($stands as $stand) {
            DB::table('edition_stands')->insert([
                'edition_id' => $edition->id,
                'stand_id' => $stand->id,
                'actif' => true,
                'created_at' => $now,
            ]);
        }
    }
}
