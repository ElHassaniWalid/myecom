<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Helpers\CurrencyHelper;

class Product extends Model
{
    use SoftDeletes; // Permet l'archivage sans suppression définitive

    protected $fillable = [
        'category_id', 'brand_id', 'promotion_id', 'sku', 'name', 'slug', 
        'short_description', 'description', 'regular_price', 'cost_price', 
        'stock_quantity', 'weight', 'featured_image', 'is_visible', 'is_featured'
    ];

    protected $casts = [
        'regular_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'is_visible' => 'boolean',
        'is_featured' => 'boolean',
    ];

    // --- RELATIONS ---

    public function category(): BelongsTo { return $this->belongsTo(Category::class); }
    public function brand(): BelongsTo { return $this->belongsTo(Brand::class); }
    public function promotion(): BelongsTo { return $this->belongsTo(Promotion::class); }
    public function images(): HasMany { return $this->hasMany(ProductImage::class); }
    
    /**
     * Relation Polymorphique pour le monitoring.
     * Permet de lier ce produit à ses logs d'activité sans table intermédiaire.
     */
    public function activityLogs(): MorphMany 
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    // --- ACCESSEURS (LOGIQUE MÉTIER) ---

    /**
     * Calcule dynamiquement le prix final après application des promotions.
     * Utilisation : $product->final_price
     */
    public function getFinalPriceAttribute()
    {
        // 1. Détermine la promotion prioritaire (Produit d'abord, sinon Catégorie)
        $promo = $this->promotion ?? ($this->category->promotion ?? null);

        // 2. Si pas de promo active, retourne le prix normal
        if (!$promo || !$promo->is_active) {
            return $this->regular_price;
        }

        // 3. Vérification de la validité temporelle (dates)
        $now = now();
        if (($promo->start_date && $now < $promo->start_date) || ($promo->end_date && $now > $promo->end_date)) {
            return $this->regular_price;
        }

        // 4. Calcul selon le type de remise
        if ($promo->type === 'percentage') {
            return $this->regular_price * (1 - ($promo->value / 100));
        }

        // Cas d'une remise fixe (ne peut pas être inférieur à 0)
        return max(0, $this->regular_price - $promo->value);
    }

    /**
     * Vérifie si le produit est en stock
     * Utilisation : if($product->inStock()) ...
     */
    public function inStock(): bool
    {
        // Retourne vrai si la quantité est supérieure à 0
        return $this->stock_quantity > 0;
    }

    /**
     * Vérifie si le stock est critique (inférieur à 5 unités par exemple)
     * Utile pour afficher une alerte "Plus que quelques exemplaires !"
     */
    public function hasLowStock(): bool
    {
        return $this->stock_quantity > 0 && $this->stock_quantity <= 5;
    }

    /**
     * Accesseur pour le prix final formaté
     * Utilisation : $product->formatted_final_price
     */
    public function getFormattedFinalPriceAttribute(): string
    {
        // Appel statique au helper
        return CurrencyHelper::format($this->final_price);
    }

    /**
     * Scope (Filtre) pour ne récupérer que les produits en stock
     * Utilisation : Product::available()->get();
     */
    public function scopeAvailable($query)
    {
        // On filtre par visibilité ET par quantité en stock
        return $query->where('is_visible', true)
                     ->where('stock_quantity', '>', 0);
    }
    
}