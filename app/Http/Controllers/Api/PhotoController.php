<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    // Liste toutes les photos, triées par ordre
    public function index(Request $request): JsonResponse
    {
        $query = Photo::orderBy('order');

        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        return response()->json($query->get());
    }

    // Retourne la photo principale
    public function main(): JsonResponse
    {
        $photo = Photo::where('is_main', true)->first()
            ?? Photo::orderBy('order')->first();

        return response()->json($photo);
    }
}
