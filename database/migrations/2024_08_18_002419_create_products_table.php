<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama produk
            $table->text('description'); // Deskripsi produk
            $table->string('material'); 
            $table->string('slug')->unique();
            $table->json('images');
            $table->string('link_tiktok')->nullable();
            $table->string('link_shopee')->nullable();
            $table->string('no_telp')->nullable()->default('https://wa.me/62895357579939');
             // Gambar produk (array of URLs)
            $table->decimal('price_min', 10, 2); // Harga minimum
            $table->decimal('price_max', 10, 2); // Harga maksimum
            $table->integer('stock'); // Stok produk
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
