<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    // Désactive updated_at car un log est immuable (on garde seulement created_at)
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'loggable_id', 'loggable_type', 'event', 
        'old_values', 'new_values', 'ip_address', 'user_agent'
    ];

    protected $casts = [
        'old_values' => 'array', // Transforme le JSON de la BDD en tableau PHP
        'new_values' => 'array', // Transforme le JSON de la BDD en tableau PHP
    ];

    /**
     * Relation Polymorphique : Permet de récupérer l'objet lié (Produit, Marque, etc.)
     * quel que soit son type.
     */
    public function loggable(): MorphTo 
    {
        return $this->morphTo();
    }

    /**
     * Relation : L'auteur de l'action enregistrée dans le log.
     */
    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }
}