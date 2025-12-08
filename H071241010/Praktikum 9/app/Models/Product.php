<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
        'category_id',
    ];

    /**
     * Get the category that owns the product.
     * (Relasi 1:N - Sisi Child)
     */
    public function category()
    {
        // 1 Product MILIK SATU (belongsTo) Category
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the product detail associated with the product.
     * (Relasi 1:1 - Sisi Parent)
     */
    public function detail()
    {
        // 1 Product PUNYA SATU (hasOne) ProductDetail
        return $this->hasOne(ProductDetail::class);
    }

    /**
     * The warehouses that belong to the product.
     * (Relasi N:M)
     */
    public function warehouses()
    {
        // 1 Product MILIK BANYAK (belongsToMany) Warehouse
        // Tambahkan ->withPivot('quantity') untuk ambil data stok
        return $this->belongsToMany(Warehouse::class)->withPivot('quantity');
    }
}