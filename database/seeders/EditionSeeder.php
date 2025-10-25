<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Désactiver contraintes FK pour permettre truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('editions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $now = Carbon::now();

        // Vérifie si l’édition 2025 existe déjà pour éviter les doublons
        $exists = DB::table('editions')->where('year', 2025)->exists();

        if ($exists) {
            $this->command->warn('⚠️ L’édition 2025 existe déjà, aucune insertion effectuée.');
            return;
        }

        DB::table('editions')->insert([
            'year' => 2025,
            'name' => "Calan'Couleurs 2K25",
            'begin_date' => '2025-09-12 19:00:00',
            'ending_date' => '2025-09-14 05:00:00',
            'actif' => true,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

    }
}
