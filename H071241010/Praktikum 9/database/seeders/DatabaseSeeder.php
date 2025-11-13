<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Daftarkan seeder di sini sesuai urutan
        $this->call([
            CategorySeeder::class,   // Parent 1
            WarehouseSeeder::class,  // Parent 2
            ProductSeeder::class,    // Child (terakhir)
        ]);
    }
}