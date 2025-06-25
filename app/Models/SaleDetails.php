<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleDetails extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'product_quantity',
        'sale_subtotal',
        'created_at',
        'updated_at',
    ];

    // Relationships
    public function sale(): BelongsTo
    {
        return $this->BelongsTo(Sales::class, 'sale_id', 'id');
    }

    public function products(): BelongsTo
    {
        return $this->BelongsTo(Products::class, 'product_id', 'id');
    }
}
