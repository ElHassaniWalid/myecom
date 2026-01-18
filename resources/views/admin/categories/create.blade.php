@extends('layouts.admin')

@section('title', 'Nouvelle Catégorie')

@section('content')
    <div class="max-w-2xl mx-auto px-4">
        <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center text-sm font-bold text-gray-400 hover:text-indigo-600 transition mb-6 group">
            <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
            Retour liste
        </a>

        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
            <div class="p-8 border-b border-gray-100 bg-indigo-50/30">
                <h1 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Nouvelle Catégorie</h1>
                <p class="text-gray-500 text-sm mt-1 font-medium italic">Ajouter une section au catalogue.</p>
            </div>

            <form action="{{ route('admin.category.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                
                {{-- Champs du formulaire (inchangés) --}}
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Nom</label>
                    <input type="text" name="name" class="w-full px-5 py-4 rounded-2xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-gray-800" placeholder="Ex: Informatique" required>
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Parent</label>
                    <div class="relative">
                        <select name="parent_id" class="w-full px-5 py-4 rounded-2xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none appearance-none bg-white font-bold text-gray-800">
                            <option value="">-- Racine --</option>
                            @foreach($parentCategories as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full px-5 py-4 rounded-2xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-medium text-gray-700"></textarea>
                </div>

                <div class="flex items-center justify-between p-5 bg-gray-50 rounded-2xl border border-gray-100">
                    <span class="font-black text-gray-700 text-xs uppercase tracking-widest">Activer immédiatement</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    </label>
                </div>

                <button type="submit" class="w-full py-5 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl shadow-lg shadow-indigo-100 transition-all uppercase tracking-widest text-sm active:scale-[0.98]">
                    Créer la catégorie
                </button>
            </form>
        </div>
    </div>
@endsection