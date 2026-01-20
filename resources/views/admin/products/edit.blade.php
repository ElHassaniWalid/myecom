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

    {{-- Formulaire d'édition - Action pointe vers 'update' avec l'ID --}}
    <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT') {{-- Indispensable pour la modification en Laravel --}}

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- COLONNE GAUCHE : Informations principales (2/3 de l'espace) --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Bloc : Informations générales --}}
                <div class="bg-white p-6 md:p-8 rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100">
                    <h2 class="text-xl font-black text-gray-900 uppercase tracking-tight mb-6">Informations Générales</h2>
                    
                    <div class="space-y-6">
                        {{-- Champ Nom --}}
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Nom commercial</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full px-5 py-4 rounded-2xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all font-bold text-gray-800" required>
                        </div>

                        {{-- Champ SKU (Référence unique) --}}
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Référence (SKU)</label>
                            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full px-5 py-4 rounded-2xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all font-bold text-gray-800" required>
                        </div>

                        {{-- Descriptions --}}
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Accroche courte (Short Description)</label>
                            <input type="text" name="short_description" value="{{ old('short_description', $product->short_description) }}" class="w-full px-5 py-4 rounded-2xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all font-medium text-gray-700">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Description complète</label>
                            <textarea name="description" rows="6" class="w-full px-5 py-4 rounded-2xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all font-medium text-gray-700">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Bloc : Prix et Stock --}}
                <div class="bg-white p-6 md:p-8 rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100">
                    <h2 class="text-xl font-black text-gray-900 uppercase tracking-tight mb-6">Tarification et Inventaire</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Prix de vente --}}
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Prix standard (€)</label>
                            <input type="number" step="0.01" name="regular_price" value="{{ old('regular_price', $product->regular_price) }}" class="w-full px-5 py-4 rounded-2xl border border-gray-200 font-bold text-gray-800" required>
                        </div>
                        {{-- Prix d'achat --}}
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Prix d'achat (€)</label>
                            <input type="number" step="0.01" name="cost_price" value="{{ old('cost_price', $product->cost_price) }}" class="w-full px-5 py-4 rounded-2xl border border-gray-200 font-bold text-gray-800">
                        </div>
                        {{-- Quantité en stock --}}
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Stock disponible</label>
                            <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" class="w-full px-5 py-4 rounded-2xl border border-gray-200 font-bold text-gray-800" required>
                        </div>
                        {{-- Poids --}}
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Poids (kg)</label>
                            <input type="number" step="0.01" name="weight" value="{{ old('weight', $product->weight) }}" class="w-full px-5 py-4 rounded-2xl border border-gray-200 font-bold text-gray-800">
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
                        {{-- Sélection Catégorie --}}
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

                        {{-- Sélection Marque --}}
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
                    <h2 class="text-lg font-black text-gray-900 uppercase tracking-tight mb-6">Visuel</h2>
                    
                    <div class="space-y-4">
                        {{-- Aperçu de l'image actuelle --}}
                        <div class="mb-4">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 text-center">Image actuelle</p>
                            <img src="{{ asset('storage/' . $product->featured_image) }}" class="w-32 h-32 mx-auto object-cover rounded-2xl shadow-md border border-gray-100">
                        </div>

                        <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Remplacer l'image</label>
                        <input type="file" name="featured_image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all cursor-pointer">
                        <p class="text-[10px] text-gray-400 italic">Laissez vide pour conserver l'image actuelle.</p>
                    </div>
                </div>

                {{-- Bloc : Statuts (Visibilité / Featured) --}}
                <div class="bg-white p-6 md:p-8 rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black text-gray-700 uppercase tracking-widest">En ligne</span>
                        {{-- On utilise checked si la valeur est à 1 --}}
                        <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', $product->is_visible) ? 'checked' : '' }} class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black text-gray-700 uppercase tracking-widest">Mise en avant</span>
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    </div>
                </div>

                {{-- Bouton de validation --}}
                <button type="submit" class="w-full py-5 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl shadow-xl shadow-indigo-200 transition-all uppercase tracking-widest text-sm active:scale-[0.98]">
                    Enregistrer les modifications
                </button>
            </div>
        </div>
    </form>
</div>
@endsections