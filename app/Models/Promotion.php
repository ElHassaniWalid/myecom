<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promotion extends Model
{
    // Champs autorisés pour le remplissage de masse
    protected $fillable = ['name', 'type', 'value', 'start_date', 'end_date', 'is_active'];

    // Conversion automatique des types de colonnes
    protected $casts = [
        'start_date' => 'datetime', // Transforme en objet Carbon
        'end_date' => 'datetime',   // Transforme en objet Carbon
        'is_active' => 'boolean',   // Transforme 0/1 en vrai/faux
        'value' => 'decimal:2',     // Garde deux décimales pour la précision
    ];

    /**
     * Relation : Une promotion peut être liée à plusieurs produits.
     */
    public function products(): HasMany 
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Relation : Une promotion peut s'appliquer à plusieurs catégories.
     */
    public function categories(): HasMany 
    {
        return $this->hasMany(Category::class);
    }
}