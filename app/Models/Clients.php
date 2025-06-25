<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Clients extends Model
{
    use LogsActivity;
    use HasFactory;

    protected $fillable = [
        'client_name',
        'client_code',
        'client_document',
        'client_type',
        'client_phone1',

        // Not required data
        'client_phone2',
        'client_birthdate',
        'client_phone_home',
        'client_actual_job',
        'client_job_length',
        'client_phone_work',
        'client_last_job',
        'client_own_business',
        'client_email',
        'client_exonerated',
        'client_status',
        'client_address',
    ];

    // Relationships
    public function loans()
    {
        return $this->hasMany(Loans::class, 'client_id');
    }

    public function pos()
    {
        return $this->hasMany(Pos::class, 'client_id');
    }

    // Configuración específica para el logging
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'client_name',
                'client_code',
                'client_document',
                'client_type',
                'client_phone1',
                'client_phone2',
                'client_birthdate',
                'client_phone_home',
                'client_actual_job',
                'client_job_length',
                'client_phone_work',
                'client_last_job',
                'client_own_business',
                'client_email',
                'client_exonerated',
                'client_status',
                'client_address',
            ])
            ->logOnlyDirty() // Solo registrar campos que cambiaron
            ->setDescriptionForEvent(fn(string $eventName) => "Cliente {$eventName}")
            ->useLogName('clients')
            ->dontSubmitEmptyLogs();
    }

    // Registrar quién hizo el cambio
    public function tapActivity(Activity $activity, string $eventName)
    {
        $user = Auth::user()->id;
        $activity->causer_id = $user ?? null;
    }
}
