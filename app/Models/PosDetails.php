<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosDetails extends Model
{
    protected $fillable = [
        'sale_id',
        'service_id',
        'sale_subtotal',
        'sale_quantity',
        'sale_price',
        'sale_details',
    ];

    // Relationships
    public function sale()
    {
        return $this->belongsTo(Pos::class, 'sale_id');
    }

    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }
}
