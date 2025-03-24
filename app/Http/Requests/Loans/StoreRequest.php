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
            // Loan Requests
            'client_id' => 'required|numeric|exists:clients,id',
            'seller_id' => 'required|numeric|exists:sellers,id',
            'loan_code_number' => 'required|string|min:9|max:9|regex:/^[a-zA-Z0-9]+$/|unique:loans,loan_code_number',
            'loan_request_number' => 'required|string|min:9|max:9|regex:/^[a-zA-Z0-9]+$/|unique:loans,loan_request_number',
            'loan_payment_type' => 'required|min:1|max:4',
            'loan_amount' => 'required|numeric|min:1|regex:/^\d+(\.\d{1,2})?$/',
            'loan_quote_value' => 'required|numeric|min:1|regex:/^\d+(\.\d{1,2})?$/',
            'loan_interest' => 'required|numeric|min:0|max:100',
            'loan_total' => 'required|numeric|min:1|regex:/^\d+(\.\d{1,2})?$/',
            'loan_start_date' => 'required|date:Y-m-d H:i:s',
            'loan_end_date' => 'required|date:Y-m-d H:i:s|after:loan_start_date',
            'loan_quote_number' => 'required|numeric|min:1',
            'loan_status' => 'required|in:0,1,2',
            'loan_request_status' => 'required|in:0,1,2',
            'loan_description' => 'required|string|min:3|max:255',
        ];
    }

    public function messages()
    {
        return [
            /***************************
             * Loan Request messages
             ****************************/

            // Client id messages
            'client_id.required' => 'El cliente es obligatorio.',
            'client_id.numeric' => 'El id del cliente solo debe contener números (dev.request).',
            'client_id.exists' => 'El cliente seleccionado no existe en la base de datos.',

            // Seller id messages
            'seller_id.required' => 'El cliente es obligatorio.',
            'seller_id.numeric' => 'El id del cliente solo debe contener números (dev.request).',
            'seller_id.exists' => 'El cliente seleccionado no existe en la base de datos.',

            // Loan code messages
            'loan_code_number.required' => 'El código del préstamo es obligatorio.',
            'loan_code_number.unique' => 'El código del préstamo ya existe.',
            'loan_code_number.string' => 'El código del préstamo solo debe contener letras y/o números.',
            'loan_code_number.regex' => 'El código del préstamo no puede contener símbolos.',
            'loan_code_number.min' => 'El código del préstamo debe contener al menos :min letras.',
            'loan_code_number.max' => 'El código del préstamo no puede exceder :max letras.',

            // Loan request messages
            'loan_request_number.required' => 'El código de solicitud del préstamo es obligatorio.',
            'loan_request_number.unique' => 'El código de solicitud del préstamo ya existe.',
            'loan_request_number.string' => 'El código de solicitud del préstamo solo debe contener letras y/o números.',
            'loan_request_number.regex' => 'El código de solicitud del préstamo no puede contener símbolos.',
            'loan_request_number.min' => 'El código de solicitud del préstamo debe contener al menos :min letras.',
            'loan_request_number.max' => 'El código de solicitud del préstamo no puede exceder :max letras.',

            // Loan payment type
            'loan_payment_type.required' => 'El tipo de pago es obligatoria.',
            'loan_payment_type.min' => 'El tipo de pago mínimo es diariamente.',
            'loan_payment_type.max' => 'El tipo de pago máximo es mensualmente.',

            // Loan amount messages
            'loan_amount.required' => 'El monto del préstamo es obligatoria.',
            'loan_amount.numeric' => 'El monto del préstamo solo debe contener números.',
            'loan_amount.regex' => 'El monto del préstamo no puede contener letras ni símbolos.',
            'loan_amount.min' => 'El monto del préstamo debe ser mayor a :min lps.',

            // Loan quote value messages
            'loan_quote_value.required' => 'El monto a pagar por cuota es obligatoria.',
            'loan_quote_value.numeric' => 'El monto a pagar por cuota solo debe contener números.',
            'loan_quote_value.regex' => 'El monto a pagar por cuota no puede contener letras ni símbolos.',
            'loan_quote_value.min' => 'El monto a pagar por cuota debe ser mayor a :min lps.',

            // Loan tax
            'loan_interest.required' => 'El interés del préstamo  es obligatoria.',
            'loan_interest.numeric' => 'El interés del préstamo solo debe contener números.',
            'loan_interest.regex' => 'El interés del préstamo no puede contener letras ni símbolos.',
            'loan_interest.min' => 'El interés del préstamo debe ser como mínimo :min%.',
            'loan_interest.max' => 'El interés del préstamo debe ser como máximo :max%.',

            // Loan total messages
            'loan_total.required' => 'El monto final del préstamo (P+I) es obligatoria.',
            'loan_total.numeric' => 'El monto final del préstamo (P+I) solo debe contener números.',
            'loan_total.regex' => 'El monto final del préstamo (P+I) no puede contener letras ni símbolos.',
            'loan_total.min' => 'El monto final del préstamo (P+I) debe ser mayor a :min lps.',

            // Loan start date messages
            'loan_start_date.required' => 'La fecha del primer pago del préstamo es obligatoria.',
            'loan_start_date.date' => 'Debe ingresar un formato de fecha válido para el primer pago (Y-m-d H:i:s) (dev.request).',

            // Loan end date messages
            'loan_end_date.required' => 'La fecha del último pago del préstamo es obligatoria.',
            'loan_end_date.date' => 'Debe ingresar un formato de fecha válido para el último pago (Y-m-d H:i:s) (dev.request).',

            // Loan quota number messages
            'loan_quote_number.required' => 'El número de cuotas es obligatorio.',
            'loan_quote_number.numeric' => 'El número de cuotas solo debe contener números.',
            'loan_quote_number.min' => 'El número de cuotas debe ser como mínimo :min',

            // Loan status messages
            'loan_status.required' => 'El estado del préstamo es obligatorio.',
            'loan_status.in' => 'El estado del préstamo debe ser entre 0 y 2 (dev.request).',

            // Loan request status messages
            'loan_request_status.required' => 'El estado de la solicitud del préstamo es obligatorio.',
            'loan_request_status.in' => 'El estado de la solicitud del préstamo debe ser entre 0 y 2 (dev.request).',

            // Loan description messages
            'loan_description.required' => 'La descripción del préstamo es obligatoria.',
            'loan_description.min' => 'La descripción del préstamo debe contener al menos :min letras.',
            'loan_description.max' => 'La descripción del préstamo no puede exceder :max letras.',
            'loan_description.string' => 'La descripción del préstamo solo debe contener letras, números y/o símbolos.',
        ];
    }
}
