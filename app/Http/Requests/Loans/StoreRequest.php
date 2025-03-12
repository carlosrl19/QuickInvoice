<?php

namespace App\Http\Requests\Loans;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => 'required|numeric|exists:clients,id',
            'loan_code' => 'required|string|min:10|max:10|regex:/^[a-zA-Z0-9]+$/|unique:loans,loan_code',
            'loan_payment_type' => 'required|min:1|max:4',
            'loan_amount' => 'required|numeric|min:1|regex:/^\d+(\.\d{1,2})?$/',
            'loan_quote_value' => 'required|numeric|min:1|regex:/^\d+(\.\d{1,2})?$/',
            'loan_tax' => 'required|numeric|min:0|max:100',
            'loan_total' => 'required|numeric|min:1|regex:/^\d+(\.\d{1,2})?$/',
            'loan_start_date' => 'required|date:Y-m-d H:i:s',
            'loan_end_date' => 'required|date:Y-m-d H:i:s|after:loan_start_date',
            'loan_quote_number' => 'required|numeric|min:1',
            'loan_status' => 'required|in:1',
            'loan_description' => 'required|string|min:3|max:255',
        ];
    }

    public function messages()
    {
        return [
            // Client id messages
            'client_id.required' => 'El cliente es obligatorio.',
            'client_id.numeric' => 'El id del cliente solo debe contener números (dev.request).',
            'client_id.exists' => 'El cliente seleccionado no existe en la base de datos.',
            
            // Loan code messages
            'loan_code.required' => 'El código del préstamo es obligatorio.',
            'loan_code.unique' => 'El código del préstamo ya existe.',
            'loan_code.string' => 'El código del préstamo solo debe contener letras y/o números.',
            'loan_code.regex' => 'El código del préstamo no puede contener símbolos.',
            'loan_code.min' => 'El código del préstamo debe contener al menos 10 letras.',
            'loan_code.max' => 'El código del préstamo no puede exceder 10 letras.',

            // Loan payment type
            'loan_payment_type.required' => 'La forma de pago es obligatoria (diario, semanal, quincenal, mensual).',
            'loan_payment_type.min' => 'La forma de pago mínima es diariamente.',
            'loan_payment_type.max' => 'La forma de pago máxima es mensualmente.',

            // Loan amount messages
            'loan_amount.required' => 'El monto del préstamo es obligatoria.',
            'loan_amount.numeric' => 'El monto del préstamo solo debe contener números.',
            'loan_amount.regex' => 'El monto del préstamo no puede contener letras ni símbolos.',
            'loan_amount.min' => 'El monto del préstamo debe ser mayor a 0 lps.',

            // Loan quote value messages
            'loan_quote_value.required' => 'El monto a pagar por cuota es obligatoria.',
            'loan_quote_value.numeric' => 'El monto a pagar por cuota solo debe contener números.',
            'loan_quote_value.regex' => 'El monto a pagar por cuota no puede contener letras ni símbolos.',
            'loan_quote_value.min' => 'El monto a pagar por cuota debe ser mayor a 0 lps.',

            // Loan tax
            'loan_tax.required' => 'El interés del préstamo  es obligatoria.',
            'loan_tax.numeric' => 'El interés del préstamo solo debe contener números.',
            'loan_tax.regex' => 'El interés del préstamo no puede contener letras ni símbolos.',
            'loan_tax.min' => 'El interés del préstamo debe ser como mínimo 0%.',
            'loan_tax.max' => 'El interés del préstamo debe ser como máximo 100%.',

            // Loan total messages
            'loan_total.required' => 'El monto final del préstamo (P+I) es obligatoria.',
            'loan_total.numeric' => 'El monto final del préstamo (P+I) solo debe contener números.',
            'loan_total.regex' => 'El monto final del préstamo (P+I) no puede contener letras ni símbolos.',
            'loan_total.min' => 'El monto final del préstamo (P+I) debe ser mayor a 0 lps.',

            // Loan start date messages
            'loan_start_date.required' => 'La fecha del primer pago del préstamo es obligatoria.',
            'loan_start_date.date' => 'Debe ingresar un formato de fecha válido para el primer pago (Y-m-d H:i:s).',

            // Loan end date messages
            'loan_end_date.required' => 'La fecha del último pago del préstamo es obligatoria.',
            'loan_end_date.date' => 'Debe ingresar un formato de fecha válido para el último pago (Y-m-d H:i:s).',     

            // Loan quota number messages
            'loan_quote_number.required' => 'El número de cuotas es obligatorio.',
            'loan_quote_number.numeric' => 'El número de cuotas solo debe contener números.',
            'loan_quote_number.min' => 'El número de cuotas debe ser como mínimo 1.',
            
            // Loan status messages
            'loan_status.required' => 'El estado del préstamo es obligatorio.',
            'loan_status.in' => 'El estado del préstamo debe ser En proceso.',

            // Loan description messages
            'loan_description.required' => 'La descripción del préstamo es obligatoria.',
            'loan_description.min' => 'La descripción del préstamo debe contener al menos 3 letras.',
            'loan_description.max' => 'La descripción del préstamo no puede exceder 255 letras.',
            'loan_description.string' => 'La descripción del préstamo solo debe contener letras, números y/o símbolos.',
        ];
    }
}
