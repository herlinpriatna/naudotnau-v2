<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ProductSizeVariationStore;
use App\Http\Resources\api\ProductSizeVariationStoreResource;
use Illuminate\Http\Request;

class ProductSizeVariationStoreController extends Controller
{
    /**
     * Menampilkan daftar ProductSizeVariationStore
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productSizeVariationStores = ProductSizeVariationStore::with('product')->get();
        return ProductSizeVariationStoreResource::collection($productSizeVariationStores);
    }

    /**
     * Menampilkan detail ProductSizeVariationStore berdasarkan ID
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productSizeVariationStore = ProductSizeVariationStore::with(['product', 'size', 'variation', 'store'])->findOrFail($id);
        return new ProductSizeVariationStoreResource($productSizeVariationStore);
    }
}
