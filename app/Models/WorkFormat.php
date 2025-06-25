<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class WorkFormat extends Model
{
    use LogsActivity;

    protected $fillable = [
        'workformat_date',
        'client_name',
        'client_phone',
        'client_address',
        'worker_name',
        'receipt_number',
        'workformat_type',
        'workformat_description',
        'client_signature',
        'created_at',
        'updated_at',
    ];

    // Configuración específica para el logging
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'workformat_date',
                'client_name',
                'client_phone',
                'client_address',
                'worker_name',
                'receipt_number',
                'workformat_type',
                'workformat_description',
                'client_signature',
            ])
            ->logOnlyDirty() // Solo registrar campos que cambiaron
            ->setDescriptionForEvent(fn(string $eventName) => "Formato de trabajo {$eventName}")
            ->useLogName('workformats')
            ->dontSubmitEmptyLogs();
    }

    // Registrar quién hizo el cambio
    public function tapActivity(Activity $activity, string $eventName)
    {
        $user = Auth::user()->id;
        $activity->causer_id = $user ?? null;
    }
}
