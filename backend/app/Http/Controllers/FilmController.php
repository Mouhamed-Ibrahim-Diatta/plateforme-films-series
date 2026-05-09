<?php
namespace App\Http\Controllers;
use App\Models\Film;
use Illuminate\Http\Request;
use Inertia\Inertia;
class FilmController extends Controller
{
    // Liste des films avec recherche et filtres
    public function index(Request $request)
    {
        $query = Film::query();

        // Recherche par titre
        if ($request->filled('search')) {
            $query->where('titre', 'like', '%' . $request->search . '%');
        }

        // Filtre par genre
        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        // Filtre par année
        if ($request->filled('annee')) {
            $query->where('annee', $request->annee);
        }

        $films = $query->orderByDesc('created_at')->get();

        return Inertia::render('Films/Index', [
            'films'   => $films,
            'filters' => $request->only(['search', 'genre', 'annee']),
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

    // Détail d'un film avec ses avis
    public function show(Film $film)
    {
        $film->load(['avis.user']);
        return Inertia::render('Films/Show', [
            'film' => $film,
        ]);
    }

    // Pas utilisé pour le prototype
    public function edit(Film $film) {}
    public function update(Request $request, Film $film) {}
    public function destroy(Film $film) {}
}