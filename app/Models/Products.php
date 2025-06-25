<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Products extends Model
{
    protected $fillable = [
        'product_code',
        'product_nomenclature',
        'product_name',
        'product_brand',
        'product_model',
        'product_status',
        'category_id',
        'product_stock',
        'product_price',
        'product_description',
        'product_status_description',
        'product_image',
        'product_reviewed_by',
        'created_at',
        'updated_at'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }

    public function sale_detail(): HasMany
    {
        return $this->HasMany(SaleDetails::class, 'product_id', 'id');
    }

    public function consignment_details(): HasMany
    {
        return $this->hasMany(ConsignmentDetails::class, 'product_id');
    }
}
