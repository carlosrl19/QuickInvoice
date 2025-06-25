<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class LoanPayments extends Model
{
    use LogsActivity;

    protected $fillable = [
        'loan_id',
        'bank_id',
        'loan_quote_payment_doc_number',
        'loan_quote_payment_amount',
        'loan_old_debt',
        'loan_new_debt',
        'loan_quote_arrears',
        'loan_quote_payment_date',
        'loan_quote_payment_comment',
        'loan_quote_payment_status',
        'loan_quote_payment_mode',
        'loan_card_last_digits',
        'loan_card_auth_number',
        'loan_quote_payment_received',
        'loan_quote_payment_change',
        'loan_bank_operation_number',
        'loan_bankcheck_info',
        'created_at',
        'updated_at',
    ];

    // Relationships
    public function loan()
    {
        return $this->belongsTo(Loans::class, 'loan_id', 'id');
    }

    public function bank()
    {
        return $this->belongsTo(Banks::class, 'bank_id');
    }

    // Configuración específica para el logging
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'loan_id',
                'bank_id',
                'loan_quote_payment_doc_number',
                'loan_quote_payment_amount',
                'loan_old_debt',
                'loan_new_debt',
                'loan_quote_arrears',
                'loan_quote_payment_date',
                'loan_quote_payment_comment',
                'loan_quote_payment_status',
                'loan_quote_payment_mode',
                'loan_card_last_digits',
                'loan_card_auth_number',
                'loan_quote_payment_received',
                'loan_quote_payment_change',
                'loan_bank_operation_number',
                'loan_bankcheck_info',
            ])
            ->logOnlyDirty() // Solo registrar campos que cambiaron
            ->setDescriptionForEvent(fn(string $eventName) => "Pago a préstamo {$eventName}")
            ->useLogName('loan_payments')
            ->dontSubmitEmptyLogs();
    }

    // Registrar quién hizo el cambio
    public function tapActivity(Activity $activity, string $eventName)
    {
        $user = Auth::user()->id;
        $activity->causer_id = $user ?? null;
    }
}
