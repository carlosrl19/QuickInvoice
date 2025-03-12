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
            'loan_payment_amount' => 'required|numeric|min:1',
            'loan_old_debt' => 'required|numeric|min:1',
            'loan_new_debt' => 'required|numeric|min:0',
            'loan_payment_date' => 'required|date:Y-m-d H:i:s',
            'loan_payment_img' => 'nullable',
            'loan_payment_img.*' => 'image',
            'loan_payment_comment' => 'nullable|string|min:3|max:255',
            'loan_payment_type' => 'required|numeric|in:0',
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
            'loan_payment_amount.required' => 'El valor del pago de cuota es obligatorio.',
            'loan_payment_amount.numeric' => 'El valor del pago de cuota solo debe contener números.',
            'loan_payment_amount.min' => 'El valor del pago de cuota debe ser mayor a L. 0.',

            // Loan old debt messages
            'loan_old_debt.required' => 'El antiguo valor de deuda del préstamo es obligatorio.',
            'loan_old_debt.numeric' => 'El antiguo valor de deuda del préstamo solo debe contener números.',
            'loan_old_debt.regex' => 'El antiguo valor de deuda del préstamo no puede contener letras ni símbolos.',
            'loan_old_debt.min' => 'El antiguo valor de deuda del préstamo debe ser mayor a L. 0.',

            // Loan new debt messages
            'loan_new_debt.required' => 'El nuevo valor de deuda del préstamo es obligatorio.',
            'loan_new_debt.numeric' => 'El nuevo valor de deuda del préstamo solo debe contener números.',
            'loan_new_debt.regex' => 'El nuevo valor de deuda del préstamo no puede contener letras ni símbolos.',
            'loan_new_debt.min' => 'El nuevo valor de deuda del préstamo debe ser mayor a L. 0.',

            // Loan payment date messages
            'loan_payment_date.required' => 'La fecha del pago es obligatoria.',
            'loan_payment_date.date' => 'El formato de fecha del pago debe ser Y-m-d H:i:s.',

            // Loan payment img
            'loan_payment_img.*' => 'El comprobante de pago debe ser una imagen válida (jpeg, png, jpg, webp).',

            // Loan payment comment messages
            'loan_payment_comment.string' => 'Los comentarios del pago de cuota solo deben contener letras, números y/o símbolos.',
            'loan_payment_comment.min' => 'Los comentarios del pago de cuota deben tener al menos 3 caracteres.',
            'loan_payment_comment.max' => 'Los comentarios del pago de cuota no pueden tener más de 255 caracteres.',

            // Loan payment type messages
            'loan_payment_type.required' => 'El tipo de pago realizado es obligatorio.',
            'loan_payment_type.numeric' => 'El tipo de pago realizado solo debe contener números.',
            'loan_payment_type.in' => 'El tipo de pago realizado solo puede ser: Pago de cuota normal.',
        ];
    }
}
