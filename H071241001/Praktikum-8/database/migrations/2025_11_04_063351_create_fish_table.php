<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;   
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('fishes', function (Blueprint $table) {
        $table->id('id')->unsignedBigInteger(); // BIGINT UNSIGNED, PRIMARY KEY, AUTO_INCREMENT 
        $table->string('name', 100)->unique(); // VARCHAR(100), NOT NULL 
        $table->enum('rarity', [ // ENUM, NOT NULL 
            'Common', 'Uncommon', 'Rare', 'Epic',
            'Legendary', 'Mythic', 'Secret'
        ])->default('Common');
        $table->decimal('base_weight_min', 8, 2); // DECIMAL(8,2), NOT NULL
        $table->decimal('base_weight_max', 8, 2); // DECIMAL(8,2), NOT NULL     
        $table->integer('sell_price_per_kg'); // INTEGER, NOT NULL
        $table->decimal('catch_probability', 5, 2); // DECIMAL(5,2), NOT NULL
        $table->text('description')->nullable(); // TEXT, NULLABLE
        $table->timestamps(); // created_at dan updated_at (TIMESTAMP)
    });
}
};
