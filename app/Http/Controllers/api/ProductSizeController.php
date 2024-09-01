<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use App\Http\Resources\api\ProductSizeResource;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class ProductSizeController extends Controller
{
    public function index()
    {
        $productSizes = ProductSize::all();
        return ProductSizeResource::collection($productSizes);
    }
}

