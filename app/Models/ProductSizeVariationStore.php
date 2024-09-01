<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSizeVariationStore extends Model
{
    protected $table = 'product_size_variation_store';

    protected $fillable = [
        'product_id',
        'product_size_id',
        'product_variation_id',
        'store_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function size()
    {
        return $this->belongsTo(ProductSize::class);
    }

    public function variation()
    {
        return $this->belongsTo(PRoductVariation::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
