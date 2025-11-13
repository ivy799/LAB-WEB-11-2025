<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    public function run()
    {
        $warehouses = [
            [
                'name' => 'Gudang Makassar', 
                'location' => 'Jl. Perintis Kemerdekaan KM. 10, Makassar'
            ],
            [
                'name' => 'Gudang Gowa', 
                'location' => 'Jl. Poros Malino, Gowa'
            ],
            [
                'name' => 'Gudang Maros', 
                'location' => 'Jl. Poros Maros, Maros'
            ],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::create($warehouse);
        }

        $this->command->info('Warehouses berhasil ditambahkan: Gudang Makassar, Gudang Gowa, Gudang Maros');
    }
}