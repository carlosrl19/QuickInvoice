<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteDetails extends Model
{
    
    protected $fillable = [
        'quote_id',
        'service_id',
        'quote_subtotal',
        'quote_quantity',
        'quote_price',
        'quote_details',
    ];

    // Relationships
    public function quote()
    {
        return $this->belongsTo(Quotes::class, 'quote_id');
    }

    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }
}
