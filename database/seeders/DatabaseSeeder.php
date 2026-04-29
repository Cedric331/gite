<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Compte administrateur
        User::updateOrCreate(
            ['email' => 'admin@gite.fr'],
            [
                'name' => 'Administrateur',
                'email' => 'admin@gite.fr',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            SettingSeeder::class,
            PhotoSeeder::class,
            SeasonSeeder::class,
            ReservationSeeder::class,
            ContactMessageSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
