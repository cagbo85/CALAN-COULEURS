<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductsVariant;
use App\Models\Size;
use App\Models\Color;
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
                'title' => 'T-shirt Collector',
                'slug' => 'tshirt-collector',
                'description' => 'T-shirt collector violet de la première édition.',
                'detailed_description' => 'Disponible en plusieurs tailles. Unisexe.',
                'price' => 19.00,
                'old_price' => null,
                'is_featured' => true,
                'image' => 'img/boutique/tshirt-collector_violet.jpg',
                'category' => 'vetements',
                'badge' => 't-shirt',
                'colors' => ['violet'],
                'images' => [
                    'violet' => 'img/boutique/tshirt-collector_violet.jpg',
                ],
                // Quantités
                'quantities' => [
                    'violet' => ['XS' => 0, 'S' => 8, 'M' => 0, 'L' => 9, 'XL' => 10, 'XXL' => 2],
                ]
            ],
            [
                'title' => 'T-shirt Classique',
                'slug' => 'tshirt-classique',
                'description' => 'T-shirt classique Calan\'Couleurs.',
                'detailed_description' => 'Disponible en plusieurs tailles. Unisexe.',
                'price' => 19.00,
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
                    'blanc' => ['XS' => 0, 'S' => 8, 'M' => 11, 'L' => 21, 'XL' => 3, 'XXL' => 1],
                ]
            ],
            [
                'title' => 'Pull zippé',
                'slug' => 'pull-zippe',
                'description' => 'Pull chaud et doux au couleur de Calan\'Couleurs.',
                'detailed_description' => 'Disponible en plusieurs tailles. Unisexe.',
                'price' => 35.00,
                'old_price' => null,
                'is_featured' => true,
                'image' => 'img/boutique/pull-zippe_vert.jpg',
                'category' => 'vetements',
                'badge' => 'pull',
                'colors' => ['vert'],
                'images' => [
                    'vert' => 'img/boutique/pull-zippe_vert.jpg',
                ],
                'quantities' => [
                    'vert' => ['XS' => 0, 'S' => 2, 'M' => 0, 'L' => 6, 'XL' => 4, 'XXL' => 3],
                ]
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
                ]
            ],
            [
                'title' => 'Tôt bag',
                'slug' => 'tot-bag',
                'description' => 'Tot bag super classe.',
                'detailed_description' => 'Parfait pour vos courses ou vos sorties.',
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
                ]
            ],
            [
                'title' => 'Gourde',
                'slug' => 'gourde-25cl',
                'description' => 'Gourde de 25cl pour vous nourrir de Calan\'Couleurs.',
                'detailed_description' => 'Idéale pour vos boissons chaudes ou froides.',
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
                ]
            ],
            [
                'title' => 'Bandana',
                'slug' => 'bandana',
                'description' => 'Bandana, idéal pour le style ou la protection.',
                'detailed_description' => 'Polyvalent et confortable, unisexe.',
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
                ]
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

            if (($data['slug'] === 'bandana' || $data['slug'] === 'gourde-25cl' || $data['slug'] === 'tot-bag' || $data['slug'] === 'lunettes-calan') && $uniqueSizeId) {
                foreach ($data['colors'] as $color) {
                    $quantity = $data['quantities'][$color]['Unique'] ?? 0;
                    $sku = strtoupper($data['slug']) . '-' . strtoupper($color) . '-UNIQUE';
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
                        $sku = strtoupper($data['slug']) . '-' . strtoupper($color) . '-' . strtoupper($sizeLabel);
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
