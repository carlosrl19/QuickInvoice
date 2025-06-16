<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'category_id',
        'product_barcode',
        'product_name',
        'product_description',
        'product_stock',
        'product_buy_price',
        'product_sell_price',
        'product_image',
        'created_at',
        'updated_at',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
