<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        // 1. PROMOTIONS
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nom marketing de l opération');
            $table->enum('type', ['percentage', 'fixed'])->comment('Type de remise : pourcentage ou montant fixe');
            $table->decimal('value', 12, 2)->comment('Valeur de la remise (ex: 20.00)');
            $table->timestamp('start_date')->nullable()->comment('Date de début de validité');
            $table->timestamp('end_date')->nullable()->comment('Date de fin de validité');
            $table->boolean('is_active')->default(true)->comment('Statut d activation manuel');
            $table->timestamps();
        });

        // 2. CATEGORIES
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade')->comment('ID de la catégorie parente');
            $table->foreignId('promotion_id')->nullable()->constrained()->onDelete('set null')->comment('Promotion de catégorie');
            $table->string('name')->comment('Nom de la catégorie');
            $table->string('slug')->unique()->comment('URL simplifiée');
            $table->text('description')->nullable()->comment('Description SEO');
            $table->boolean('is_active')->default(true)->comment('Visibilité site');
            $table->timestamps();
        });

        // 3. BRANDS
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nom de la marque');
            $table->string('slug')->unique()->comment('URL simplifiée');
            $table->string('logo')->nullable()->comment('Chemin logo');
            $table->string('website')->nullable()->comment('Site officiel');
            $table->boolean('is_active')->default(true)->comment('Statut activation');
            $table->timestamps();
        });

        // 4. PRODUCTS
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade')->comment('Lien catégorie');
            $table->foreignId('brand_id')->constrained()->onDelete('cascade')->comment('Lien marque');
            $table->foreignId('promotion_id')->nullable()->constrained()->onDelete('set null')->comment('Promotion spécifique');
            
            $table->string('sku')->unique()->comment('Référence interne unique');
            $table->string('name')->comment('Nom commercial');
            $table->string('slug')->unique()->comment('URL unique');
            $table->string('short_description')->nullable()->comment('Accroche listes');
            $table->longText('description')->comment('Description complète');
            
            $table->decimal('regular_price', 12, 2)->comment('Prix standard');
            $table->decimal('cost_price', 12, 2)->nullable()->comment('Prix d achat (marge)');
            $table->integer('stock_quantity')->default(0)->comment('Stock disponible');
            $table->decimal('weight', 8, 2)->nullable()->comment('Poids en kg');
            
            $table->string('featured_image')->comment('Image principale');
            $table->boolean('is_visible')->default(true)->comment('Public/Brouillon');
            $table->boolean('is_featured')->default(false)->comment('Mise en avant');
            
            $table->softDeletes()->comment('Archivage logique');
            $table->timestamps();
        });

        // 5. PRODUCT IMAGES
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade')->comment('ID produit');
            $table->string('path')->comment('Lien fichier');
            $table->integer('sort_order')->default(0)->comment('Ordre galerie');
            $table->timestamps();
        });

        // 6. ACTIVITY LOGS (Monitoring)
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null')->comment('Auteur action');
            $table->unsignedBigInteger('loggable_id')->comment('ID objet suivi');
            $table->string('loggable_type')->comment('Type objet (Product, etc)');
            $table->string('event')->comment('Action (created, updated, deleted)');
            $table->json('old_values')->nullable()->comment('Avant');
            $table->json('new_values')->nullable()->comment('Après');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->comment('Clé unique du paramètre (ex: currency_symbol)');
            $table->text('value')->nullable()->comment('Valeur du paramètre');
            $table->string('description')->nullable()->comment('Explication pour l admin');
            $table->timestamps();
        });

        // Insertion des valeurs par défaut directement à la création
        DB::table('settings')->insert([
            ['key' => 'currency_symbol', 'value' => 'MAD', 'description' => 'Symbole monétaire'],
            ['key' => 'currency_position', 'value' => 'suffix', 'description' => 'Position (prefix ou suffix)'],
            ['key' => 'decimal_separator', 'value' => ',', 'description' => 'Séparateur décimal'],
        ]);

    }
    
    public function down(): void {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('promotions');
        Schema::dropIfExists('settings');
    }
};