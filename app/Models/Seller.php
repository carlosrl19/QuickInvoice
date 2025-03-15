<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $fillable = [
        'seller_name',
        'seller_document',
        'seller_phone',
    ];

    // Relationships
    public function pos()
    {
        return $this->hasMany(Pos::class, 'seller_id')
            ->onDelete('cascade');
    }
}
