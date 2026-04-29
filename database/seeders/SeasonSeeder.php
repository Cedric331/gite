<?php

namespace Database\Seeders;

use App\Models\Season;
use Illuminate\Database\Seeder;

class SeasonSeeder extends Seeder
{
    public function run(): void
    {
        $seasons = [
            [
                'name' => 'Basse saison',
                'slug' => 'low',
                'start_date' => '2025-11-01',
                'end_date' => '2026-03-31',
                'price_per_night' => 85.00,
                'price_per_week' => 525.00,
                'color' => '#6366f1',
            ],
            [
                'name' => 'Moyenne saison',
                'slug' => 'mid',
                'start_date' => '2026-04-01',
                'end_date' => '2026-06-30',
                'price_per_night' => 120.00,
                'price_per_week' => 750.00,
                'color' => '#f59e0b',
            ],
            [
                'name' => 'Haute saison',
                'slug' => 'high',
                'start_date' => '2026-07-01',
                'end_date' => '2026-08-31',
                'price_per_night' => 165.00,
                'price_per_week' => 1050.00,
                'color' => '#ef4444',
            ],
        ];

        foreach ($seasons as $season) {
            Season::updateOrCreate(['slug' => $season['slug']], $season);
        }
    }
}
