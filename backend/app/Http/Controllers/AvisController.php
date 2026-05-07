<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Film;
use Illuminate\Http\Request;

class AvisController extends Controller
{
    // Ajouter ou modifier un avis sur un film
    public function store(Request $request)
    {
        $request->validate([
            'film_id'      => 'required|exists:films,id',
            'note'         => 'required|integer|min:1|max:10',
            'commentaire'  => 'nullable|string|max:500',
        ]);

        // Un utilisateur = un seul avis par film
        Avis::updateOrCreate(
            [
                'user_id'       => auth()->id(),
                'avisable_type' => Film::class,
                'avisable_id'   => $request->film_id,
            ],
            [
                'note'        => $request->note,
                'commentaire' => $request->commentaire,
            ]
        );

        // Recalculer la note moyenne du film
        $film = Film::find($request->film_id);
        $film->recalculerNote();

        return back()->with('success', 'Votre avis a été enregistré !');
    }

    // Supprimer son avis
    public function destroy(Avis $avis)
    {
        // Vérifier que c'est bien son avis
        if ($avis->user_id !== auth()->id()) {
            abort(403);
        }

        $film = Film::find($avis->avisable_id);
        $avis->delete();
        $film->recalculerNote();

        return back()->with('success', 'Avis supprimé.');
    }
}
