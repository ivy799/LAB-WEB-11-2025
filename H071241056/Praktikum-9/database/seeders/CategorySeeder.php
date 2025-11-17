<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Makanan', 
                'description' => 'Berbagai jenis makanan'
            ],
            [
                'name' => 'Minuman', 
                'description' => 'Berbagai jenis minuman'
            ],
            [
                'name' => 'Snack', 
                'description' => 'Berbagai jenis snack ringan'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('Categories berhasil ditambahkan: Makanan, Minuman, Snack');
    }
}