@extends('layouts.admin') {{-- Utilisation du squelette HTML commun --}}

@section('title', 'Liste des Catégories') {{-- Définition du titre dynamiquement --}}

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        
        {{-- EN-TÊTE DE PAGE --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-black text-gray-900 uppercase tracking-tighter">Catégories</h1>
                <p class="text-gray-500 text-sm font-medium mt-1">Gérez l'arborescence du catalogue.</p>
            </div>
            
            {{-- BOUTON D'ACTION : Redirige vers la création (Route au singulier) --}}
            <a href="{{ route('admin.category.create') }}" class="w-full md:w-auto text-center inline-flex items-center justify-center px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-xl md:rounded-2xl transition-all shadow-xl shadow-indigo-200 uppercase tracking-widest text-xs active:scale-[0.98]">
                + Nouvelle Catégorie
            </a>
        </div>

        {{-- MESSAGE DE SUCCÈS : S'affiche après une action (Store/Update) --}}
        @if(session('success'))
            <div class="mb-8 p-5 bg-white border-l-4 border-green-500 rounded-2xl shadow-sm text-green-700 font-bold">
                {{ session('success') }}
            </div>
        @endif

        {{-- TABLEAU DES DONNÉES --}}
        <div class="bg-white rounded-2xl md:rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
            {{-- overflow-x-auto permet de "slider" le tableau sur mobile sans casser le design --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead class="bg-indigo-50/30 border-b border-gray-100">
                        <tr>
                            <th class="px-8 py-5 text-xs font-black text-gray-400 uppercase tracking-widest">Nom & Slug</th>
                            <th class="px-8 py-5 text-xs font-black text-gray-400 uppercase tracking-widest">Parent</th>
                            <th class="px-8 py-5 text-xs font-black text-gray-400 uppercase tracking-widest text-center">État</th>
                            <th class="px-8 py-5 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($categories as $category)
                        <tr class="hover:bg-indigo-50/10 transition-colors">
                            {{-- Cellule Nom et Slug : Style Premium --}}
                            <td class="px-8 py-6">
                                <div class="font-black text-gray-900 text-sm md:text-lg uppercase tracking-tight">{{ $category->name }}</div>
                                <div class="text-xs text-indigo-400 font-bold font-mono mt-1">/{{ $category->slug }}</div>
                            </td>
                            {{-- Cellule Parent : Affiche le nom ou 'Racine' si pas de parent --}}
                            <td class="px-8 py-6">
                                @if($category->parent)
                                    <span class="px-3 py-1 rounded-lg text-xs font-black bg-gray-100 text-gray-600 uppercase tracking-wider">
                                        {{ $category->parent->name }}
                                    </span>
                                @else
                                    <span class="text-gray-300 font-medium italic text-sm">Racine</span>
                                @endif
                            </td>
                            {{-- Cellule État : Badge dynamique Vert/Rouge --}}
                            <td class="px-8 py-6 text-center">
                                <span class="inline-flex px-3 py-1 rounded-lg text-xs font-black uppercase tracking-wider {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $category->is_active ? 'Visible' : 'Masquée' }}
                                </span>
                            </td>
                            {{-- Cellule Actions : Liens Voir et Éditer --}}
                            <td class="px-8 py-6 text-right space-x-2">
                                <a href="{{ route('admin.category.show', $category->slug) }}" class="inline-flex py-2 px-4 bg-gray-50 hover:bg-gray-100 text-gray-600 font-black rounded-xl text-xs uppercase tracking-widest transition">Voir</a>
                                <a href="{{ route('admin.category.edit', $category->id) }}" class="inline-flex py-2 px-4 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 font-black rounded-xl text-xs uppercase tracking-widest transition">Éditer</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection