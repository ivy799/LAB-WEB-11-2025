<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'description',
        'weight',
        'size',
    ];

    public function product()
    {
        // 1 ProductDetail MILIK SATU (belongsTo) Product
        return $this->belongsTo(Product::class);
    }
}