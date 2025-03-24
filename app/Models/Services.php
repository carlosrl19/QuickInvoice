<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $fillable = [
        'service_name',
        'service_nomenclature',
        'service_description',
        'created_at',
        'updated_at'
    ];

    public function pos_details()
    {
        return $this->hasMany(PosDetails::class, 'service_id');
    }
}
