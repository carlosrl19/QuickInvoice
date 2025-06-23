<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkFormat extends Model
{
    protected $fillable = [
        'workformat_date',
        'client_name',
        'client_phone',
        'client_address',
        'worker_name',
        'receipt_number',
        'workformat_type',
        'workformat_description',
        'client_signature',
        'created_at',
        'updated_at',
    ];
}
