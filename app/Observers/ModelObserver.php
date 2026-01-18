<?php

namespace App\Observers;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ModelObserver
{
    /**
     * Gère l'événement "création"
     */
    public function created(Model $model): void
    {
        $this->logEvent($model, 'created');
    }

    /**
     * Gère l'événement "mise à jour"
     */
    public function updated(Model $model): void
    {
        // On ne génère un log que si des colonnes ont réellement changé
        if ($model->wasChanged()) {
            $this->logEvent($model, 'updated');
        }
    }

    /**
     * Gère l'événement "suppression"
     */
    public function deleted(Model $model): void
    {
        $this->logEvent($model, 'deleted');
    }

    /**
     * Logique centrale pour enregistrer l'activité
     */
    protected function logEvent(Model $model, string $event): void
    {
        // Récupère uniquement les colonnes modifiées pour le log "updated"
        $oldValues = $event === 'updated' ? array_intersect_key($model->getOriginal(), $model->getChanges()) : null;
        $newValues = $event === 'updated' ? $model->getChanges() : $model->getAttributes();

        // Création de l'entrée dans la table activity_logs
        ActivityLog::create([
            'user_id'       => Auth::id(), // ID de l'utilisateur connecté (null si invité)
            'loggable_id'   => $model->getKey(),
            'loggable_type' => get_class($model),
            'event'         => $event,
            'old_values'    => $oldValues,
            'new_values'    => $newValues,
            'ip_address'    => Request::ip(),
            'user_agent'    => Request::userAgent(),
        ]);
    }
}