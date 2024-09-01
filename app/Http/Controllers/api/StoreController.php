<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\api\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the stores.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Store::all(); // Ambil semua toko
        return StoreResource::collection($stores);
    }


    /**
     * Display the specified store.
     *
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        return new StoreResource($store);
    }


    public function showStorebySlug($slug)
    {
        $store = Store::where('slug', $slug)->with('products')->firstOrFail();

        return response()->json([
            'data' => $store,
        ]);
    }

  
}
