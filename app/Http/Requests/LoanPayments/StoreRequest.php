<?php

namespace App\Http\Requests\LoanPayments;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'loan_id' => 'required|numeric|exists:loans,id',
            'bank_id' => 'nullable|required_if:loan_quote_payment_mode,3|integer|exists:banks,id',
            'loan_quote_payment_amount' => 'required|numeric|min:1',
            'loan_old_debt' => 'required|numeric|min:1',
            'loan_new_debt' => 'required|numeric|min:0',
            'loan_quote_arrears' => 'required|numeric|min:0',
            'loan_quote_payment_date' => 'required|date:Y-m-d H:i:s',
            'loan_quote_payment_comment' => 'nullable|string|min:3|max:255',
            'loan_quote_payment_status' => 'required|numeric|in:0,1,2', // 0: Pendiente, 1: Pagado, 2: Atrasado
            'loan_quote_payment_mode' => 'required|numeric|in:1,2,3,4,5', // 1: Efectivo, 2: Cheque, 3: Depósito, 4: Dólar, 5: Tarjeta
            'loan_card_last_digits' => 'nullable|required_if:loan_quote_payment_mode,5|string|min:4|max:4|regex:/^[0-9]+$/', // Solo si se usa Tarjeta como loan_quote_payment_mode
            'loan_card_auth_number' => 'nullable|required_if:loan_quote_payment_mode,5|string|min:6|max:12|regex:/^[A-Z0-9]+$/', // Solo si se usa Tarjeta como loan_quote_payment_mode
            'loan_bank_operation_number' => 'nullable|required_if:loan_quote_payment_mode,3|string|min:6|max:12|regex:/^[A-Z0-9]+$/', // Solo si se usa Deposito como loan_quote_payment_mode
            'loan_bankcheck_info' => 'nullable|required_if:loan_quote_payment_mode,2|string|min:10|max:40|regex:/^[A-Z0-9\/]+$/', // Solo si se usa Cheque como loan_quote_payment_mode'
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

            // Bank_id messages
            'bank_id.required_if' => 'El banco es obligatorio.',
            'bank_id.integer' => 'El banco debe ser un número entero (dev.request).',
            'bank_id.exists' => 'El banco seleccionado no existe.',

            // Loan payment amount messages
            'loan_quote_payment_amount.required' => 'El valor del pago de cuota es obligatorio.',
            'loan_quote_payment_amount.numeric' => 'El valor del pago de cuota solo debe contener números.',
            'loan_quote_payment_amount.min' => 'El valor del pago de cuota debe ser al menos L. :min.',

            // Loan old debt messages
            'loan_old_debt.required' => 'El antiguo valor de deuda del préstamo es obligatorio.',
            'loan_old_debt.numeric' => 'El antiguo valor de deuda del préstamo solo debe contener números.',
            'loan_old_debt.min' => 'El antiguo valor de deuda del préstamo debe ser al menos L. :min.',

            // Loan new debt messages
            'loan_new_debt.required' => 'El nuevo valor de deuda del préstamo es obligatorio.',
            'loan_new_debt.numeric' => 'El nuevo valor de deuda del préstamo solo debe contener números.',
            'loan_new_debt.min' => 'El nuevo valor de deuda del préstamo debe ser al menos L. :min.',

            // Loan quote arrears messages
            'loan_quote_arrears.required' => 'La mora del préstamo es obligatorio.',
            'loan_quote_arrears.numeric' => 'La mora del préstamo solo debe contener números.',
            'loan_quote_arrears.min' => 'La mora del préstamo debe ser al menos L. :min.',

            // Loan payment date messages
            'loan_quote_payment_date.required' => 'La fecha del pago es obligatoria.',
            'loan_quote_payment_date.date' => 'El formato de fecha del pago debe ser Y-m-d H:i:s.',

            // Loan payment comment messages
            'loan_quote_payment_comment.string' => 'Los comentarios del pago de cuota solo deben contener letras, números y/o símbolos.',
            'loan_quote_payment_comment.min' => 'Los comentarios del pago de cuota deben tener al menos :min caracteres.',
            'loan_quote_payment_comment.max' => 'Los comentarios del pago de cuota no pueden tener más de :max caracteres.',

            // Loan payment status messages
            'loan_quote_payment_status.required' => 'El estado del pago es obligatorio.',
            'loan_quote_payment_status.numeric' => 'El estado del pago solo debe contener números.',
            'loan_quote_payment_status.in' => 'El estado del pago solo puede ser: 0: Pendiente, 1: Pagado.',

            // Loan quote payment mode messages
            'loan_quote_payment_mode.required' => 'El método de pago utilizado es obligatorio.',
            'loan_quote_payment_mode.numeric' => 'El método de pago utilizado solo debe contener números.',
            'loan_quote_payment_mode.in' => 'El método de pago utilizado solo puede ser Efectivo, 2: Cheque, 3: Depósito, 4: Dólar, 5: Tarjeta (dev.request).',

            // Card last digits messages
            'loan_card_last_digits.required_if' => 'Los últimos 4 son obligatorios.',
            'loan_card_last_digits.string' => 'Los últimos 4 digitos de la tarjeta deben contener solo números.',
            'loan_card_last_digits.min' => 'Los últimos 4 digitos de la tarjeta deben contener al menos :min números.',
            'loan_card_last_digits.max' => 'Los últimos 4 digitos de la tarjeta no puede contener más de :max números.',

            // Card auth number messages
            'loan_card_auth_number.required_if' => 'La autorización es obligatoria.',
            'loan_card_auth_number.string' => 'La autorización debe contener solo letras y números.',
            'loan_card_auth_number.min' => 'La autorización debe contener al menos :min números.',
            'loan_card_auth_number.max' => 'La autorización no puede contener más de :max números.',

            // Loan bank operation number messages
            'loan_bank_operation_number.required_if' => 'El Nº de operación es obligatorio.',
            'loan_bank_operation_number.string' => 'El Nº de operación debe contener solo letras y caracteres.',
            'loan_bank_operation_number.regex' => 'El Nº de operación no debe contener símbolos.',
            'loan_bank_operation_number.min' => 'El Nº de operación debe contener al menos :min caracteres.',
            'loan_bank_operation_number.max' => 'El Nº de operación no puede contener más de :max caracteres.',

            // Loan bankcheck info messages
            'loan_bankcheck_info.required_if' => 'El Banco / Nº cuenta es obligatorio.',
            'loan_bankcheck_info.string' => 'El Banco / Nº cuenta debe contener solo letras, números y signo /.',
            'loan_bankcheck_info.regex' => 'El Banco / Nº cuenta no debe contener símbolos distintos a /.',
            'loan_bankcheck_info.min' => 'El Banco / Nº cuenta debe contener al menos :min caracteres.',
            'loan_bankcheck_info.max' => 'El Banco / Nº cuenta no puede contener más de :max caracteres.',

            // Loan quote payment received messages
            'loan_quote_payment_received.required' => 'El total pago es obligatorio.',
            'loan_quote_payment_received.numeric' => 'El total pago solo debe contener números.',
            'loan_quote_payment_received.min' => 'El total pago debe ser mayor o igual a L. :min.',

            // Loan quote payment change messagesjwda
            'loan_quote_payment_change.required' => 'El total de cambio es obligatorio.',
            'loan_quote_payment_change.numeric' => 'El total de cambio solo debe contener números.',
            'loan_quote_payment_change.min' => 'El total de cambio debe ser mayor o igual a L. :min.',
        ];
    }
}
