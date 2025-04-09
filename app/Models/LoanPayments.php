<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanPayments extends Model
{
    protected $fillable = [
        'loan_id',
        'bank_id',
        'loan_quote_payment_doc_number',
        'loan_quote_payment_amount',
        'loan_old_debt',
        'loan_new_debt',
        'loan_quote_arrears',
        'loan_quote_payment_date',
        'loan_quote_payment_comment',
        'loan_quote_payment_status',
        'loan_quote_payment_mode',
        'loan_card_last_digits',
        'loan_card_auth_number',
        'loan_quote_payment_received',
        'loan_quote_payment_change',
        'loan_bank_operation_number',
        'loan_bankcheck_info',
        'created_at',
        'updated_at',
    ];

    // Relationships
    public function loan()
    {
        return $this->belongsTo(Loans::class, 'loan_id', 'id');
    }

    public function bank()
    {
        return $this->belongsTo(Banks::class, 'bank_id');
    }
}
