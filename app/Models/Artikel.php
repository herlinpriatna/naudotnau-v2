<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Artikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
    ];

    // Boot method for automatic slug generation
    protected static function booted()
    {
        static::creating(function ($artikel) {
            // Menghasilkan slug dari title
            $artikel->slug = Str::slug($artikel->title);
        });

        static::created(function ($artikel) {
            // Jika ada relasi lain yang perlu ditangani setelah artikel dibuat
            // Misalnya, jika ingin menyimpan relasi dengan tabel lain, tambahkan di sini
        });
    }

    public function getRouteKeyName()
    {
        return 'slug'; // Menggunakan slug sebagai key route
    }
}
