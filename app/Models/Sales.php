<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sales extends Model
{
    protected $fillable = [
        'sale_doc_number',
        'sale_total_amount',
        'sale_discount',
        'sale_description',
        'user_id',
        'created_at',
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function sale_details(): HasMany
    {
        return $this->HasMany(SaleDetails::class, 'sale_id', 'id');
    }
}
