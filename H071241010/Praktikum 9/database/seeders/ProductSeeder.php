<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB; // Wajib import DB

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Cari data parent yang akan kita gunakan
        $catElektronik = Category::where('name', 'Elektronik')->first();
        $gudangMakassar = Warehouse::where('name', 'Gudang Utama Makassar')->first();
        $gudangGowa = Warehouse::where('name', 'Gudang Cabang Gowa')->first();

        // Cek jika data parent tidak ada (sama seperti di modul [cite: 633-635])
        if (!$catElektronik || !$gudangMakassar || !$gudangGowa) {
            $this->command->error('Pastikan CategorySeeder dan WarehouseSeeder sudah ada dan dijalankan.');
            return;
        }

        // 2. Buat Produk Pertama (Laptop)
        DB::transaction(function () use ($catElektronik, $gudangMakassar) {
            // Buat Produk
            $laptop = Product::create([
                'name' => 'Laptop ASUS ROG',
                'price' => 17500000,
                'category_id' => $catElektronik->id
            ]);

            // Buat Detail Produk
            $laptop->detail()->create([
                'description' => 'Laptop gaming dengan spek tinggi.',
                'weight' => 2.5,
                'size' => '15.6 inch'
            ]);

            // Masukkan stok ke gudang (ini beda dari modul, kita pakai attach)
            $laptop->warehouses()->attach([
                $gudangMakassar->id => ['quantity' => 10] // Stok 10 di Gdg Makassar
            ]);
        });

        // 3. Buat Produk Kedua (Keyboard)
        DB::transaction(function () use ($catElektronik, $gudangMakassar, $gudangGowa) {
            // Buat Produk
            $keyboard = Product::create([
                'name' => 'Keyboard Mekanikal',
                'price' => 850000,
                'category_id' => $catElektronik->id
            ]);

            // Buat Detail Produk
            $keyboard->detail()->create([
                'description' => 'Keyboard mechanical blue switch.',
                'weight' => 0.8,
                'size' => 'TKL'
            ]);

            // Produk ini ada di 2 gudang
            $keyboard->warehouses()->attach([
                $gudangMakassar->id => ['quantity' => 50], // Stok 50 di Gdg Makassar
                $gudangGowa->id => ['quantity' => 20]      // Stok 20 di Gdg Gowa
            ]);
        });
    }
}