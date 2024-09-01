<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStore extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari konvensi
    protected $table = 'product_store';

    // Jika ada kolom lain di tabel pivot, Anda dapat mendefinisikannya di sini
    protected $fillable = [
        'product_id', // ID produk
        'store_id',   // ID toko
        
    ];

    // Relasi dengan model Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi dengan model Store
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
