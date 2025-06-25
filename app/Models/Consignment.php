<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consignment extends Model
{
    protected $fillable = [
        'user_id',
        'product_quantity',
        'person_name',
        'person_dni',
        'person_phone',
        'person_address',
        'consignment_code',
        'consignment_date',
        'consignment_amount',
        'consignment_status',
        'created_at',
        'updated_at',
    ];

    // Relationships
    public function consigment_details()
    {
        return $this->hasMany(ConsignmentDetails::class);
    }
}
