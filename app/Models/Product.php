<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'material',
        'slug',
        'images',
        'price_min',
        'price_max',
        'stock',
        'link_tiktok',
        'link_shopee',
    ];

    protected $casts = [
        'images' => 'array', // Cast images as an array
    ];

    // Boot method for automatic slug generation
    protected static function booted()
    {
        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });

        static::created(function ($product) {
            $sizes = request()->input('sizes');
            $variations = request()->input('variations');
            $storeId = request()->input('store_id');

            if ($sizes && $variations && $storeId) {
                foreach ($sizes as $sizeId) {
                    foreach ($variations as $variationId) {
                        $product->sizes()->attach($sizeId, [
                            'product_variation_id' => $variationId,
                            'store_id' => $storeId,
                        ]);
                    }
                }
            }
        });
    }

    // Relasi many-to-many dengan tabel pivot
  
    public function sizes()
    {
        return $this->belongsToMany(ProductSize::class, 'product_size_variation_store')
                    ->withPivot('product_variation_id', 'store_id')
                    ->withTimestamps();
    }

    public function variations()
    {
        return $this->belongsToMany(ProductVariation::class, 'product_size_variation_store')
                    ->withPivot('product_size_id', 'store_id')
                    ->withTimestamps();
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class, 'product_store') // Pastikan ini adalah tabel pivot yang benar
                    ->withTimestamps(); // Jika Anda ingin menyimpan timestamps
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }

}
