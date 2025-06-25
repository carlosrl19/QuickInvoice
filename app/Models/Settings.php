<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Settings extends Model
{
    use LogsActivity;
    use HasFactory;

    protected $fillable = [
        'logo_company',
        'system_icon',
        'show_system_name',
        'company_name',
        'company_cai',
        'company_rtn',
        'company_phone',
        'company_email',
        'company_address',
        'company_short_address',
        'default_currency_symbol',
        'default_seller_id',
    ];

    // Relationships
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'default_seller_id');
    }

    // Configuración específica para el logging
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'logo_company',
                'system_icon',
                'show_system_name',
                'company_name',
                'company_cai',
                'company_rtn',
                'company_phone',
                'company_email',
                'company_address',
                'company_short_address',
                'default_currency_symbol',
                'default_seller_id',
            ])
            ->logOnlyDirty() // Solo registrar campos que cambiaron
            ->setDescriptionForEvent(fn(string $eventName) => "Configuración del sistema {$eventName}")
            ->useLogName('settings')
            ->dontSubmitEmptyLogs();
    }

    // Registrar quién hizo el cambio
    public function tapActivity(Activity $activity, string $eventName)
    {
        $user = Auth::user()->id ?? 1;
        $activity->causer_id = $user ?? null;
    }
}
