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
            'loan_quote_payment_amount' => 'required|numeric|min:1',
            'loan_old_debt' => 'required|numeric|min:1',
            'loan_new_debt' => 'required|numeric|min:0',
            'loan_quote_arrears' => 'required|numeric|min:0',
            'loan_quote_payment_date' => 'required|date:Y-m-d H:i:s',
            'loan_quote_payment_comment' => 'nullable|string|min:3|max:255',
            'loan_quote_payment_status' => 'required|numeric|in:0,1,2', // 0: Pendiente, 1: Pagado, 2: Atrasado
            'loan_quote_payment_mode' => 'required|numeric|in:1,2,3,4,5', // 1: Efectivo, 2: Cheque, 3: Depósito, 4: Dólar, 5: Tarjeta
            'card_auth_number' => 'nullable|string|min:4|max:4|regex:/^[0-9]+$/', // Solo si se usa Tarjeta como loan_quote_payment_mode
            'card_last_digits' => 'nullable|string|min:6|max:12|regex:/^[A-Z0-9]+$/', // Solo si se usa Tarjeta como loan_quote_payment_mode
            'loan_quote_payment_received' => 'required|numeric|min:1',
            'loan_quote_payment_change' => 'required|numeric|min:0',
        ];
    }

    /**
     * Agregar una validación adicional después de las reglas estándar para validar que se ingresen los datos dependiendo el modo de pago
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $payment_mode = $this->input('loan_quote_payment_mode');
            $card_last_digits = $this->input('card_last_digits');
            $card_auth_number = $this->input('card_auth_number');

            if ($payment_mode == 5 && $card_last_digits == '' || !$card_auth_number == '') {
                $validator->errors()->add('card_last_digits', 'Los 4 digitos de la tarjeta son obligatorios.');
                $validator->errors()->add('card_auth_number', 'El nº de autorización es obligatorio.');
            }
        });
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

            // Card auth number messages
            'card_auth_number.string' => 'Los últimos 4 digitos de la tarjeta deben contener solo números.',
            'card_auth_number.min' => 'Los últimos 4 digitos de la tarjeta deben contener al menos :min números.',
            'card_auth_number.max' => 'Los últimos 4 digitos de la tarjeta no puede contener más de :max números.',

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
