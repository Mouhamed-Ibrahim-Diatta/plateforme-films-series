<?php
namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SerieController extends Controller
{
    public function index(Request $request)
    {
        $query = Serie::query();

        if ($request->filled('search')) {
            $query->where('titre', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }
        if ($request->filled('annee')) {
            // Recherche simple : on regarde si l'année correspond au début ou à la fin, ou si c'est en cours pendant cette année.
            $annee = $request->annee;
            $query->where(function ($q) use ($annee) {
                $q->where('annee_debut', '<=', $annee)
                  ->where(function ($q2) use ($annee) {
                      $q2->where('annee_fin', '>=', $annee)
                         ->orWhereNull('annee_fin');
                  });
            });
        }

        $series = $query->orderByDesc('created_at')->get();

        return Inertia::render('Series/Index', [
            'series'  => $series,
            'filters' => $request->only(['search', 'genre', 'annee']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Series/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'genre'       => 'required|string|max:100',
            'annee_debut' => 'required|integer',
            'annee_fin'   => 'nullable|integer|gte:annee_debut',
            'nb_saisons'  => 'required|integer|min:1',
            'statut'      => 'required|in:en_cours,terminee,annulee',
            'affiche'     => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('affiche')) {
            $path = $request->file('affiche')->store('affiches', 'public');
            $validated['affiche'] = $path;
        }

        Serie::create($validated);

        return redirect()->route('series.index');
    }

    public function show(Serie $series)
    {
        $series->load(['avis.user']);
        return Inertia::render('Series/Show', [
            'serie' => $series,
        ]);
    }

    public function edit(Serie $series) {}
    public function update(Request $request, Serie $series) {}
    public function destroy(Serie $series) {}
}
