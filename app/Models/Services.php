<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Services extends Model
{
    use LogsActivity;

    protected $fillable = [
        'service_name',
        'service_nomenclature',
        'service_type',
        'service_description',
        'created_at',
        'updated_at'
    ];

    public function pos_details()
    {
        return $this->hasMany(PosDetails::class, 'service_id');
    }

    public function quote_details()
    {
        return $this->hasMany(QuoteDetails::class, 'service_id');
    }

    // Configuración específica para el logging
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'service_name',
                'service_nomenclature',
                'service_type',
                'service_description',
            ])
            ->logOnlyDirty() // Solo registrar campos que cambiaron
            ->setDescriptionForEvent(fn(string $eventName) => "Servicio {$eventName}")
            ->useLogName('services')
            ->dontSubmitEmptyLogs();
    }

    // Registrar quién hizo el cambio
    public function tapActivity(Activity $activity, string $eventName)
    {
        $user = Auth::user()->id;
        $activity->causer_id = $user ?? null;
    }
}
