<?php

namespace App\Http\Requests\LoanPayments;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'loan_id' => 'required|numeric|exists:loans,id',
            'loan_quote_payment_amount' => 'required|numeric|min:1',
            'loan_old_debt' => 'required|numeric|min:1',
            'loan_new_debt' => 'required|numeric|min:0',
            'loan_quote_arrears' => 'required|numeric|min:0',
            'loan_quote_payment_date' => 'required|date:Y-m-d H:i:s',
            'loan_quote_payment_comment' => 'nullable|string|min:3|max:255',
            'loan_quote_payment_status' => 'required|numeric|in:0,1,2', // 0: Pendiente, 1: Pagado, 2: Atrasado
            'loan_quote_payment_mode' => 'required|numeric|in:1,2,3,4', // 1: Efectivo, 2: Cheque, 3: Depósito, 4: Dólar, 5: Tarjeta
            'loan_quote_payment_received' => 'required|numeric|min:1',
            'loan_quote_payment_change' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            // Loan id messages
            'loan_id.required' => 'El préstamo es obligatorio.',
            'loan_id.numeric' => 'El id del préstamo solo debe contener números.',
            'loan_id.exists' => 'El préstamo no existe en la base de datos.',

            // Loan payment amount messages
            'loan_quote_payment_amount.required' => 'El valor del pago de cuota es obligatorio.',
            'loan_quote_payment_amount.numeric' => 'El valor del pago de cuota solo debe contener números.',
            'loan_quote_payment_amount.min' => 'El valor del pago de cuota debe ser como mínimo L. 0.',

            // Loan old debt messages
            'loan_old_debt.required' => 'El antiguo valor de deuda del préstamo es obligatorio.',
            'loan_old_debt.numeric' => 'El antiguo valor de deuda del préstamo solo debe contener números.',
            'loan_old_debt.min' => 'El antiguo valor de deuda del préstamo debe ser como mínimo L. 0.',

            // Loan new debt messages
            'loan_new_debt.required' => 'El nuevo valor de deuda del préstamo es obligatorio.',
            'loan_new_debt.numeric' => 'El nuevo valor de deuda del préstamo solo debe contener números.',
            'loan_new_debt.min' => 'El nuevo valor de deuda del préstamo debe ser como mínimo L. 0.',

            // Loan quote arrears messages
            'loan_quote_arrears.required' => 'La mora del préstamo es obligatorio.',
            'loan_quote_arrears.numeric' => 'La mora del préstamo solo debe contener números.',
            'loan_quote_arrears.min' => 'La mora del préstamo debe ser como mínimo L. 0.',

            // Loan payment date messages
            'loan_quote_payment_date.required' => 'La fecha del pago es obligatoria.',
            'loan_quote_payment_date.date' => 'El formato de fecha del pago debe ser Y-m-d H:i:s.',

            // Loan payment comment messages
            'loan_quote_payment_comment.string' => 'Los comentarios del pago de cuota solo deben contener letras, números y/o símbolos.',
            'loan_quote_payment_comment.min' => 'Los comentarios del pago de cuota deben tener al menos 3 caracteres.',
            'loan_quote_payment_comment.max' => 'Los comentarios del pago de cuota no pueden tener más de 255 caracteres.',

            // Loan payment status messages
            'loan_quote_payment_status.required' => 'El estado del pago es obligatorio.',
            'loan_quote_payment_status.numeric' => 'El estado del pago solo debe contener números.',
            'loan_quote_payment_status.in' => 'El estado del pago solo puede ser: 0: Pendiente, 1: Pagado.',

            // Loan quote payment mode messages
            'loan_quote_payment_mode.required' => 'El método de pago utilizado es obligatorio.',
            'loan_quote_payment_mode.numeric' => 'El método de pago utilizado solo debe contener números.',
            'loan_quote_payment_mode.in' => 'El método de pago utilizado solo puede ser Efectivo, 2: Cheque, 3: Depósito, 4: Dólar, 5: Tarjeta (dev.request).',

            // Loan quote payment received messages
            'loan_quote_payment_received.required' => 'El total de dinero recibido como pago es obligatorio.',
            'loan_quote_payment_received.numeric' => 'El total de dinero recibido como pago solo debe contener números.',
            'loan_quote_payment_received.min' => 'El total de dinero recibido como pago debe ser mayor o igual a L. 1.',

            // Loan quote payment change messagesjwda
            'loan_quote_payment_change.required' => 'El total de cambio es obligatorio.',
            'loan_quote_payment_change.numeric' => 'El total de cambio solo debe contener números.',
            'loan_quote_payment_change.min' => 'El total de cambio debe ser mayor o igual a L. 0.',
        ];
    }
}
