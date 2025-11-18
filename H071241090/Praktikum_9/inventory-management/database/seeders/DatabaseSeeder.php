<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==== 1. CATEGORIES ====
        DB::table('categories')->insert([
            ['name' => 'Electronics', 'description' => 'Devices and gadgets', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Furniture', 'description' => 'Home and office furniture', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Groceries', 'description' => 'Daily essentials and food', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ==== 2. WAREHOUSES ====
        DB::table('warehouses')->insert([
            ['name' => 'Warehouse A', 'location' => 'Jakarta', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Warehouse B', 'location' => 'Makassar', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Warehouse C', 'location' => 'Surabaya', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ==== 3. PRODUCTS ====
        DB::table('products')->insert([
            ['name' => 'Laptop', 'price' => 12000000, 'category_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Chair', 'price' => 500000, 'category_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rice 10kg', 'price' => 120000, 'category_id' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ==== 4. PRODUCT DETAILS ====
        DB::table('product_details')->insert([
            ['product_id' => 1, 'description' => 'Gaming laptop with RTX GPU', 'weight' => 2.5, 'size' => '15 inch', 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 2, 'description' => 'Office chair ergonomic design', 'weight' => 7.0, 'size' => 'Standard', 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 3, 'description' => 'Premium rice pack 10kg', 'weight' => 10.0, 'size' => 'Large bag', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ==== 5. PRODUCT-WAREHOUSE (STOCKS) ====
        DB::table('product_warehouse')->insert([
            ['product_id' => 1, 'warehouse_id' => 1, 'quantity' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 1, 'warehouse_id' => 2, 'quantity' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 2, 'warehouse_id' => 1, 'quantity' => 20, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 3, 'warehouse_id' => 3, 'quantity' => 15, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
