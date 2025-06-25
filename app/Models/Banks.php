<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Banks extends Model
{
    use LogsActivity;

    protected $fillable = [
        "account_name",
        "bank_name",
        "bank_account_number",
        "created_at",
        "updated_at"
    ];

    // Relationships
    public function sale()
    {
        return $this->belongsTo(Pos::class, 'bank_id');
    }

    public function loan_payment()
    {
        return $this->belongsTo(LoanPayments::class, 'bank_id');
    }

    // Configuración específica para el logging
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['account_name', 'bank_name', 'bank_account_number'])
            ->logOnlyDirty() // Solo registrar campos que cambiaron
            ->setDescriptionForEvent(fn(string $eventName) => "Banco {$eventName}")
            ->useLogName('banks')
            ->dontSubmitEmptyLogs();
    }

    // Registrar quién hizo el cambio
    public function tapActivity(Activity $activity, string $eventName)
    {
        $user = Auth::user()->id;
        $activity->causer_id = $user ?? null;
    }
}
