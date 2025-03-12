<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $fillable = [
        'client_name',
        'client_document',
        'client_type',
        'client_phone1',
        'client_phone2',
        'client_address',
    ];

    // Relationships
    public function loans()
    {
        return $this->hasMany(Loans::class, 'moneylender_id')
            ->onDelete('cascade');
    }
}
