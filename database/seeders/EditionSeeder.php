<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        $editions = [
            [
                'year' => 2025,
                'name' => "Calan'Couleurs 2K25",
                'reservation_url' => 'https://www.helloasso.com/associations/calan-couleurs/evenements/festival-calan-couleurs',
                'begin_date' => '2025-09-12 19:00:00',
                'ending_date' => '2025-09-14 05:00:00',
                'actif' => true,
                'status' => 'archived',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'year' => 2026,
                'reservation_url' => 'https://www.helloasso.com/associations/calan-couleurs/evenements/festival-calan-couleurs-26-27-juin-2026',
                'name' => "Calan'Couleurs 2K26",
                'begin_date' => '2026-06-26 19:30:00',
                'ending_date' => '2026-06-28 03:00:00',
                'actif' => true,
                'status' => 'upcoming',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($editions as $edition) {
            DB::table('editions')->insert($edition);
        }
    }
}
