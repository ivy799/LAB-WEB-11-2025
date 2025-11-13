<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductDetail;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Bakso Special',
                'price' => 25000,
                'category_id' => 1, // Makanan
                'detail' => [
                    'description' => 'Bakso Special dengan isian lengkap dan kuah gurih',
                    'weight' => 0.5,
                    'size' => '500ml'
                ]
            ],
            [
                'name' => 'Es Teh Manis',
                'price' => 8000,
                'category_id' => 2, // Minuman
                'detail' => [
                    'description' => 'Es teh manis segar dengan gula pasir',
                    'weight' => 0.3,
                    'size' => '350ml'
                ]
            ],
            [
                'name' => 'Keripik Kentang',
                'price' => 15000,
                'category_id' => 3, // Snack
                'detail' => [
                    'description' => 'Keripik kentang renyah dengan rasa original',
                    'weight' => 0.2,
                    'size' => '150g'
                ]
            ]
        ];

        foreach ($products as $productData) {
            $product = Product::create([
                'name' => $productData['name'],
                'price' => $productData['price'],
                'category_id' => $productData['category_id']
            ]);

            ProductDetail::create([
                'product_id' => $product->id,
                'description' => $productData['detail']['description'],
                'weight' => $productData['detail']['weight'],
                'size' => $productData['detail']['size']
            ]);
        }

        $this->command->info('Sample products berhasil ditambahkan');
    }
}