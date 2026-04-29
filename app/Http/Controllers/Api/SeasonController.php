<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Season;
use Illuminate\Http\JsonResponse;

class SeasonController extends Controller
{
    // Liste toutes les saisons avec leurs tarifs
    public function index(): JsonResponse
    {
        $seasons = Season::orderBy('start_date')->get();

        return response()->json($seasons);
    }
}
