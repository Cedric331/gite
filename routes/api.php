<?php

use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Api\PhotoController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\SeasonController;
use App\Http\Controllers\Api\SettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes API publiques (sans authentification)
|--------------------------------------------------------------------------
*/

// Paramètres du site
Route::get('/settings', [SettingController::class, 'index']);
Route::get('/settings/{group}', [SettingController::class, 'group']);

// Galerie photos
Route::get('/photos', [PhotoController::class, 'index']);
Route::get('/photos/main', [PhotoController::class, 'main']);

// Saisons et tarifs
Route::get('/seasons', [SeasonController::class, 'index']);

// Disponibilités (lecture seule pour le public)
Route::get('/reservations/occupied-dates', [ReservationController::class, 'occupiedDates']);

// Avis clients
Route::get('/reviews', [ReviewController::class, 'index']);

// Formulaire de contact
Route::post('/contact', [ContactMessageController::class, 'store']);
