<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EditionPartenaireSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('edition_partenaires')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $now = date('Y-m-d H:i:s');

        DB::table('edition_partenaires')->insert([
            [
                'edition_id' => 1,
                'partenaire_id' => 1,
                'actif' => 1,
                'created_at' => $now,
            ],
            [
                'edition_id' => 1,
                'partenaire_id' => 2,
                'actif' => 1,
                'created_at' => $now,
            ],
            [
                'edition_id' => 1,
                'partenaire_id' => 3,
                'actif' => 1,
                'created_at' => $now,
            ],
            [
                'edition_id' => 1,
                'partenaire_id' => 4,
                'actif' => 1,
                'created_at' => $now,
            ],
            [
                'edition_id' => 1,
                'partenaire_id' => 5,
                'actif' => 1,
                'created_at' => $now,
            ],
            [
                'edition_id' => 1,
                'partenaire_id' => 6,
                'actif' => 1,
                'created_at' => $now,
            ],
            [
                'edition_id' => 1,
                'partenaire_id' => 7,
                'actif' => 1,
                'created_at' => $now,
            ],
            [
                'edition_id' => 1,
                'partenaire_id' => 8,
                'actif' => 1,
                'created_at' => $now,
            ],
            [
                'edition_id' => 1,
                'partenaire_id' => 9,
                'actif' => 1,
                'created_at' => $now,
            ],
            [
                'edition_id' => 1,
                'partenaire_id' => 10,
                'actif' => 1,
                'created_at' => $now,
            ],
            [
                'edition_id' => 2,
                'partenaire_id' => 1,
                'actif' => 1,
                'created_at' => $now,
            ],
            [
                'edition_id' => 2,
                'partenaire_id' => 4,
                'actif' => 1,
                'created_at' => $now,
            ],
            [
                'edition_id' => 2,
                'partenaire_id' => 6,
                'actif' => 1,
                'created_at' => $now,
            ],
            [
                'edition_id' => 2,
                'partenaire_id' => 7,
                'actif' => 1,
                'created_at' => $now,
            ],
            [
                'edition_id' => 2,
                'partenaire_id' => 9,
                'actif' => 1,
                'created_at' => $now,
            ],
            [
                'edition_id' => 2,
                'partenaire_id' => 10,
                'actif' => 1,
                'created_at' => $now,
            ],
            [
                'edition_id' => 2,
                'partenaire_id' => 11,
                'actif' => 1,
                'created_at' => $now,
            ],
            [
                'edition_id' => 2,
                'partenaire_id' => 13,
                'actif' => 1,
                'created_at' => $now,
            ],
            [
                'edition_id' => 2,
                'partenaire_id' => 14,
                'actif' => 1,
                'created_at' => $now,
            ],
            [
                'edition_id' => 2,
                'partenaire_id' => 16,
                'actif' => 1,
                'created_at' => $now,
            ],
        ]);
    }
}
