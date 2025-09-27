<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductsVariant;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Exemple de produit T-shirt
        $products = [
            [
                'title' => 'T-shirt Calan\'Couleurs',
                'slug' => 'tshirt-calan-couleurs',
                'description' => 'T-shirt officiel du festival, coton bio.',
                'detailed_description' => 'Disponible en plusieurs tailles et couleurs. Impression recto-verso.',
                'price' => 20.00,
                'stock_quantity' => 100,
                'is_featured' => true,
                'image' => 'img/boutique/tshirt-blanc.webp',
                'category' => 'vetements',
                'variants' => [
                    ['size' => 'S', 'color' => 'blanc', 'quantity' => 10, 'image' => 'img/boutique/tshirt-blanc.webp'],
                    ['size' => 'M', 'color' => 'blanc', 'quantity' => 20, 'image' => 'img/boutique/tshirt-blanc.webp'],
                    ['size' => 'L', 'color' => 'noir', 'quantity' => 15, 'image' => 'img/boutique/tshirt-noir.webp'],
                    ['size' => 'XL', 'color' => 'noir', 'quantity' => 10, 'image' => 'img/boutique/tshirt-noir.webp'],
                ]
            ],
            // Tu pourras facilement en ajouter d'autres ici
        ];

        foreach ($products as $data) {
            $product = Product::create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'description' => $data['description'],
                'detailed_description' => $data['detailed_description'],
                'price' => $data['price'],
                'stock_quantity' => $data['stock_quantity'],
                'is_featured' => $data['is_featured'],
                'image' => $data['image'],
                'category' => $data['category'],
                'actif' => true,
                'created_by' => 1,
                'updated_by' => 1,
            ]);

            foreach ($data['variants'] as $variant) {
                ProductsVariant::create([
                    'product_id' => $product->id,
                    'size' => $variant['size'],
                    'color' => $variant['color'],
                    'quantity' => $variant['quantity'],
                    'image' => $variant['image'],
                    'created_by' => 1,
                    'updated_by' => 1,
                ]);
            }
        }
    }
}
