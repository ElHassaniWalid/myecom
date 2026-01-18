<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['parent_id', 'promotion_id', 'name', 'slug', 'description', 'is_active'];

    /**
     * Relation : Liste des produits appartenant à cette catégorie.
     */
    public function products(): HasMany 
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Relation : Récupère la promotion associée à la catégorie.
     */
    public function promotion(): BelongsTo 
    {
        return $this->belongsTo(Promotion::class);
    }

    /**
     * Relation Récursive : Récupère la catégorie parente.
     */
    public function parent(): BelongsTo 
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Relation Récursive : Récupère les sous-catégories enfants.
     */
    public function children(): HasMany 
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}