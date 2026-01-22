{{-- On étend le layout commun pour garder la structure header/footer --}}
@extends('layouts.admin')

{{-- Titre dynamique avec le nom du produit --}}
@section('title', 'Modifier : ' . $product->name)

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6">
    
    {{-- Bouton de retour vers la liste --}}
    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-sm font-bold text-gray-400 hover:text-indigo-600 transition mb-6 group">
        <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path>
        </svg>
        Retour aux produits
    </a>

    {{-- Formulaire d'édition - enctype pour les fichiers --}}
    <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- COLONNE GAUCHE : Informations principales (2/3 de l'espace) --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Bloc 1 : Informations générales --}}
                <div class="bg-white p-6 md:p-8 rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100">
                    <h2 class="text-xl font-black text-gray-900 uppercase tracking-tight mb-6">Informations Générales</h2>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Nom commercial</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full px-5 py-4 rounded-2xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all font-bold text-gray-800" required>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Référence (SKU)</label>
                            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full px-5 py-4 rounded-2xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all font-bold text-gray-800" required>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2 italic">Description complète</label>
                            <textarea name="description" rows="6" class="w-full px-5 py-4 rounded-2xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all font-medium text-gray-700">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- BLOC 3 : GALERIE LARGE --}}
                <div class="bg-white p-6 md:p-8 rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-xl font-black text-gray-900 uppercase tracking-tight">Galerie Photos</h2>
                            <p class="text-gray-400 text-xs font-medium italic mt-1">Visuels secondaires du produit.</p>
                        </div>
                        
                        {{-- Bouton d'ajout stylisé --}}
                        <div class="relative">
                            <input type="file" name="images[]" multiple id="gallery-input" class="hidden" onchange="this.form.submit()">
                            <label for="gallery-input" class="cursor-pointer bg-indigo-50 text-indigo-700 px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all inline-flex items-center shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Ajouter
                            </label>
                        </div>
                    </div>

                    @if($product->images->count() > 0)
                        {{-- Grille responsive 4 colonnes --}}
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($product->images as $image)
                                <div class="relative group aspect-square rounded-2xl overflow-hidden border-2 border-gray-50 bg-gray-50 shadow-sm transition-all hover:shadow-md">
                                    <img src="{{ asset('storage/' . $image->path) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                                    
                                    {{-- Badge d'ordre --}}
                                    <div class="absolute top-2 left-2 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded-lg shadow-sm">
                                        <span class="text-[9px] font-black text-gray-800">#{{ $image->sort_order }}</span>
                                    </div>

                                    {{-- Overlay de suppression --}}
                                    <div class="absolute inset-0 bg-red-600/80 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer" onclick="deleteImage({{ $image->id }})">
                                        <div class="text-center">
                                            <svg class="w-6 h-6 text-white mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            <span class="text-[8px] text-white font-black uppercase tracking-tighter">Supprimer</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-12 border-2 border-dashed border-gray-100 rounded-3xl flex flex-col items-center justify-center bg-gray-50/30">
                            <p class="text-xs font-black text-gray-300 uppercase tracking-widest tracking-tighter">Galerie vide</p>
                        </div>
                    @endif
                </div>

                {{-- Bloc 2 : Prix et Stock --}}
                <div class="bg-white p-6 md:p-8 rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100">
                    <h2 class="text-xl font-black text-gray-900 uppercase tracking-tight mb-6">Tarification et Inventaire</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Prix standard (€)</label>
                            <input type="number" step="0.01" name="regular_price" value="{{ old('regular_price', $product->regular_price) }}" class="w-full px-5 py-4 rounded-2xl border border-gray-200 font-bold text-gray-800" required>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Stock disponible</label>
                            <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" class="w-full px-5 py-4 rounded-2xl border border-gray-200 font-bold text-gray-800" required>
                        </div>
                    </div>
                </div>

                
            </div>

            {{-- COLONNE DROITE : Paramètres et Image (1/3 de l'espace) --}}
            <div class="space-y-6">
                
                {{-- Bloc : Organisation --}}
                <div class="bg-white p-6 md:p-8 rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100">
                    <h2 class="text-lg font-black text-gray-900 uppercase tracking-tight mb-6">Organisation</h2>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Catégorie</label>
                            <select name="category_id" class="w-full px-5 py-4 rounded-2xl border border-gray-200 font-bold text-gray-800 appearance-none bg-white shadow-sm" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Marque (Brand)</label>
                            <select name="brand_id" class="w-full px-5 py-4 rounded-2xl border border-gray-200 font-bold text-gray-800 appearance-none bg-white shadow-sm" required>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ (old('brand_id', $product->brand_id) == $brand->id) ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Bloc : Image Principale --}}
                <div class="bg-white p-6 md:p-8 rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100">
                    <h2 class="text-lg font-black text-gray-900 uppercase tracking-tight mb-6">Visuel Principal</h2>
                    
                    <div class="space-y-4">
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $product->featured_image) }}" class="w-full h-40 object-cover rounded-2xl shadow-md border border-gray-100">
                        </div>

                        <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Changer l'image</label>
                        <input type="file" name="featured_image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all cursor-pointer">
                    </div>
                </div>

                {{-- Bloc : Statuts --}}
                <div class="bg-white p-6 md:p-8 rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black text-gray-700 uppercase tracking-widest">En ligne</span>
                        <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', $product->is_visible) ? 'checked' : '' }} class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black text-gray-700 uppercase tracking-widest">Mise en avant</span>
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    </div>
                </div>

                {{-- Bouton de validation --}}
                <button type="submit" class="w-full py-5 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl shadow-xl shadow-indigo-200 transition-all uppercase tracking-widest text-sm active:scale-[0.98]">
                    Enregistrer tout
                </button>
            </div>
        </div>
    </form>
</div>

{{-- Script de suppression --}}
<script>
    function deleteImage(imageId) {
        if (confirm('Supprimer cette image de la galerie ?')) {
            let form = document.createElement('form');
            form.action = `/admin/product-image/${imageId}`; // Adapter à ta route
            form.method = 'POST';
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>

@endsection