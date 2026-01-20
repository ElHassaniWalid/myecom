<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- Titre de la page : défini dans chaque vue enfant via @section('title') --}}
    <title>@yield('title', 'Administration')</title>
    
    {{-- Importation du CDN Tailwind CSS pour le stylage rapide --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 antialiased font-sans">

    {{-- BARRE DE NAVIGATION (HEADER) --}}
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                
                {{-- Logo et Identité visuelle --}}
                <div class="flex items-center">
                    <span class="text-lg md:text-xl font-black text-indigo-600 uppercase tracking-tighter truncate">
                        Mon E-Shop Admin
                    </span>
                </div>
                
                {{-- Actions de droite : Recherche et Profil --}}
                <div class="flex items-center space-x-2 md:space-x-4">
                    {{-- Barre de recherche : cachée sur mobile (hidden), visible sur PC (md:block) --}}
                    <div class="relative hidden md:block">
                        <input type="text" placeholder="Rechercher..." class="bg-gray-100 text-sm rounded-full pl-4 pr-10 py-2 focus:outline-none">
                        <svg class="w-4 h-4 text-gray-400 absolute right-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    
                    {{-- Badge Profil Utilisateur --}}
                    <div class="h-8 w-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold text-xs">AD</div>
                </div>
            </div>
        </div>
    </header>

    {{-- ZONE DE CONTENU DYNAMIQUE --}}
    <main class="py-6 md:py-10">
        {{-- Ici sera injecté le contenu de chaque page (index, create, etc.) --}}
        @yield('content')
    </main>

    {{-- PIED DE PAGE --}}
    <footer class="text-center py-6 text-gray-400 text-xs font-medium">
        &copy; {{ date('Y') }} Admin Dashboard - Style Premium
    </footer>

</body>
</html>