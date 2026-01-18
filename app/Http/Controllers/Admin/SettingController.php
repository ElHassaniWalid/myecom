<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * Affiche le formulaire de configuration
     */
    public function index()
    {
        // On récupère tous les réglages pour les afficher
        $settings = Setting::all();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Met à jour les réglages en masse
     */
    public function update(Request $request)
    {
        // Validation basique
        $data = $request->validate([
            'settings' => 'required|array',
        ]);

        foreach ($data['settings'] as $key => $value) {
            // Mise à jour en base de données
            Setting::where('key', $key)->update(['value' => $value]);
            
            // Nettoyage du cache pour forcer la lecture de la nouvelle valeur
            Cache::forget("setting.{$key}");
        }

        return redirect()->back()->with('success', 'Paramètres mis à jour avec succès !');
    }
}