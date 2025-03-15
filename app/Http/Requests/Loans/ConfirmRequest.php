<?php

namespace App\Http\Requests\Loans;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'loan_request_status' => 'required|in:1',
        ];
    }

    public function messages()
    {
        return [
            // Loan request status messages
            'loan_request_status.required' => 'El estado de la solicitud del préstamo es obligatorio.',
            'loan_request_status.in' => 'El estado de la solicitud del préstamo debe ser 1 (dev.request).',
        ];
    }
}
