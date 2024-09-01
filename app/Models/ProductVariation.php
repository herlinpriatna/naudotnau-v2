<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_size_variation_store')
                    ->withPivot('product_size_id', 'store_id')
                    ->withTimestamps();
    }
}
