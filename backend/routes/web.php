<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\AvisController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Page d'accueil
Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

// Dashboard (redirect après login)
Route::get('/dashboard', function () {
    return redirect('/films');
})->middleware('auth')->name('dashboard');

// Films (liste, ajout, détail)
Route::resource('films', FilmController::class)
    ->only(['index', 'create', 'store', 'show']);

// Avis (authentifié seulement)
Route::middleware('auth')->group(function () {
    Route::post('/avis', [AvisController::class, 'store'])->name('avis.store');
    Route::delete('/avis/{avis}', [AvisController::class, 'destroy'])->name('avis.destroy');
});

// Auth (généré par Breeze)
use App\Http\Controllers\ProfilController;

Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::patch('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::patch('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');
});
require __DIR__.'/auth.php';
