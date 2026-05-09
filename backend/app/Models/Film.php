<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Film extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre', 'description', 'genre', 'annee',
        'realisateur', 'affiche', 'note_moyenne', 'duree_minutes', 'affiche',
    ];

    protected $casts = [
        'note_moyenne' => 'float',
        'annee'        => 'integer',
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
