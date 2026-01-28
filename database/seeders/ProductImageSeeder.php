<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductsImage;
use App\Models\Size;
use App\Models\Color;
use App\Models\ProductsVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImageSeeder extends Seeder
{
    public function run()
    {
        //  Désactive les clés étrangères pour éviter les erreurs de contrainte
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ProductsImage::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // T-shirt Blanc Classique
        $classicBlanc = DB::table('products')
            ->where('slug', 'tshirt-classique')
            ->value('id');

        $variantBlanc = DB::table('products_variants')
            ->where('product_id', $classicBlanc)
            ->where('color_id', DB::table('colors')->where('name', 'blanc')->value('id'))
            ->value('id');

        $imagesClassicBlanc = [
            ['image' => 'img/boutique/products/tshirt-classique_blanc_1.jpg', 'ordre' => 1],
            ['image' => 'img/boutique/products/tshirt-classique_blanc_2.jpg', 'ordre' => 2],
            ['image' => 'img/boutique/products/tshirt-classique_blanc_3.jpg', 'ordre' => 3],
            ['image' => 'img/boutique/products/tshirt-classique_blanc_4.jpg', 'ordre' => 4],
            ['image' => 'img/boutique/products/tshirt-classique_blanc_5.jpg', 'ordre' => 5],
        ];

        foreach ($imagesClassicBlanc as $img) {
            DB::table('products_images')->insert([
                'product_id' => $classicBlanc,
                'variant_id' => $variantBlanc,
                'image' => $img['image'],
                'ordre' => $img['ordre'],
            ]);
        }

        // T-shirt Violet Collector
        $collectorViolet = DB::table('products')
            ->where('slug', 'tshirt-collector')
            ->value('id');

        $variantViolet = DB::table('products_variants')
            ->where('product_id', $collectorViolet)
            ->where('color_id', DB::table('colors')->where('name', 'violet')->value('id'))
            ->value('id');

        $imagesCollectorViolet = [
            ['image' => 'img/boutique/products/tshirt-collector_violet_1.jpg', 'ordre' => 1],
            ['image' => 'img/boutique/products/tshirt-collector_violet_2.jpg', 'ordre' => 2],
            ['image' => 'img/boutique/products/tshirt-collector_violet_3.jpg', 'ordre' => 3],
            ['image' => 'img/boutique/products/tshirt-collector_violet_4.jpg', 'ordre' => 4],
            ['image' => 'img/boutique/products/tshirt-collector_violet_5.jpg', 'ordre' => 5],
        ];

        foreach ($imagesCollectorViolet as $img) {
            DB::table('products_images')->insert([
                'product_id' => $collectorViolet,
                'variant_id' => $variantViolet,
                'image' => $img['image'],
                'ordre' => $img['ordre'],
            ]);
        }

        // Pull Zippé Vert
        $pullId = DB::table('products')->where('slug', 'pull-zippe')->value('id');
        $variantPull = DB::table('products_variants')
            ->where('product_id', $pullId)
            ->where('color_id', DB::table('colors')->where('name', 'vert')->value('id'))
            ->value('id');

        DB::table('products_images')->insert([
            'product_id' => $pullId,
            'variant_id' => $variantPull,
            'image' => 'img/boutique/products/pull-zippe_vert_1.jpg',
            'ordre' => 1,
        ]);

        // Gourde 25 cl Noire
        $gourdeId = DB::table('products')->where('slug', 'gourde-25cl')->value('id');

        $gourdeImages = [
            ['image' => 'img/boutique/products/gourde-25cl_1.jpg', 'ordre' => 1],
            ['image' => 'img/boutique/products/gourde-25cl_2.jpg', 'ordre' => 2],
            ['image' => 'img/boutique/products/gourde-25cl_3.jpg', 'ordre' => 3],
        ];

        foreach ($gourdeImages as $img) {
            DB::table('products_images')->insert([
                'product_id' => $gourdeId,
                'variant_id' => null,
                'image' => $img['image'],
                'ordre' => $img['ordre'],
            ]);
        }

        // Lunette Bleu
        $lunettesBleuId = DB::table('products')->where('slug', 'lunettes-calan')->value('id');
        $variantBleu = DB::table('products_variants')
            ->where('product_id', $lunettesBleuId)
            ->where('color_id', DB::table('colors')->where('name', 'bleu')->value('id'))
            ->value('id');

        $lunettesBleuImages = [
            ['image' => 'img/boutique/products/lunettes-calan_bleu_1.jpg', 'ordre' => 1],
            ['image' => 'img/boutique/products/lunettes-calan_bleu_2.jpg', 'ordre' => 2],
        ];

        foreach ($lunettesBleuImages as $img) {
            DB::table('products_images')->insert([
                'product_id' => $lunettesBleuId,
                'variant_id' => $variantBleu,
                'image' => $img['image'],
                'ordre' => $img['ordre'],
            ]);
        }

        // Lunette Rouge
        $variantRouge = DB::table('products_variants')
            ->where('product_id', $lunettesBleuId)
            ->where('color_id', DB::table('colors')->where('name', 'rouge')->value('id'))
            ->value('id');

        $lunettesRougeImages = [
            ['image' => 'img/boutique/products/lunettes-calan_rouge_1.jpg', 'ordre' => 1],
            ['image' => 'img/boutique/products/lunettes-calan_rouge_2.jpg', 'ordre' => 2],
        ];

        foreach ($lunettesRougeImages as $img) {
            DB::table('products_images')->insert([
                'product_id' => $lunettesBleuId,
                'variant_id' => $variantRouge,
                'image' => $img['image'],
                'ordre' => $img['ordre'],
            ]);
        }

        // Bandana Violet
        $bandanaId = DB::table('products')->where('slug', 'bandana')->value('id');
        DB::table('products_images')->insert([
            'product_id' => $bandanaId,
            'variant_id' => null,
            'image' => 'img/boutique/products/bandana_violet_1.jpg',
            'ordre' => 1,
        ]);

        // Tot-Bag Blanc
        $totBagId = DB::table('products')->where('slug', 'tot-bag')->value('id');
        DB::table('products_images')->insert([
            'product_id' => $totBagId,
            'variant_id' => null,
            'image' => 'img/boutique/products/tot-bag_blanc_1.jpg',
            'ordre' => 1,
        ]);
    }
}
