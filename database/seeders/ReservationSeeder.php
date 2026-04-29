<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $reservations = [
            [
                'guest_name' => 'Famille Martin',
                'guest_email' => 'martin@example.com',
                'guest_phone' => '06 01 02 03 04',
                'start_date' => now()->addDays(15)->format('Y-m-d'),
                'end_date' => now()->addDays(22)->format('Y-m-d'),
                'status' => 'confirmed',
                'notes' => '2 adultes, 2 enfants. Arrivée vers 16h.',
            ],
            [
                'guest_name' => 'M. et Mme Durand',
                'guest_email' => 'durand@example.com',
                'guest_phone' => '07 05 06 07 08',
                'start_date' => now()->addDays(30)->format('Y-m-d'),
                'end_date' => now()->addDays(37)->format('Y-m-d'),
                'status' => 'confirmed',
                'notes' => 'Anniversaire de mariage.',
            ],
            [
                'guest_name' => 'Groupe Bernard',
                'guest_email' => 'bernard@example.com',
                'guest_phone' => null,
                'start_date' => now()->addDays(50)->format('Y-m-d'),
                'end_date' => now()->addDays(53)->format('Y-m-d'),
                'status' => 'pending',
                'notes' => '8 personnes. Réservation en attente de confirmation.',
            ],
        ];

        foreach ($reservations as $reservation) {
            Reservation::create($reservation);
        }
    }
}
