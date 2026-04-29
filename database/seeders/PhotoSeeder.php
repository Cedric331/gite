<?php

namespace Database\Seeders;

use App\Models\Photo;
use Illuminate\Database\Seeder;

class PhotoSeeder extends Seeder
{
    public function run(): void
    {
        $photos = [
            ['filename' => 'photos/facade.jpg', 'alt' => 'Façade du gîte', 'category' => 'exterieur', 'order' => 1, 'is_main' => true],
            ['filename' => 'photos/salon.jpg', 'alt' => 'Salon lumineux', 'category' => 'salon', 'order' => 2, 'is_main' => false],
            ['filename' => 'photos/cuisine.jpg', 'alt' => 'Cuisine équipée', 'category' => 'cuisine', 'order' => 3, 'is_main' => false],
            ['filename' => 'photos/chambre1.jpg', 'alt' => 'Chambre principale', 'category' => 'chambre', 'order' => 4, 'is_main' => false],
            ['filename' => 'photos/chambre2.jpg', 'alt' => 'Chambre enfants', 'category' => 'chambre', 'order' => 5, 'is_main' => false],
            ['filename' => 'photos/salle_de_bain.jpg', 'alt' => 'Salle de bain', 'category' => 'general', 'order' => 6, 'is_main' => false],
            ['filename' => 'photos/jardin.jpg', 'alt' => 'Grand jardin ombragé', 'category' => 'exterieur', 'order' => 7, 'is_main' => false],
            ['filename' => 'photos/terrasse.jpg', 'alt' => 'Terrasse avec vue', 'category' => 'exterieur', 'order' => 8, 'is_main' => false],
            ['filename' => 'photos/piscine.jpg', 'alt' => 'Piscine privée', 'category' => 'exterieur', 'order' => 9, 'is_main' => false],
            ['filename' => 'photos/barbecue.jpg', 'alt' => 'Espace barbecue', 'category' => 'exterieur', 'order' => 10, 'is_main' => false],
        ];

        // Copie des images placeholder depuis les ressources
        foreach ($photos as $photo) {
            Photo::updateOrCreate(['filename' => $photo['filename']], $photo);
        }
    }
}
