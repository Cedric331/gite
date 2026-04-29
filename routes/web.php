<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Web — toutes les routes non-admin renvoient le SPA Vue
|--------------------------------------------------------------------------
*/

// Sitemap et robots.txt
Route::get('/sitemap.xml', function () {
    return response()->file(public_path('sitemap.xml'), [
        'Content-Type' => 'application/xml',
    ]);
});

Route::get('/robots.txt', function () {
    return response()->file(public_path('robots.txt'), [
        'Content-Type' => 'text/plain',
    ]);
});

// Catch-all : Vue Router gère le routage côté client
// Exclut /admin (Filament) et /api (REST)
Route::get('/{any?}', function () {
    return view('app');
})->where('any', '^(?!admin|api).*$');
