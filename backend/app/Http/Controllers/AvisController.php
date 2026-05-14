<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Film;
use App\Models\Serie;
use Illuminate\Http\Request;

class AvisController extends Controller
{
    // Ajouter ou modifier un avis sur un film ou une série
    public function store(Request $request)
    {
        $request->validate([
            'note'         => 'required|integer|min:1|max:10',
            'commentaire'  => 'nullable|string|max:500',
        ]);

        if ($request->has('film_id')) {
            $request->validate(['film_id' => 'exists:films,id']);
            $avisableType = Film::class;
            $avisableId = $request->film_id;
        } elseif ($request->has('serie_id')) {
            $request->validate(['serie_id' => 'exists:series,id']);
            $avisableType = Serie::class;
            $avisableId = $request->serie_id;
        } else {
            abort(400, 'Identifiant de film ou de série manquant.');
        }

        // Un utilisateur = un seul avis par oeuvre
        Avis::updateOrCreate(
            [
                'user_id'       => auth()->id(),
                'avisable_type' => $avisableType,
                'avisable_id'   => $avisableId,
            ],
            [
                'note'        => $request->note,
                'commentaire' => $request->commentaire,
            ]
        );

        // Recalculer la note moyenne
        $model = $avisableType::find($avisableId);
        $model->recalculerNote();

        return back()->with('success', 'Votre avis a été enregistré !');
    }

    // Supprimer son avis
    public function destroy(Avis $avis)
    {
        // Vérifier que c'est bien son avis
        if ($avis->user_id !== auth()->id()) {
            abort(403);
        }

        $model = $avis->avisable;
        $avis->delete();
        
        if ($model) {
            $model->recalculerNote();
        }

        return back()->with('success', 'Avis supprimé.');
    }
}
