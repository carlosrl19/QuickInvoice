<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pos extends Model
{
    protected $fillable = [
        'client_id',
        'seller_id',
        'folio_id',
        'bank_id',
        'sale_type',
        'exempt_purchase_order_correlative',
        'exonerated_certificate',
        'folio_invoice_number',
        'sale_total_amount',
        'sale_discount',
        'sale_exempt_tax',
        'sale_tax',
        'sale_isv_amount',
        'sale_payment_received',
        'sale_payment_change',
        'sale_payment_type',
        'sale_card_last_digits',
        'sale_card_auth_number',
        'sale_bank_operation_number',
        'sale_bankcheck_info',
        'created_at',
        'updated_at',
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

    public function folio()
    {
        return $this->belongsTo(FiscalFolio::class, 'folio_id');
    }

    public function pos_details()
    {
        return $this->hasMany(PosDetails::class, 'sale_id');
    }

    public function bank()
    {
        return $this->belongsTo(Banks::class, 'bank_id');
    }
}
