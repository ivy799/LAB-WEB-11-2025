<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category; // Import Model

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Buat 2 data kategori
        Category::create([
            'name' => 'Elektronik',
            'description' => 'Semua barang elektronik.'
        ]);

        Category::create([
            'name' => 'Pakaian',
            'description' => 'Pakaian pria dan wanita.'
        ]);
    }
}