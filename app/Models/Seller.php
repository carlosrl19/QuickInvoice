<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Seller extends Model
{
    use LogsActivity;
    use HasFactory;

    protected $fillable = [
        'seller_name',
        'seller_document',
        'seller_phone',
    ];

    // Relationships
    public function pos()
    {
        return $this->hasMany(Pos::class, 'seller_id');
    }

    public function loan()
    {
        return $this->hasMany(Loans::class, 'seller_id');
    }

    public function setting()
    {
        return $this->belongsTo(Loans::class, 'default_seller_id');
    }

    // Configuración específica para el logging
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'seller_name',
                'seller_document',
                'seller_phone',
            ])
            ->logOnlyDirty() // Solo registrar campos que cambiaron
            ->setDescriptionForEvent(fn(string $eventName) => "Vendedor {$eventName}")
            ->useLogName('seller')
            ->dontSubmitEmptyLogs();
    }

    // Registrar quién hizo el cambio
    public function tapActivity(Activity $activity, string $eventName)
    {
        $user = Auth::user()->id ?? 1;
        $activity->causer_id = $user ?? null;
    }
}
