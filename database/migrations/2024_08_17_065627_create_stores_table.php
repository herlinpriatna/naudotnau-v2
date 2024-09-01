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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama toko
            $table->text('address'); // Alamat toko
            $table->string('phone_number'); // Nomor telepon toko
            $table->string('social_media'); // Link sosial media (misalnya Instagram, Facebook, dll.)
            $table->string('image'); // Gambar toko
            $table->string('map_link'); // Link Google Maps atau peta lainnya
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
