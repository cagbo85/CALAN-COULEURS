<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    public function run()
    {
        // Désactive les clés étrangères pour éviter les erreurs de contrainte
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Color::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $colors = [
            ['name' => 'blanc',  'hex_code' => '#FFFFFF'],
            ['name' => 'noir',   'hex_code' => '#000000'],
            ['name' => 'violet', 'hex_code' => '#8F1E98'],
            ['name' => 'rose',   'hex_code' => '#FF0F63'],
            ['name' => 'bleu',   'hex_code' => '#272AC7'],
            ['name' => 'vert',   'hex_code' => '#00695B'],
            ['name' => 'jaune',  'hex_code' => '#FFBF00'],
            ['name' => 'rouge',  'hex_code' => '#FF0000'],
        ];

        foreach ($colors as $i => $color) {
            Color::create([
                'name' => $color['name'],
                'hex_code' => $color['hex_code'],
                'ordre' => $i,
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }
    }
}
