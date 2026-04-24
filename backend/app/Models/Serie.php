<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Serie extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre', 'description', 'genre', 'annee_debut',
        'annee_fin', 'nb_saisons', 'affiche', 'note_moyenne', 'statut',
    ];

    protected $casts = [
        'note_moyenne' => 'float',
        'annee_debut'  => 'integer',
        'annee_fin'    => 'integer',
        'nb_saisons'   => 'integer',
    ];

    // Relation polymorphique avec Avis
    public function avis()
    {
        return $this->morphMany(Avis::class, 'avisable');
    }

    // Recalcule la note moyenne après un avis
    public function recalculerNote(): void
    {
        $this->note_moyenne = $this->avis()->avg('note') ?? 0;
        $this->save();
    }
}
