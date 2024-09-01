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
        Schema::create('artikels', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul artikel
            $table->string('slug')->unique(); // Slug untuk URL
            $table->text('content'); // Konten artikel
            $table->string('image')->nullable(); // Gambar utama artikel
            $table->timestamps(); // Tanggal publish dan update
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikels');
    }
};
