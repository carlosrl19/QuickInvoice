<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Quotes extends Model
{
    use LogsActivity;

    protected $fillable = [
        'quote_code',
        'client_id',
        'seller_id',
        'quote_type',
        'quote_total_amount',
        'quote_discount',
        'quote_exempt_tax',
        'quote_tax',
        'quote_isv_amount',
        'quote_expiration_date',
        'quote_answer',
        'quote_status',
    ];

    // Relationships
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }

    // Configuración específica para el logging
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'quote_code',
                'client_id',
                'seller_id',
                'quote_type',
                'quote_total_amount',
                'quote_discount',
                'quote_exempt_tax',
                'quote_tax',
                'quote_isv_amount',
                'quote_expiration_date',
                'quote_answer',
                'quote_status',
            ])
            ->logOnlyDirty() // Solo registrar campos que cambiaron
            ->setDescriptionForEvent(fn(string $eventName) => "Cotización {$eventName}")
            ->useLogName('quotes')
            ->dontSubmitEmptyLogs();
    }

    // Registrar quién hizo el cambio
    public function tapActivity(Activity $activity, string $eventName)
    {
        $user = Auth::user()->id;
        $activity->causer_id = $user ?? null;
    }
}
