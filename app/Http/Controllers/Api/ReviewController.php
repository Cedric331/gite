<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    // Liste les avis actifs pour l'affichage public
    public function index(): JsonResponse
    {
        $reviews = Review::active()
            ->orderBy('date', 'desc')
            ->get();

        return response()->json($reviews);
    }
}
