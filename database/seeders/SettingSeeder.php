<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Informations générales
            ['key' => 'site_name', 'value' => 'Le Gîte des Chênes', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Votre havre de paix en pleine nature', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Niché au cœur de la forêt, notre gîte vous accueille pour des séjours inoubliables en famille ou entre amis. Profitez du calme, de la nature et de nos équipements modernes.', 'group' => 'general'],

            // Héros (page d'accueil)
            ['key' => 'hero_title', 'value' => 'Bienvenue au Gîte des Chênes', 'group' => 'hero'],
            ['key' => 'hero_subtitle', 'value' => "Découvrez un séjour exceptionnel au cœur de la nature. Confort, calme et authenticité vous attendent.", 'group' => 'hero'],
            ['key' => 'hero_cta', 'value' => 'Réserver votre séjour', 'group' => 'hero'],

            // Page Le Gîte
            ['key' => 'gite_title', 'value' => 'Le Gîte', 'group' => 'gite'],
            ['key' => 'gite_description', 'value' => "Notre gîte de charme peut accueillir jusqu'à 8 personnes dans un cadre naturel exceptionnel. La maison dispose de tout le confort moderne tout en conservant le charme de l'architecture traditionnelle.", 'group' => 'gite'],
            ['key' => 'gite_capacity', 'value' => '8', 'group' => 'gite'],
            ['key' => 'gite_surface', 'value' => '120', 'group' => 'gite'],
            ['key' => 'gite_bedrooms', 'value' => '4', 'group' => 'gite'],
            ['key' => 'gite_bathrooms', 'value' => '2', 'group' => 'gite'],

            // Coordonnées de contact
            ['key' => 'contact_name', 'value' => 'Marie et Jean Dupont', 'group' => 'contact'],
            ['key' => 'contact_email', 'value' => 'contact@gite-des-chenes.fr', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '06 12 34 56 78', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => '123 Chemin des Chênes, 24000 Périgueux', 'group' => 'contact'],
            ['key' => 'contact_lat', 'value' => '45.1837', 'group' => 'contact'],
            ['key' => 'contact_lng', 'value' => '0.7213', 'group' => 'contact'],

            // SEO
            ['key' => 'seo_title', 'value' => 'Gîte des Chênes — Location de vacances en Dordogne', 'group' => 'seo'],
            ['key' => 'seo_description', 'value' => 'Louez notre gîte de charme en Dordogne pour des vacances inoubliables. 4 chambres, 8 personnes, piscine, grand jardin. Réservez en ligne !', 'group' => 'seo'],
            ['key' => 'seo_keywords', 'value' => 'gîte Dordogne, location vacances, gîte de charme, hébergement rural', 'group' => 'seo'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
