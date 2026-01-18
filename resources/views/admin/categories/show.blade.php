@extends('layouts.admin')

@section('title', 'Détails ' . $category->name)

@section('content')
    <div class="max-w-5xl mx-auto px-4">
        <div class="flex items-center justify-between mb-10">
            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center text-sm font-bold text-gray-400 hover:text-indigo-600 transition group">
                <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
                Retour liste
            </a>
            <a href="{{ route('admin.category.edit', $category->id) }}" class="px-6 py-3 bg-white border border-gray-200 rounded-2xl font-black text-xs uppercase tracking-widest text-gray-600 hover:bg-gray-50 transition shadow-sm">
                Modifier
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden mb-10">
            <div class="p-10 bg-indigo-50/30">
                <div class="flex items-center gap-4 mb-4">
                    <span class="px-3 py-1 rounded-lg text-xs font-black uppercase tracking-widest {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $category->is_active ? 'Active' : 'Masquée' }}
                    </span>
                    <span class="text-gray-400 font-bold text-xs font-mono">/category/{{ $category->slug }}</span>
                </div>
                <h1 class="text-4xl font-black text-gray-900 uppercase tracking-tighter">{{ $category->name }}</h1>
                <p class="mt-4 text-gray-600 font-medium">{{ $category->description ?? 'Aucune description définie.' }}</p>
            </div>
        </div>

        <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tighter mb-6">Produits associés</h2>
        <div class="bg-white p-10 rounded-3xl border border-gray-100 text-center shadow-sm">
            <p class="text-gray-400 font-bold italic">La gestion des produits arrive à la prochaine étape.</p>
        </div>
    </div>
@endsection