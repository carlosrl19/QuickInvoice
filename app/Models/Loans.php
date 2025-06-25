<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Loans extends Model
{
    use LogsActivity;
    
    protected $fillable = [
        'client_id',
        'seller_id',
        'loan_code_number',
        'loan_request_number',
        'loan_payment_type',
        'loan_amount',
        'loan_down_payment',
        'loan_amount_weekly_arrears',
        'loan_quote_value',
        'loan_interest',
        'loan_total',
        'loan_start_date',
        'loan_end_date',
        'loan_quote_number',
        'loan_status',
        'loan_request_status',
        'loan_description',
        'created_at',
        'updated_at',
    ];

    // Relationships
    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function loan_payment()
    {
        return $this->hasMany(LoanPayments::class, 'loan_id', 'id');
    }

    // Configuración específica para el logging
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'client_id',
                'seller_id',
                'loan_code_number',
                'loan_request_number',
                'loan_payment_type',
                'loan_amount',
                'loan_down_payment',
                'loan_amount_weekly_arrears',
                'loan_quote_value',
                'loan_interest',
                'loan_total',
                'loan_start_date',
                'loan_end_date',
                'loan_quote_number',
                'loan_status',
                'loan_request_status',
                'loan_description',
            ])
            ->logOnlyDirty() // Solo registrar campos que cambiaron
            ->setDescriptionForEvent(fn(string $eventName) => "Préstamo {$eventName}")
            ->useLogName('loans')
            ->dontSubmitEmptyLogs();
    }

    // Registrar quién hizo el cambio
    public function tapActivity(Activity $activity, string $eventName)
    {
        $user = Auth::user()->id;
        $activity->causer_id = $user ?? null;
    }
}
