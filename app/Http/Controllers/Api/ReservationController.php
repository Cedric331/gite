<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // Retourne les dates occupées (pour le calendrier public en lecture seule)
    public function occupiedDates(): JsonResponse
    {
        $dates = Reservation::getOccupiedDates();

        return response()->json($dates);
    }

    // Retourne les réservations par mois (pour le calendrier admin)
    public function calendar(Request $request): JsonResponse
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $reservations = Reservation::active()
            ->whereYear('start_date', $year)
            ->whereMonth('start_date', $month)
            ->orWhere(function ($q) use ($year, $month) {
                $q->whereYear('end_date', $year)
                  ->whereMonth('end_date', $month)
                  ->active();
            })
            ->get();

        return response()->json($reservations);
    }
}
