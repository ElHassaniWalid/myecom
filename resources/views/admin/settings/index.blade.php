<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Paramètres</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="max-w-2xl mx-auto py-12">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Configuration du Store</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            
            @foreach($settings as $setting)
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="{{ $setting->key }}">
                        {{ $setting->description }} 
                        <span class="text-gray-400 font-normal text-xs">({{ $setting->key }})</span>
                    </label>

                    @if($setting->key == 'currency_position')
                        {{-- Menu déroulant pour la position --}}
                        <select name="settings[{{ $setting->key }}]" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="prefix" {{ $setting->value == 'prefix' ? 'selected' : '' }}>Préfixe ($ 100)</option>
                            <option value="suffix" {{ $setting->value == 'suffix' ? 'selected' : '' }}>Suffixe (100 $)</option>
                        </select>
                    @else
                        {{-- Champ texte classique --}}
                        <input type="text" 
                               name="settings[{{ $setting->key }}]" 
                               value="{{ $setting->value }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @endif
                </div>
            @endforeach

            <div class="flex items-center justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
        
        <a href="{{ route('products.index') }}" class="text-blue-500 hover:underline">← Retour au shop</a>
    </div>
</body>
</html>