<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\api\ProductVariationResource;
use App\Models\ProductVariation;

class ProductVariationController extends Controller
{
    public function index()
    {
        $variations = ProductVariation::all();
        return ProductVariationResource::collection($variations);
    }

    public function show($id)
    {
        $variation = ProductVariation::with('products')->findOrFail($id);
        return new ProductVariationResource($variation);
    }
}
