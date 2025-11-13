<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse; // Import Model

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 2 data gudang
        Warehouse::create([
            'name' => 'Gudang Utama Makassar',
            'location' => 'Jl. Perintis Kemerdekaan KM. 10'
        ]);

        Warehouse::create([
            'name' => 'Gudang Cabang Gowa',
            'location' => 'Jl. Poros Malino'
        ]);
    }
}