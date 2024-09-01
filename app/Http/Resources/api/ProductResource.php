<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        \Log::info('Images value:', ['images' => $this->images]); // Menambahkan log

        if (is_string($this->images)) {
            $decodedImages = json_decode($this->images, true);
        } else {
            $decodedImages = $this->images; // Asumsi ini sudah berupa array
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'material' => $this->material,
            'slug' => $this->slug,
            'price_min' => $this->price_min,
            'price_max' => $this->price_max,
            'stock' => $this->stock,
            'link_tiktok' => $this->link_tiktok,
            'link_shopee' => $this->link_shopee,
            'no_telp' => $this->no_telp,
            'sizes' => $this->sizes instanceof \Illuminate\Support\Collection
            ? $this->sizes->map(fn($size) => $size->name)->toArray()
            : [], // Periksa apakah sizes adalah koleksi dan ubah ke array
            'variations' => $this->variations instanceof \Illuminate\Support\Collection
                ? $this->variations->map(fn($variation) => $variation->name)->toArray()
                : [], // Periksa apakah variations adalah koleksi dan ubah ke array
            'stores' => $this->stores instanceof \Illuminate\Support\Collection
                ? $this->stores->map(function ($store) {
                    return [
                        'id' => $store->id,                // Tambahkan ID toko
                        'name' => $store->name,            // Ambil nama toko
                        'address' => $store->address,      // Ambil alamat toko
                        'phone_number' => $store->phone_number, // Ambil nomor telepon
                        'social_media' => $store->social_media, // Ambil media sosial
                        'image' => asset('storage/' . $store->image), // Ambil gambar, sesuaikan path jika perlu
                        'map_link' => $store->map_link,    // Ambil link peta
                    ];
                })->toArray()
                : [],// Periksa apakah stores adalah koleksi dan ubah ke array
            'images' => !empty($decodedImages) && is_array($decodedImages) && isset($decodedImages[0]['image']) 
                ? asset('storage/' . $decodedImages[0]['image']) 
                : asset('storage/default-image.jpg'), // Gambar default jika tidak ada gambar yang tersedia 
        ];
    }
}
