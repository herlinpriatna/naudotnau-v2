<?php

namespace App\Http\Resources\api;

use App\Http\Resources\api\ProductSizeResource;
use App\Http\Resources\api\ProductVariationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSizeVariationStoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product' => new ProductResource($this->whenLoaded('product')),
            'size' => new ProductSizeResource($this->whenLoaded('size')),
            'variation' => new ProductVariationResource($this->whenLoaded('variation')),
            'store' => new StoreResource($this->whenLoaded('store')),
        ];
    }
}
