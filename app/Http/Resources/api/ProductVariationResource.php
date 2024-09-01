<?php
namespace App\Http\Resources\api;

use App\Http\Resources\api\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariationResource extends JsonResource
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
            'image' => asset('storage/' . $this->image),
            'products' => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
