<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'guest_name',
        'guest_email',
        'guest_phone',
        'start_date',
        'end_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Scope pour les réservations actives (confirmées ou bloquées)
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['confirmed', 'blocked', 'pending']);
    }

    // Scope pour les réservations à venir
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now())->active();
    }

    // Retourne les dates occupées entre start et end
    // Note: CarbonImmutable est utilisé — addDay() doit être réassigné
    public static function getOccupiedDates(): array
    {
        $dates = [];
        $reservations = static::active()->get(['start_date', 'end_date']);

        foreach ($reservations as $reservation) {
            $current = $reservation->start_date;
            while ($current->lte($reservation->end_date)) {
                $dates[] = $current->format('Y-m-d');
                $current = $current->addDay();
            }
        }

        return array_unique($dates);
    }
}
