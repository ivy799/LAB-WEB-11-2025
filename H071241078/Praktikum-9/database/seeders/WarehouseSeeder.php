<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $warehouses = [
            ['name' => 'Gudang Makassar', 'location' => 'Jl. Perintis Kemerdekaan No.10, Makassar'],
            ['name' => 'Gudang Gowa', 'location' => 'Jl. Poros Malino, Gowa'],
            ['name' => 'Gudang Maros', 'location' => 'Jl. Ir. Sutami No.12, Maros'],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::create($warehouse);
        }
    }
}
