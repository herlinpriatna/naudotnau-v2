<?php
use App\Http\Controllers\api\ArtikelController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\StoreController;
use App\Http\Controllers\api\ProductSizeController;
use App\Http\Controllers\api\ProductVariationController;
use App\Http\Controllers\api\ProductSizeVariationStoreController;
use App\Http\Controllers\api\TestimonialController;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rute untuk pengguna saat autentikasi
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rute untuk produk
Route::get('/product/{product:slug}', [ProductController::class, 'show']);
Route::get('/product/{slug}', [ProductController::class, 'showProduk']);
Route::apiResource('/product', ProductController::class);

// Rute untuk toko
Route::get('/store/{slug}', [StoreController::class, 'showStorebySlug']);
Route::apiResource('/stores', StoreController::class);

// Rute untuk ukuran produk

Route::apiResource('/product-sizes', ProductSizeController::class);

Route::apiResource('/testimonials', TestimonialController::class);

// Rute untuk variasi produk
Route::apiResource('/product-variations', ProductVariationController::class);

// Rute untuk relasi ukuran variasi produk dan toko
Route::apiResource('/product-size-variation-stores', ProductSizeVariationStoreController::class);

// Rute untuk artikel
Route::apiResource('/artikels', ArtikelController::class);
Route::get('/artikel/{artikel:slug}', [ArtikelController::class, 'show']);