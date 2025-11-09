<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cover_product',
        'namaproduct',
        'deskripsi_singkat',
        'harga',
        'full_deskripsi',
    ];

    /**
     * Get the images for the product.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }
}