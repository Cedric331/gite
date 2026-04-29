<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    // Retourne tous les paramètres publics sous forme de tableau clé/valeur
    public function index(): JsonResponse
    {
        $settings = Setting::whereNotIn('group', ['internal'])
            ->pluck('value', 'key');

        return response()->json($settings);
    }

    // Retourne les paramètres d'un groupe spécifique
    public function group(string $group): JsonResponse
    {
        $settings = Setting::getGroup($group);

        return response()->json($settings);
    }
}
