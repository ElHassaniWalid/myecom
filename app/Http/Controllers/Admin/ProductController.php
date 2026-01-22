<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ProductImage;

class ProductController extends Controller
{
    /**
     * ACTION : index
     * ROUTE : GET /admin/products
     * ROLE : Affiche la liste de tous les produits avec pagination
     */
    public function index()
    {
        // Récupère les produits avec leurs relations (Eager Loading) pour optimiser la base de données
        // On utilise latest() pour voir les nouveaux produits en premier
        $products = Product::with(['category', 'brand'])->latest()->paginate(10);

        // Retourne la vue index située dans resources/views/admin/products/
        return view('admin.products.index', compact('products'));
    }

    /**
     * ACTION : create
     * ROUTE : GET /admin/product/create
     * ROLE : Affiche le formulaire de création de produit
     */
    public function create()
    {
        // On a besoin des catégories et marques pour remplir les listes déroulantes (select)
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * ACTION : edit
     * ROUTE : GET /admin/product/{id}/edit
     * ROLE : Récupère le produit et affiche le formulaire de modification
     */
    public function edit($id)
    {
        // On récupère le produit par son ID ou on renvoie une erreur 404 s'il n'existe pas
        $product = Product::findOrFail($id);
        
        // On récupère les catégories et marques pour les listes déroulantes du formulaire
        $categories = Category::all();
        $brands = Brand::all();

        // On passe les données à la vue
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * ACTION : update
     * ROUTE : PUT /admin/product/{id}/update
     * ROLE : Valide et enregistre les modifications du produit
     */
    public function update(Request $request, $id)
    {
        // 1. Récupération du produit ou erreur 404
        $product = Product::findOrFail($id);

        // 2. Validation des données
        $validated = $request->validate([
            'name' => 'required|max:255',
            'sku' => 'required|unique:products,sku,' . $product->id,
            'regular_price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'featured_image' => 'nullable|image|max:2048',
            'images.*' => 'nullable|image|max:2048',
        ]);

        // 3. GESTION DES CASES À COCHER (RÉ-INTÉGRÉ)
        // On force la valeur car si décoché, la clé est absente du $request
        $validated['is_visible'] = $request->has('is_visible');
        $validated['is_featured'] = $request->has('is_featured');
        
        // 4. Mise à jour du slug et des données textuelles
        $validated['slug'] = Str::slug($request->name);

        // 5. Gestion de l'image principale
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('products', 'public');
            $validated['featured_image'] = $path;
        }

        // 6. Sauvegarde des modifications du produit
        $product->update($validated);

        // 7. Ajout de nouvelles images à la galerie via la fonction isolée
        if ($request->hasFile('images')) {
            $this->uploadProductImages($product, $request->file('images'));
        }

        return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour avec succès');
    }

    /**
     * ACTION : store
     * ROUTE : POST /admin/product/store
     * ROLE : Valide et enregistre le produit dans la base de données
     */
    public function store(Request $request)
    {
        // 1. Validation (Si elle échoue, Laravel redirige vers le formulaire avec les erreurs)
        $validated = $request->validate([
            'name' => 'required|max:255',
            'sku' => 'required|unique:products,sku',
            'regular_price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'featured_image' => 'required|image|max:2048',
            'description' => 'required',
        ]);

        // 2. Gestion de l'image (Vérifie que le dossier storage est lié : php artisan storage:link)
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('products', 'public');
        }

        // 3. Création du produit avec tous tes champs spécifiques
        $product = Product::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'sku' => $request->sku,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'regular_price' => $request->regular_price,
            'cost_price' => $request->cost_price,
            'stock_quantity' => $request->stock_quantity,
            'weight' => $request->weight,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'featured_image' => $path ?? null,
            'is_visible' => $request->has('is_visible'),
            'is_featured' => $request->has('is_featured'),
        ]);

        // 4. Traitement de la galerie via la fonction isolée
        if ($request->hasFile('images')) {
            $this->uploadProductImages($product, $request->file('images'));
        }

        // 5. Redirection avec message Flash
        return redirect()->route('admin.products.index')->with('success', 'Produit créé !');
    }

    /**
     * FONCTION ISOLÉE : Gestion technique de la galerie
     */
    private function uploadProductImages(Product $product, array $files)
    {
        // On récupère le dernier sort_order pour incrémenter correctement
        $lastOrder = $product->images()->max('sort_order') ?? -1;

        foreach ($files as $index => $file) {
            $path = $file->store('products/gallery', 'public');

            $product->images()->create([
                'path' => $path,
                'sort_order' => $lastOrder + $index + 1
            ]);
        }
    }

}