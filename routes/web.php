<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;

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
    
});

