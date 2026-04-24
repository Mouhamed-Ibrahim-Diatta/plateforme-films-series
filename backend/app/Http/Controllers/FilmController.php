<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FilmController extends Controller
{
    // Liste des films
    public function index()
    {
        $films = Film::orderByDesc('created_at')->get();

        return Inertia::render('Films/Index', [
            'films' => $films,
        ]);
    }

    // Formulaire d'ajout
    public function create()
    {
        return Inertia::render('Films/Create');
    }

    // Enregistrement
    public function store(Request $request)
    {
        $data = $request->validate([
            'titre'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'genre'         => 'required|string|max:100',
            'annee'         => 'required|integer|min:1888|max:2099',
            'realisateur'   => 'nullable|string|max:255',
            'duree_minutes' => 'nullable|integer|min:1',
        ]);

        Film::create($data);

        return redirect()->route('films.index')
            ->with('success', 'Film ajouté avec succès !');
    }

    // Détail d'un film
    public function show(Film $film)
    {
        return Inertia::render('Films/Show', [
            'film' => $film,
        ]);
    }

    // Pas utilisé pour le prototype
    public function edit(Film $film) {}
    public function update(Request $request, Film $film) {}
    public function destroy(Film $film) {}
}
