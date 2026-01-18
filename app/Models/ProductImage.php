<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'path', 'sort_order'];

    /**
     * Relation : L'image appartient à un produit spécifique.
     */
    public function product(): BelongsTo 
    {
        return $this->belongsTo(Product::class);
    }
}