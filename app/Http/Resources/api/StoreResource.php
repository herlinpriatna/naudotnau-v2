<?php
namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'social_media' => $this->social_media,
            'image' => asset('storage/' . $this->image),
            'map_link' => $this->map_link,
            'products' => ProductResource::collection($this->whenLoaded('products')), // Menggunakan resource untuk relasi produk
        ];
    }
}
