@extends('layouts.admin')

@section('title', 'Gestion des Produits')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6">
    
    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
        <div>
            <h1 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">Produits</h1>
            <p class="text-gray-500 text-sm font-medium mt-1">Gérez votre inventaire et vos prix.</p>
        </div>
        {{-- Lien singulier vers la création --}}
        <a href="{{ route('admin.product.create') }}" class="inline-flex items-center px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl transition-all shadow-xl shadow-indigo-200 uppercase tracking-widest text-xs">
            + Nouveau Produit
        </a>
    </div>

    {{-- TABLEAU RESPONSIVE --}}
    <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead class="bg-indigo-50/30 border-b border-gray-100">
                    <tr>
                        <th class="px-8 py-5 text-xs font-black text-gray-400 uppercase tracking-widest">Produit</th>
                        <th class="px-8 py-5 text-xs font-black text-gray-400 uppercase tracking-widest">Catégorie / Marque</th>
                        <th class="px-8 py-5 text-xs font-black text-gray-400 uppercase tracking-widest">Prix</th>
                        <th class="px-8 py-5 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Stock</th>
                        <th class="px-8 py-5 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($products as $product)
                    <tr class="hover:bg-indigo-50/10 transition-colors">
                        {{-- Image et Nom --}}
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('storage/' . $product->featured_image) }}" class="w-14 h-14 rounded-2xl object-cover shadow-sm border border-gray-100">
                                <div>
                                    <div class="font-black text-gray-900 uppercase tracking-tight">{{ $product->name }}</div>
                                    <div class="text-[10px] text-gray-400 font-bold font-mono">SKU: {{ $product->sku }}</div>
                                </div>
                            </div>
                        </td>
                        {{-- Relations --}}
                        <td class="px-8 py-6">
                            <span class="block text-xs font-black text-indigo-600 uppercase">{{ $product->category->name }}</span>
                            <span class="block text-[10px] text-gray-400 font-bold">{{ $product->brand->name }}</span>
                        </td>
                        {{-- Prix --}}
                        <td class="px-8 py-6 font-black text-gray-900 text-sm">
                            {{ number_format($product->regular_price, 2) }} €
                        </td>
                        {{-- Stock avec couleur dynamique --}}
                        <td class="px-8 py-6 text-center">
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase {{ $product->stock_quantity > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $product->stock_quantity }} en stock
                            </span>
                        </td>
                        {{-- Actions --}}
                        <td class="px-8 py-6 text-right space-x-2">
                            <a href="{{ route('admin.product.edit', $product->id) }}" class="inline-flex py-2 px-4 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 font-black rounded-xl text-[10px] uppercase tracking-widest transition">Modifier</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection