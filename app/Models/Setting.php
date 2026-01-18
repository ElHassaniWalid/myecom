<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'description'];

    /**
     * Méthode statique pour récupérer une valeur rapidement.
     * Utilise le cache pour éviter de requêter la BDD à chaque affichage de prix.
     */
    public static function getValue(string $key, $default = null)
    {
        // On garde les paramètres en cache pendant 24h
        return Cache::rememberForever("setting.{$key}", function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }
}