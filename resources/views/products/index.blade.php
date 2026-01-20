<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon E-Commerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3-xl font-bold mb-8 text-center text-gray-800">Catalogue Produits</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    {{-- Image du produit --}}
                    <img src="{{ asset('storage/' . $product->featured_image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    
                    <div class="p-4">
                        {{-- Marque et Catégorie --}}
                        <p class="text-xs text-blue-600 font-semibold uppercase">{{ $product->brand->name }} | {{ $product->category->name }}</p>
                        <h2 class="text-lg font-bold text-gray-900 mt-1">{{ $product->name }}</h2>
                        
                        <div class="mt-2">
                            @if($product->inStock())
                                @if($product->hasLowStock())
                                    <span class="text-orange-500 text-sm font-medium">
                                        ⚠️ Plus que {{ $product->stock_quantity }} exemplaires !
                                    </span>
                                @else
                                    <span class="text-green-600 text-sm font-medium">
                                        ✅ En stock ({{ $product->stock_quantity }})
                                    </span>
                                @endif
                            @else
                                <span class="text-red-500 text-sm font-medium">
                                    ❌ Rupture de stock
                                </span>
                            @endif
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            {{-- Utilisation de l'Accessor final_price créé dans le Model --}}
                            @if($product->final_price < $product->regular_price)
                                <div>
                                    <span class="text-red-600 font-bold text-xl">@currency($product->final_price)</span>
                                    <span class="text-gray-400 line-through text-sm ml-2">@currency($product->regular_price)</span>
                                </div>
                                <span class="bg-red-500 text-white text-[10px] px-2 py-1 rounded-full font-bold">PROMO</span>
                            @else
                                <span class="text-gray-900 font-bold text-xl">@currency($product->regular_price)</span>
                            @endif
                        </div>

                        {{-- Modifier le bouton d'ajout --}}
                        <button 
                            {{ !$product->inStock() ? 'disabled' : '' }}
                            class="w-full mt-4 py-2 rounded transition {{ !$product->inStock() ? 'bg-gray-300 cursor-not-allowed' : 'bg-gray-800 text-white hover:bg-black' }}">
                            {{ $product->inStock() ? 'Ajouter au panier' : 'Indisponible' }}
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</body>
</html>