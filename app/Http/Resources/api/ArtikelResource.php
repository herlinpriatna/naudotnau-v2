<?php


namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArtikelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id, // Menambahkan ID artikel
            'title' => $this->title, // Menambahkan judul artikel
            'slug' => $this->slug, // Menambahkan slug artikel
            'content' => $this->content, // Menambahkan konten artikel
            'image' => asset('storage/' . $this->image), // Menambahkan URL gambar artikel
            'created_at' => $this->created_at->toDateTimeString(), // Menambahkan tanggal pembuatan
            'updated_at' => $this->updated_at->toDateTimeString(), // Menambahkan tanggal pembaruan
        ];
    }
}
