<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
