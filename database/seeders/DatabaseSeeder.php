<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Créer un administrateur pour le monitoring
        User::factory()->create([
            'name' => 'Admin Shop',
            'email' => 'admin@shop.com',
        ]);

        // 2. Créer des Promotions
        $summerSale = Promotion::create([
            'name' => 'Summer Sale',
            'type' => 'percentage',
            'value' => 20.00,
            'is_active' => true,
        ]);

        $flashSale = Promotion::create([
            'name' => 'Flash 10€',
            'type' => 'fixed',
            'value' => 10.00,
            'is_active' => true,
        ]);

        // 3. Créer des Marques (Brands)
        $brands = collect(['Apple', 'Samsung', 'Sony', 'Nike', 'Adidas'])->map(function ($name) {
            return Brand::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'is_active' => true,
            ]);
        });

        // 4. Créer des Catégories
        $tech = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'promotion_id' => $summerSale->id // Toute l'électronique est à -20%
        ]);

        $fashion = Category::create([
            'name' => 'Fashion',
            'slug' => 'fashion'
        ]);

        // 5. Créer des Produits
        Product::create([
            'category_id' => $tech->id,
            'brand_id' => $brands->firstWhere('name', 'Apple')->id,
            'promotion_id' => $flashSale->id, // Promotion spécifique qui écrasera celle de la catégorie
            'sku' => 'IPH-15-PRO',
            'name' => 'iPhone 15 Pro',
            'slug' => 'iphone-15-pro',
            'short_description' => 'Le dernier iPhone avec finition titane.',
            'description' => 'Découvrez l’iPhone 15 Pro, doté d’une puce A17 Pro révolutionnaire.',
            'regular_price' => 1299.00,
            'cost_price' => 900.00,
            'stock_quantity' => 25,
            'weight' => 0.187,
            'featured_image' => 'https://via.placeholder.com/600x400.png?text=iPhone+15',
            'is_visible' => true,
            'is_featured' => true,
        ]);

        Product::create([
            'category_id' => $fashion->id,
            'brand_id' => $brands->firstWhere('name', 'Nike')->id,
            'sku' => 'NK-AIR-MAX',
            'name' => 'Nike Air Max',
            'slug' => 'nike-air-max',
            'short_description' => 'Confort et style iconique.',
            'description' => 'La chaussure de running légendaire revisitée.',
            'regular_price' => 150.00,
            'cost_price' => 60.00,
            'stock_quantity' => 100,
            'weight' => 0.800,
            'featured_image' => 'https://via.placeholder.com/600x400.png?text=Nike+AirMax',
            'is_visible' => true,
            'is_featured' => false,
        ]);

    }
}