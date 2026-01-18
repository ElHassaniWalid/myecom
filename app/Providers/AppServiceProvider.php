<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Promotion;
use App\Observers\ModelObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Helpers\CurrencyHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // On attache l'Observer aux modèles principaux pour le monitoring
        Product::observe(ModelObserver::class);
        Category::observe(ModelObserver::class);
        Promotion::observe(ModelObserver::class);

        // Création d'une directive Blade personnalisée @currency($montant)
        // C'est encore plus puissant que l'alias pour le côté Blade !
        Blade::directive('currency', function ($expression) {
            return "<?php echo \App\Helpers\CurrencyHelper::format($expression); ?>";
        });
    }
}
