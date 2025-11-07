<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Fish extends Model
{
    use HasFactory;

    protected $table = 'fishes';
    public const RARITIES = [
        'Common',
        'Uncommon',
        'Rare',
        'Epic',
        'Legendary',
        'Mythic',
        'Secret'
    ];

    
    protected $fillable = [
        'name',
        'rarity',
        'base_weight_min',
        'base_weight_max',
        'sell_price_per_kg',
        'catch_probability',
        'description',
    ];

    
    public function scopeFilter($query, array $filters)
    {
        // Filter berdasarkan Rarity
        $query->when($filters['rarity'] ?? false, function ($query, $rarity) {
            return $query->where('rarity', $rarity);
        });

        // Filter berdasarkan Search (Nama Ikan)
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        });
    }

   
    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format($this->sell_price_per_kg) . ' Coins/kg',
        );
    }

   
    protected function formattedWeightRange(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->base_weight_min . 'kg - ' . $this->base_weight_max . 'kg',
        );
    }
}
