<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Affiche la liste des catégories
     */
    public function index()
    {
        $categories = Category::with('parent')->get(); // On charge le parent pour éviter N+1 requêtes
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('parentCategories'));
    }

    /**
     * Enregistre une nouvelle catégorie
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|max:255|unique:categories,name',
            'description' => 'nullable',
        ]);

        // Création
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // Génération auto du slug
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie créée avec succès !');
    }

    /**
     * Affiche une catégorie spécifique
     */
    public function show($slug)
    {
        // On récupère via le slug
        $category = Category::where('slug', $slug)->firstOrFail();
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Category $category)
    {
        $parentCategories = Category::where('id', '!=', $category->id)->whereNull('parent_id')->get();
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Met à jour la catégorie
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour !');
    }
}