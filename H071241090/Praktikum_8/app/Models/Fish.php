<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fish extends Model
{   
    use HasFactory;

    protected $table = 'fishes';

    protected $fillable = [
        'name', 'rarity', 'base_weight_min', 'base_weight_max',
        'sell_price_per_kg', 'catch_probability', 'description'
    ];

    // Accessor
    public function getFormattedPriceAttribute()
    {
        return '💰 ' . number_format($this->sell_price_per_kg, 0, ',', '.');
    }

    // Scope filter rarity
    public function scopeByRarity($query, $rarity)
    {
        if ($rarity && $rarity !== 'All') {
            $query->where('rarity', $rarity);
        }
    }
}
