<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FiscalFolio extends Model
{
    protected $fillable = [
        'folio_authorized_range_start',
        'folio_authorized_range_end',
        'folio_total_invoices',
        'folio_total_invoices_available',
        'folio_authorized_emission_date',
        'folio_validation_status',
        'folio_status',
    ];

    // Relationships
    public function pos()
    {
        return $this->hasMany(Pos::class, 'folio_id');
    }
}
