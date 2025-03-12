<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanPayments extends Model
{
    protected $fillable = [
        'loan_id',
        'loan_payment_doc_number',
        'loan_payment_amount',
        'loan_old_debt',
        'loan_new_debt',
        'loan_payment_date',
        'loan_payment_comment',
        'loan_payment_img',
        'loan_payment_type'
    ];

    // Relationships
    public function loan()
    {
        return $this->belongsTo(Loans::class, 'loan_id', 'id');
    }
}
