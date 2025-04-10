<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banks extends Model
{
    protected $fillable = [
        "account_name",
        "bank_name",
        "bank_account_number",
        "created_at",
        "updated_at"
    ];

    // Relationships
    public function sale()
    {
        return $this->belongsTo(Pos::class, 'bank_id');
    }

    public function loan_payment()
    {
        return $this->belongsTo(LoanPayments::class, 'bank_id');
    }
}
