<?php
namespace App\Http\Controllers;
use App\Models\Film;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FilmController extends Controller
{
    public function index(Request $request)
    {
        $query = Film::query();

        if ($request->filled('search')) {
            $query->where('titre', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }
        if ($request->filled('annee')) {
            $query->where('annee', $request->annee);
        }

        $films = $query->orderByDesc('created_at')->get();

        return Inertia::render('Films/Index', [
            'films'   => $films,
            'filters' => $request->only(['search', 'genre', 'annee']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Films/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'annee'       => 'nullable|integer',
            'genre'       => 'nullable|string|max:100',
            'affiche'     => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('affiche')) {
            $path = $request->file('affiche')->store('affiches', 'public');
            $validated['affiche'] = $path;
        }

        Film::create($validated);

        return redirect()->route('films.index');
    }

    public function show(Film $film)
    {
        $film->load(['avis.user']);
        return Inertia::render('Films/Show', [
            'film' => $film,
        ]);
    }

    public function edit(Film $film) {}
    public function update(Request $request, Film $film) {}
    public function destroy(Film $film) {}
}