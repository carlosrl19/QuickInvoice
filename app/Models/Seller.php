<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'seller_name',
        'seller_document',
        'seller_phone',
    ];

    // Relationships
    public function pos()
    {
        return $this->hasMany(Pos::class, 'seller_id');
    }

    public function loan()
    {
        return $this->hasMany(Loans::class, 'seller_id');
    }

    public function setting()
    {
        return $this->belongsTo(Loans::class, 'default_seller_id');
    }
}
