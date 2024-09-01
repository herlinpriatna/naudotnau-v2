<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\api\ArtikelResource;
use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the articles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artikels = Artikel::all(); // Ambil semua artikel
        return ArtikelResource::collection($artikels);
    }

    /**
     * Display the specified article.
     *
     * @param \App\Models\Artikel $artikel
     * @return \Illuminate\Http\Response
     */
    public function show(Artikel $artikel)
    {
        return new ArtikelResource($artikel);
    }

    /**
     * Display the specified article by slug.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function showBySlug($slug)
    {
        $artikel = Artikel::where('slug', $slug)->first();

        if (!$artikel) {
            return response()->json(['message' => 'Artikel tidak ditemukan'], 404);
        }

        return new ArtikelResource($artikel);
    }
}
