<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        $messages = [
            [
                'name' => 'Alexandre Petit',
                'email' => 'a.petit@example.com',
                'phone' => '06 11 22 33 44',
                'start_date' => now()->addDays(60)->format('Y-m-d'),
                'end_date' => now()->addDays(67)->format('Y-m-d'),
                'guests' => 6,
                'message' => "Bonjour, je souhaiterais réserver votre gîte pour une semaine en famille. Pouvez-vous confirmer la disponibilité et me donner le tarif total ? Merci.",
                'is_read' => false,
            ],
            [
                'name' => 'Céline Morin',
                'email' => 'c.morin@example.com',
                'phone' => null,
                'start_date' => now()->addDays(90)->format('Y-m-d'),
                'end_date' => now()->addDays(94)->format('Y-m-d'),
                'guests' => 4,
                'message' => "Bonjour, avez-vous des disponibilités pour un séjour court de 4 nuits ? Nous sommes deux couples et cherchons un endroit calme pour nous ressourcer.",
                'is_read' => false,
            ],
        ];

        foreach ($messages as $message) {
            ContactMessage::create($message);
        }
    }
}
