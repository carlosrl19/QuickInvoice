<?php

namespace App\Http\Requests\WorkFormat;

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
            'workformat_date' => 'required|date',
            'client_name' => 'required|string|min:3|max:55',
            'client_phone' => 'required|string|min:8|max:8',
            'client_address' => 'required|string|min:10|max:600',
            'worker_name' => 'required|string|min:3|max:55',
            'receipt_number' => 'nullable|string|max:19',
            'workformat_type' => 'required|in:0,1,2,3,4',
            'workformat_description' => 'required|string|min:10|max:600',
            'client_signature' => 'required|string|regex:/^data:image\/png;base64,/'
        ];
    }

    public function messages(): array
    {
        return [
            // Work format date messages
            'workformat_date.required' => 'La fecha es obligatoria.',
            'workformat_date.date' => 'La fecha es inválida.',

            // Client name messages
            'client_name.required' => 'El nombre del cliente es obligatorio.',
            'client_name.min' => 'El nombre del cliente debe contener al menos :min letras.',
            'client_name.max' => 'El nombre del cliente no puede exceder :max letras.',

            // Client phone messages
            'client_phone.required' => 'El teléfono del cliente es obligatorio.',
            'client_phone.min' => 'El teléfono del cliente debe contener al menos :min números.',
            'client_phone.max' => 'El teléfono del cliente no puede exceder :max números.',

            // Client address messages
            'client_address.required' => 'La dirección del cliente es obligatoria.',
            'client_address.string' => 'La dirección del cliente no debe contener símbolos.',
            'client_address.min' => 'La dirección del cliente debe contener al menos :min letras.',
            'client_address.max' => 'La dirección del cliente no puede exceder :max letras.',

            // Worker name messages
            'worker_name.required' => 'El nombre del técnico es obligatorio.',
            'worker_name.min' => 'El nombre del técnico debe contener al menos :min letras.',
            'worker_name.max' => 'El nombre del técnico no puede exceder :max letras.',

            // Receipt number messages
            'receipt_number.required' => 'El número de recibo es obligatorio.',

            // Work format type messages
            'workformat_type.required' => 'El tipo de formato de trabajo es obligatorio.',
            'workformat_type.in' => 'El tipo de formato de trabajo debe ser un número del 0 al 4.',

            // Work format description messages
            'workformat_description.required' => 'La descripción del formato de trabajo es obligatoria.',

            // Client signature messages
            'client_signature.required' => 'La firma del cliente es obligatoria.'
        ];
    }
}
