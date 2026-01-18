<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Le titre est dynamique : chaque page enfant pourra définir son propre titre --}}
    <title>@yield('title', 'Administration')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 antialiased font-sans">

    {{-- === HEADER PARTAGÉ === --}}
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-black text-indigo-600 uppercase tracking-tighter">Mon E-Shop Admin</span>
                </div>
                
                {{-- Barre de recherche ou Menu Utilisateur --}}
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Rechercher..." class="bg-gray-100 text-sm rounded-full pl-4 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                        <svg class="w-4 h-4 text-gray-400 absolute right-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <div class="h-8 w-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold text-xs">AD</div>
                </div>
            </div>
        </div>
    </header>

    {{-- === CONTENU SPÉCIFIQUE À CHAQUE PAGE === --}}
    <main class="py-10">
        {{-- C'est ici que le contenu des vues "enfants" sera injecté --}}
        @yield('content')
    </main>

    {{-- === FOOTER PARTAGÉ === --}}
    <footer class="text-center py-6 text-gray-400 text-xs font-medium">
        &copy; {{ date('Y') }} Administration. Tous droits réservés.
    </footer>

</body>
</html>