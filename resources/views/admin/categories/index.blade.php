{{-- On appelle le layout parent --}}
@extends('layouts.admin')

{{-- On définit le titre de la page --}}
@section('title', 'Liste des Catégories')

{{-- On injecte le contenu dans la section 'content' du layout --}}
@section('content')
    <div class="max-w-6xl mx-auto px-4">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
            <div>
                <h1 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">Catégories</h1>
                <p class="text-gray-500 text-sm font-medium mt-1">Gérez l'arborescence de votre catalogue.</p>
            </div>
            <a href="{{ route('admin.category.create') }}" class="inline-flex items-center px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl transition-all shadow-xl shadow-indigo-200 uppercase tracking-widest text-xs active:scale-[0.98]">
                + Nouvelle Catégorie
            </a>
        </div>

        @if(session('success'))
            <div class="mb-8 p-5 bg-white border-l-4 border-green-500 rounded-2xl shadow-sm flex items-center text-green-700 font-bold">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
            <table class="w-full text-left">
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
                        <td class="px-8 py-6">
                            <div class="font-black text-gray-900 text-lg uppercase tracking-tight">{{ $category->name }}</div>
                            <div class="text-xs text-indigo-400 font-bold font-mono mt-1">/category/{{ $category->slug }}</div>
                        </td>
                        <td class="px-8 py-6">
                            @if($category->parent)
                                <span class="px-3 py-1 rounded-lg text-xs font-black bg-gray-100 text-gray-600 uppercase tracking-wider">{{ $category->parent->name }}</span>
                            @else
                                <span class="text-gray-300 font-medium italic text-sm">Racine</span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="inline-flex px-3 py-1 rounded-lg text-xs font-black uppercase tracking-wider {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $category->is_active ? 'Visible' : 'Masquée' }}
                            </span>
                        </td>
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
@endsection