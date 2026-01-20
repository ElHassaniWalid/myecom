<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;

// Route pour la page d'accueil qui affiche le catalogue
Route::get('/', [ProductController::class, 'index'])->name('products.index');


// Groupe de routes pour l'administration
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // LISTE (Pluriel car collection) -> URL: /admin/categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

    // CRÉATION (Singulier car action unique) -> URL: /admin/category/create
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');

    // ÉDITION (Singulier) -> URL: /admin/category/{id}/edit
    Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/{category}/update', [CategoryController::class, 'update'])->name('category.update');

    // DÉTAIL (Singulier) -> URL: /admin/category/{slug}
    Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');


    // Routes pour les PRODUITS 
    // La route ci-dessous corrige l'erreur 404 pour admin/products 
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    
    // Routes unitaires au singulier selon tes règles 
    Route::get('/product/create', [AdminProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [AdminProductController::class, 'store'])->name('product.store');
    
    // Routes pour l'édition et la mise à jour (Prévues dans le tableau) 
    Route::get('/product/{id}/edit', [AdminProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{id}/update', [AdminProductController::class, 'update'])->name('product.update');
    
});

