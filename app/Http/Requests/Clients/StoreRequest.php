<?php

namespace App\Http\Requests\Clients;

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
            'client_name' => 'required|string|min:3|max:55|regex:/^[^\d]+$/|unique:clients',
            'client_document' => 'required|string|min:13|max:14|regex:/^[0-9]+$/|unique:clients',
            'client_type' => 'required|string|min:7|max:8|regex:/^[^\d]+$/',
            'client_phone1' => 'required|string|min:8|max:8|regex:/^[0-9]+$/|unique:clients',
            'client_phone2' => 'nullable|string|min:8|max:8|regex:/^[0-9]+$/|unique:clients',
            'client_address' => 'nullable|string|min:3|max:155',
        ];
    }

    public function messages(): array
    {
        return [
            // Client name messages
            'client_name.required' => 'El nombre del cliente es obligatorio.',
            'client_name.unique' => 'El nombre del cliente ya existe.',
            'client_name.string' => 'El nombre del cliente solo debe contener letras.',
            'client_name.regex' => 'El nombre del cliente no puede contener números ni símbolos.',
            'client_name.min' => 'El nombre del cliente debe contener al menos :min caracteres.',
            'client_name.max' => 'El nombre del cliente no puede exceder :max caracteres.',

            // Client document messages
            'client_document.required' => 'El doc. del cliente es obligatorio.',
            'client_document.unique' => 'El doc. del cliente ya existe.',
            'client_document.string' => 'El doc. del cliente solo debe contener números.',
            'client_document.regex' => 'El doc. del cliente no puede contener letras ni símbolos.',
            'client_document.min' => 'El doc. del cliente debe contener al menos :min caracteres.',
            'client_document.max' => 'El doc. del cliente no puede exceder :max caracteres.',

            // Client type messages
            'client_type.required' => 'El tipo de cliente es obligatorio.',
            'client_type.string' => 'El tipo de cliente solo debe contener letras.',
            'client_type.regex' => 'El tipo de cliente no puede contener números ni símbolos.',
            'client_type.min' => 'El tipo de cliente debe contener al menos :min caracteres.',
            'client_type.max' => 'El tipo de cliente no puede exceder :max caracteres.',

            // Client phone1 messages
            'client_phone1.required' => 'El Nº teléfono principal es obligatorio.',
            'client_phone1.unique' => 'El Nº teléfono principal ya existe.',
            'client_phone1.string' => 'El Nº teléfono principal solo debe contener números.',
            'client_phone1.regex' => 'El Nº teléfono principal no puede contener letras ni símbolos.',
            'client_phone1.min' => 'El Nº teléfono principal debe contener al menos :min letras.',
            'client_phone1.max' => 'El Nº teléfono principal no puede exceder :max caracteres.',

            // Client phone2 messages
            'client_phone2.unique' => 'El Nº teléfono secundario ya existe.',
            'client_phone2.string' => 'El Nº teléfono secundario solo debe contener números.',
            'client_phone2.regex' => 'El Nº teléfono secundario no puede contener letras ni símbolos.',
            'client_phone2.min' => 'El Nº teléfono secundario debe contener al menos :min caracteres.',
            'client_phone2.max' => 'El Nº teléfono secundario no puede exceder :max caracteres.',

            // Client address messages
            'client_address.string' => 'El domicilio del cliente solo debe contener letras y números.',
            'client_address.min' => 'El domicilio del cliente debe contener al menos :min caracteres.',
            'client_address.max' => 'El domicilio del cliente no puede exceder :max caracteres.',
        ];
    }
}
