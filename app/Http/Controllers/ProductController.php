<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Affiche la liste des produits avec leurs promotions calculées
     */
    public function index()
    {
        // On récupère les produits avec leurs relations pour optimiser les requêtes (Eager Loading)
        // On ne prend que les produits visibles
        $products = Product::with(['category.promotion', 'brand', 'promotion'])
            ->where('is_visible', true)
            ->latest()
            ->paginate(12);

        // Envoi des données à la vue
        return view('products.index', compact('products'));
    }
}