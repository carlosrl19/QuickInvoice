<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pos extends Model
{
    protected $fillable = [
        'client_id',
        'seller_id',
        'sale_total_amount',
        'sale_discount',
        'sale_tax',
        'sale_isv_amount',
        'sale_payment_received',
        'sale_payment_change',
        'sale_payment_type'
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

    public function pos_details()
    {
        return $this->hasMany(PosDetails::class, 'sale_id');
    }
}
