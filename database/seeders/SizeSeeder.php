<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeSeeder extends Seeder
{
    public function run()
    {
        // Désactive les clés étrangères pour éviter les erreurs de contrainte
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Size::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'Unique'];
        foreach ($sizes as $i => $label) {
            Size::firstOrCreate(['label' => $label], [
                'ordre' => $i,
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }
    }
}
