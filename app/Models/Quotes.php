<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotes extends Model
{
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
}
