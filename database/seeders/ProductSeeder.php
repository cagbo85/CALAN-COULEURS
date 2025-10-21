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
                'title' => 'T-shirt Décontracté',
                'slug' => 'tshirt-decontracte',
                'description' => 'T-shirt coupe loose, parfait pour l\'été.',
                'detailed_description' => 'Disponible en plusieurs couleurs et tailles. Unisexe.',
                'price' => 12.00,
                'old_price' => 15.00,
                'is_featured' => true,
                'image' => 'img/boutique/tshirt-decontracte_blanc.webp',
                'category' => 'vetements',
                'badge' => 't-shirt',
                'colors' => ['jaune', 'rouge', 'blanc'],
                'images' => [
                    'jaune' => 'img/boutique/tshirt-decontracte_jaune.webp',
                    'rouge' => 'img/boutique/tshirt-decontracte_rouge.webp',
                    'blanc' => 'img/boutique/tshirt-decontracte_blanc.webp',
                ],
                // Quantités spécifiques pour la démo (autres à 0)
                'quantities' => [
                    'jaune' => ['XS' => 1, 'S' => 2, 'M' => 3, 'L' => 4, 'XL' => 5, 'XXL' => 0],
                    'rouge' => ['XS' => 5, 'S' => 4, 'M' => 3, 'L' => 2, 'XL' => 1, 'XXL' => 0],
                    'blanc' => ['XS' => 0, 'S' => 0, 'M' => 3, 'L' => 2, 'XL' => 0, 'XXL' => 0],
                ]
            ],
            [
                'title' => 'T-shirt Classique',
                'slug' => 'tshirt-classique',
                'description' => 'T-shirt classique Calan\'Couleurs.',
                'detailed_description' => 'Coton bio, impression violet ou blanc.',
                'price' => 10.00,
                'old_price' => null,
                'is_featured' => false,
                'image' => 'img/boutique/tshirt-classique_violet.webp',
                'category' => 'vetements',
                'badge' => 't-shirt',
                'colors' => ['blanc', 'violet'],
                'images' => [
                    'blanc' => 'img/boutique/tshirt-classique_blanc.webp',
                    'violet' => 'img/boutique/tshirt-classique_violet.webp',
                ],
                'quantities' => [
                    'blanc' => ['XS' => 1, 'S' => 3, 'M' => 5, 'L' => 6, 'XL' => 0, 'XXL' => 0],
                    'violet' => ['XS' => 3, 'S' => 6, 'M' => 0, 'L' => 2, 'XL' => 1, 'XXL' => 0],
                ]
            ],
            [
                'title' => 'Pull Prémium',
                'slug' => 'pull-premium',
                'description' => 'Pull chaud et doux, édition limitée.',
                'detailed_description' => 'Plusieurs couleurs, coupe mixte.',
                'price' => 25.00,
                'old_price' => 30.00,
                'is_featured' => true,
                'image' => 'img/boutique/pull-premium_vert.webp',
                'category' => 'vetements',
                'badge' => 'pull',
                'colors' => ['vert', 'rose', 'bleu'],
                'images' => [
                    'vert' => 'img/boutique/pull-premium_vert.webp',
                    'rose' => 'img/boutique/pull-premium_rose.webp',
                    'bleu' => 'img/boutique/pull-premium_bleu.webp',
                ],
                'quantities' => [
                    'vert' => ['XS' => 0, 'S' => 0, 'M' => 1, 'L' => 4, 'XL' => 2, 'XXL' => 0],
                    'rose' => ['XS' => 1, 'S' => 2, 'M' => 3, 'L' => 2, 'XL' => 5, 'XXL' => 0],
                    'bleu' => ['XS' => 1, 'S' => 0, 'M' => 1, 'L' => 6, 'XL' => 0, 'XXL' => 0],
                ]
            ],
            [
                'title' => 'Lunettes Calan\'Couleurs',
                'slug' => 'lunettes-calan-couleurs',
                'description' => 'Lunettes de soleil stylées, protection UV.',
                'detailed_description' => 'Coloris rose ou noir, pour tous les genres.',
                'price' => 8.00,
                'old_price' => 10.00,
                'is_featured' => false,
                'image' => 'img/boutique/lunettes-calan-couleurs_noir.webp',
                'category' => 'accessoires',
                'badge' => 'accessoire',
                'colors' => ['rose', 'noir'],
                'images' => [
                    'rose' => 'img/boutique/lunettes-calan-couleurs_rose.webp',
                    'noir' => 'img/boutique/lunettes-calan-couleurs_noir.webp',
                ],
                'quantities' => [
                    'rose' => ['Unique' => 4],
                    'noir' => ['Unique' => 6],
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

            if ($data['slug'] === 'lunettes-calan-couleurs' && $uniqueSizeId) {
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
