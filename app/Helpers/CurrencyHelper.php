<?php

namespace App\Helpers;

use App\Models\Setting;

class CurrencyHelper
{
    /**
     * Formate le montant selon les réglages de la base de données
     */
    public static function format($amount): string
    {
        // Récupération des paramètres gérés par l'admin
        $symbol = Setting::getValue('currency_symbol', '€');
        $position = Setting::getValue('currency_position', 'suffix');
        $separator = Setting::getValue('decimal_separator', ',');

        // Formatage numérique
        $formattedAmount = number_format($amount, 2, $separator, ' ');

        // Construction de la chaîne finale
        return $position === 'prefix' 
            ? $symbol . ' ' . $formattedAmount 
            : $formattedAmount . ' ' . $symbol;
    }
}