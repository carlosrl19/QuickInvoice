<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsignmentDetails extends Model
{
    protected $fillable = [
        'consignment_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price'
    ];

    public function consignment()
    {
        return $this->belongsTo(Consignment::class);
    }

    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
