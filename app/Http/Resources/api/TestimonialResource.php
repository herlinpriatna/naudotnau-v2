<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id, // ID testimoni
            'image' => asset('storage/' . $this->image), // URL gambar
            'testimony' => $this->testimony,
            'name'=> $this->name, // Isi testimoni
            'rate' => $this->rate, // Rating
           
        ];
    }
}
