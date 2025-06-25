<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class FiscalFolio extends Model
{
    use LogsActivity;
    use HasFactory;

    protected $fillable = [
        'folio_authorized_range_start',
        'folio_authorized_range_end',
        'folio_total_invoices',
        'folio_total_invoices_available',
        'folio_authorized_emission_date',
        'folio_validation_status',
        'folio_status',
    ];

    // Relationships
    public function pos()
    {
        return $this->hasMany(Pos::class, 'folio_id');
    }

    // Configuración específica para el logging
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'folio_authorized_range_start',
                'folio_authorized_range_end',
                'folio_total_invoices',
                'folio_total_invoices_available',
                'folio_authorized_emission_date',
                'folio_validation_status',
                'folio_status',
            ])
            ->logOnlyDirty() // Solo registrar campos que cambiaron
            ->setDescriptionForEvent(fn(string $eventName) => "Folio fiscal {$eventName}")
            ->useLogName('fiscal_folio')
            ->dontSubmitEmptyLogs();
    }

    // Registrar quién hizo el cambio
    public function tapActivity(Activity $activity, string $eventName)
    {
        $user = Auth::user()->id ?? 1;
        $activity->causer_id = $user ?? null;
    }
}
