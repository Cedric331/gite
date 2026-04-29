<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            [
                'author' => 'Sophie L.',
                'rating' => 5,
                'comment' => "Un séjour absolument parfait ! Le gîte est magnifique, très bien équipé, et la nature environnante est superbe. Nous reviendrons avec plaisir l'an prochain.",
                'date' => '2025-08-15',
                'is_active' => true,
            ],
            [
                'author' => 'Marc et Julie D.',
                'rating' => 5,
                'comment' => "Nous avons passé une semaine merveilleuse en famille. Les enfants ont adoré le jardin et la piscine. Propriétaires très accueillants et réactifs.",
                'date' => '2025-07-22',
                'is_active' => true,
            ],
            [
                'author' => 'Thomas R.',
                'rating' => 4,
                'comment' => "Très bel endroit, calme et reposant. La cuisine est bien équipée. Seul bémol : le WiFi est un peu lent. Mais dans l'ensemble, excellent séjour !",
                'date' => '2025-06-10',
                'is_active' => true,
            ],
            [
                'author' => 'Isabelle M.',
                'rating' => 5,
                'comment' => "Le gîte correspond parfaitement aux photos. Très propre, très confortable. La région est magnifique avec plein d'activités à faire. Je recommande vivement !",
                'date' => '2025-05-03',
                'is_active' => true,
            ],
            [
                'author' => 'Pierre et Anne B.',
                'rating' => 5,
                'comment' => "Deuxième séjour ici et toujours aussi enchantés. Le rapport qualité/prix est excellent. La terrasse avec vue sur la forêt est un vrai plus.",
                'date' => '2025-04-18',
                'is_active' => true,
            ],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}
