<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Elektronik', 'description' => 'Produk elektronik seperti laptop, HP, dan TV'],
            ['name' => 'Pakaian', 'description' => 'Berbagai macam pakaian pria dan wanita'],
            ['name' => 'Peralatan Rumah', 'description' => 'Perabot dan alat-alat rumah tangga'],
            ['name' => 'Olahraga', 'description' => 'Peralatan dan perlengkapan olahraga'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
