<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Product;
use App\Models\ProductsVariant;
use App\Models\Size;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Désactive les clés étrangères pour éviter les erreurs de contrainte
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ProductsVariant::truncate();
        Product::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Récupère toutes les tailles et couleurs existantes
        $sizes = Size::pluck('id', 'label')->toArray(); // ['XS' => 1, ...]
        $colors = Color::pluck('id', 'name')->toArray(); // ['violet' => 1, ...]

        $uniqueSizeId = $sizes['Unique'] ?? null;

        $products = [
            [
                'title' => 'T-shirt Souvenir',
                'slug' => 'tshirt-souvenir-2025',
                'description' => 'T-shirt violet en souvenir de l\'édition 2025.',
                'detailed_description' => 'Disponible en plusieurs tailles. Coupe unisexe confortable.',
                'price' => 19.50,
                'old_price' => null,
                'is_featured' => false,
                'image' => 'img/boutique/tshirt-souvenir_violet.jpg',
                'category' => 'vetements',
                'badge' => 't-shirt',
                'colors' => ['violet'],
                'images' => [
                    'violet' => 'img/boutique/tshirt-souvenir_violet.jpg',
                ],
                'quantities' => [
                    'violet' => ['XS' => 0, 'S' => 8, 'M' => 0, 'L' => 8, 'XL' => 9, 'XXL' => 2],
                ],
            ],
            [
                'title' => 'T-shirt Officiel',
                'slug' => 'tshirt-officiel-2026',
                'description' => 'Le t-shirt officiel de l\'édition 2026 aux couleurs du festival !',
                'detailed_description' => 'Édition limitée 2026. Idéal pour afficher fièrement les couleurs cette année. Unisexe.',
                'price' => 19.50,
                'old_price' => null,
                'is_featured' => true,
                'image' => 'img/boutique/tshirt-officiel_bleu.jpg',
                'category' => 'vetements',
                'badge' => 't-shirt',
                'colors' => ['bleu'],
                'images' => [
                    'bleu' => 'img/boutique/tshirt-officiel_bleu.jpg',
                ],
                'quantities' => [
                    'bleu' => ['XS' => 0, 'S' => 45, 'M' => 70, 'L' => 65, 'XL' => 15, 'XXL' => 3],
                ],
            ],
            [
                'title' => 'T-shirt Classique',
                'slug' => 'tshirt-classique',
                'description' => 'Le t-shirt blanc intemporel Calan\'Couleurs.',
                'detailed_description' => 'Disponible en plusieurs tailles. Logo classique imprimé sur le cœur. Unisexe.',
                'price' => 19.50,
                'old_price' => null,
                'is_featured' => false,
                'image' => 'img/boutique/tshirt-classique_blanc.jpg',
                'category' => 'vetements',
                'badge' => 't-shirt',
                'colors' => ['blanc'],
                'images' => [
                    'blanc' => 'img/boutique/tshirt-classique_blanc.jpg',
                ],
                'quantities' => [
                    'blanc' => ['XS' => 0, 'S' => 9, 'M' => 11, 'L' => 22, 'XL' => 4, 'XXL' => 2],
                ],
            ],
            [
                'title' => 'Pull Demi-Zip',
                'slug' => 'pull-demi-zip',
                'description' => 'Pull chaud et doux demi-zip en édition verte.',
                'detailed_description' => 'Parfait pour les soirées fraîches du festival. Coupe unisexe.',
                'price' => 34.50,
                'old_price' => null,
                'is_featured' => false,
                'image' => 'img/boutique/pull-demi-zip_vert.jpg',
                'category' => 'vetements',
                'badge' => 'pull',
                'colors' => ['vert'],
                'images' => [
                    'vert' => 'img/boutique/pull-demi-zip_vert.jpg',
                ],
                'quantities' => [
                    'vert' => ['XS' => 0, 'S' => 2, 'M' => 0, 'L' => 3, 'XL' => 4, 'XXL' => 2],
                ],
            ],
            [
                'title' => 'Pull Demi-Zip Officiel',
                'slug' => 'pull-demi-zip-officiel',
                'description' => 'Le pull demi-zip officiel de l\'édition 2026.',
                'detailed_description' => 'Confortable, chaud et stylé pour matcher avec le thème bleu de cette année.',
                'price' => 34.50,
                'old_price' => null,
                'is_featured' => true,
                'image' => 'img/boutique/pull-demi-zip_bleu.jpg',
                'category' => 'vetements',
                'badge' => 'pull',
                'colors' => ['bleu'],
                'images' => [
                    'bleu' => 'img/boutique/pull-demi-zip_bleu.jpg',
                ],
                'quantities' => [
                    'bleu' => ['XS' => 0, 'S' => 7, 'M' => 13, 'L' => 13, 'XL' => 7, 'XXL' => 3],
                ],
            ],
            [
                'title' => 'Sweat à Capuche Officiel',
                'slug' => 'sweat-capuche-officiel-2026',
                'description' => 'Le sweat à capuche confortable aux couleurs de l\'édition 2026.',
                'detailed_description' => 'Molleton doux à l\'intérieur, grande capuche protectrice. Le must-have de cette année.',
                'price' => 30.00,
                'old_price' => null,
                'is_featured' => true,
                'image' => 'img/boutique/sweat_bleu.jpg',
                'category' => 'vetements',
                'badge' => 'pull',
                'colors' => ['bleu'],
                'images' => [
                    'bleu' => 'img/boutique/sweat_bleu.jpg',
                ],
                'quantities' => [
                    'bleu' => ['XS' => 0, 'S' => 8, 'M' => 13, 'L' => 13, 'XL' => 7, 'XXL' => 3],
                ],
            ],
            [
                'title' => 'Lunettes Calan',
                'slug' => 'lunettes-calan',
                'description' => 'Lunettes de soleil stylées, protection UV.',
                'detailed_description' => 'Coloris bleu ou rouge, pour tous les genres.',
                'price' => 3.00,
                'old_price' => null,
                'is_featured' => false,
                'image' => 'img/boutique/lunettes-calan_rouge.jpg',
                'category' => 'accessoires',
                'badge' => 'accessoire',
                'colors' => ['rouge', 'bleu'],
                'images' => [
                    'rouge' => 'img/boutique/lunettes-calan_rouge.jpg',
                    'bleu' => 'img/boutique/lunettes-calan_bleu.jpg',
                ],
                'quantities' => [
                    'rouge' => ['Unique' => 3],
                    'bleu' => ['Unique' => 7],
                ],
            ],
            [
                'title' => 'Tot bag Classique',
                'slug' => 'tot-bag',
                'description' => 'Tot bag en toile écoresponsable.',
                'detailed_description' => 'Parfait pour vos courses, vos sorties à la plage ou vos souvenirs du festival.',
                'price' => 5.00,
                'old_price' => null,
                'is_featured' => false,
                'image' => 'img/boutique/tot-bag_blanc.jpg',
                'category' => 'goodies',
                'badge' => 'accessoire',
                'colors' => ['blanc'],
                'images' => [
                    'blanc' => 'img/boutique/tot-bag_blanc.jpg',
                ],
                'quantities' => [
                    'blanc' => ['Unique' => 7],
                ],
            ],
            [
                'title' => 'Bob Officiel',
                'slug' => 'bob-officiel-2026',
                'description' => 'Le bob officiel parfait pour se protéger du soleil pendant les concerts.',
                'detailed_description' => 'Couleur bleue assortie au thème 2026. Taille unique.',
                'price' => 13.50,
                'old_price' => null,
                'is_featured' => true,
                'image' => 'img/boutique/bob_bleu.jpg',
                'category' => 'goodies',
                'badge' => 'accessoire',
                'colors' => ['bleu'],
                'images' => [
                    'bleu' => 'img/boutique/bob_bleu.jpg',
                ],
                'quantities' => [
                    'bleu' => ['Unique' => 7],
                ],
            ],
            [
                'title' => 'Casquette Officielle',
                'slug' => 'casquette-officielle-2026',
                'description' => 'La casquette officielle ajustable.',
                'detailed_description' => 'Visière courbée, attache réglable à l\'arrière. Style festivalier garanti.',
                'price' => 9.00,
                'old_price' => null,
                'is_featured' => true,
                'image' => 'img/boutique/casquette_bleu.jpg',
                'category' => 'goodies',
                'badge' => 'accessoire',
                'colors' => ['bleu'],
                'images' => [
                    'bleu' => 'img/boutique/casquette_bleu.jpg',
                ],
                'quantities' => [
                    'bleu' => ['Unique' => 7],
                ],
            ],
            [
                'title' => 'Gourde Calan\'Couleurs',
                'slug' => 'gourde-25cl',
                'description' => 'Gourde de 25cl compacte et réutilisable.',
                'detailed_description' => 'Idéale pour s\'hydrater pendant les événements. Pratique et légère.',
                'price' => 3.00,
                'old_price' => null,
                'is_featured' => false,
                'image' => 'img/boutique/gourde-25cl_noir.jpg',
                'category' => 'goodies',
                'badge' => 'accessoire',
                'colors' => ['noir'],
                'images' => [
                    'noir' => 'img/boutique/gourde-25cl_noir.jpg',
                ],
                'quantities' => [
                    'noir' => ['Unique' => 9],
                ],
            ],
            [
                'title' => 'Bandana Festival',
                'slug' => 'bandana',
                'description' => 'Bandana collector, idéal pour le style ou la protection.',
                'detailed_description' => 'Polyvalent, confortable et unisexe. Un classique des festivals.',
                'price' => 2.50,
                'old_price' => null,
                'is_featured' => false,
                'image' => 'img/boutique/bandana_violet.jpg',
                'category' => 'goodies',
                'badge' => 'accessoire',
                'colors' => ['violet'],
                'images' => [
                    'violet' => 'img/boutique/bandana_violet.jpg',
                ],
                'quantities' => [
                    'violet' => ['Unique' => 57],
                ],
            ],
        ];

        foreach ($products as $data) {
            $product = Product::create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'description' => $data['description'],
                'detailed_description' => $data['detailed_description'],
                'price' => $data['price'],
                'old_price' => $data['old_price'],
                'is_featured' => $data['is_featured'],
                'image' => $data['image'],
                'category' => $data['category'],
                'badge' => $data['badge'],
                'actif' => true,
                'created_by' => 1,
                'updated_by' => 1,
            ]);

            if (isset($data['quantities'][reset($data['colors'])]['Unique']) && $uniqueSizeId) {
                foreach ($data['colors'] as $color) {
                    $quantity = $data['quantities'][$color]['Unique'] ?? 0;
                    $sku = strtoupper($data['slug']).'-'.strtoupper($color).'-UNIQUE';
                    ProductsVariant::create([
                        'product_id' => $product->id,
                        'size_id' => $uniqueSizeId,
                        'color_id' => $colors[$color],
                        'quantity' => $quantity,
                        'image' => $data['images'][$color],
                        'sku' => $sku,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ]);
                }
            } else {
                foreach ($data['colors'] as $color) {
                    foreach ($sizes as $sizeLabel => $sizeId) {
                        if ($sizeLabel === 'Unique') {
                            continue;
                        }
                        $quantity = $data['quantities'][$color][$sizeLabel] ?? 0;
                        $sku = strtoupper($data['slug']).'-'.strtoupper($color).'-'.strtoupper($sizeLabel);
                        ProductsVariant::create([
                            'product_id' => $product->id,
                            'size_id' => $sizeId,
                            'color_id' => $colors[$color],
                            'quantity' => $quantity,
                            'image' => $data['images'][$color],
                            'sku' => $sku,
                            'created_by' => 1,
                            'updated_by' => 1,
                        ]);
                    }
                }
            }
        }
    }
}
