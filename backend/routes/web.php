<?php

use App\Http\Controllers\FilmController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Page d'accueil
Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

// Films (liste, ajout, détail)
Route::resource('films', FilmController::class)
    ->only(['index', 'create', 'store', 'show']);

// Auth (généré par Breeze)
require __DIR__.'/auth.php';
