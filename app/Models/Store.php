<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'social_media',
        'image',
        'map_link',
    ];

    protected $casts = [
        'social_media' => 'array',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_size_variation_store')
                    ->withPivot('product_size_id', 'product_variation_id')
                    ->withTimestamps();
    }

    
}
