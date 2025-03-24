<?php

namespace App\Http\Requests\Sellers;

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

    public function rules(): array
    {
        return [
            'seller_name' => 'required|string|min:3|max:55|regex:/^[^\d]+$/|unique:sellers',
            'seller_document' => 'required|string|min:13|max:14|regex:/^[0-9]+$/|unique:sellers',
            'seller_phone' => 'required|string|min:8|max:8|regex:/^[0-9]+$/|unique:sellers',
        ];
    }

    public function messages(): array
    {
        return [
            // Seller name messages
            'seller_name.required' => 'El nombre del vendedor es obligatorio.',
            'seller_name.unique' => 'El nombre del vendedor ya existe.',
            'seller_name.string' => 'El nombre del vendedor solo debe contener letras.',
            'seller_name.regex' => 'El nombre del vendedor no puede contener números ni símbolos.',
            'seller_name.min' => 'El nombre del vendedor debe contener al menos :min caracteres.',
            'seller_name.max' => 'El nombre del vendedor no puede exceder :max caracteres.',

            // Seller document messages
            'seller_document.required' => 'El doc. del vendedor es obligatorio.',
            'seller_document.unique' => 'El doc. del vendedor ya existe.',
            'seller_document.string' => 'El doc. del vendedor solo debe contener números.',
            'seller_document.regex' => 'El doc. del vendedor no puede contener letras ni símbolos.',
            'seller_document.min' => 'El doc. del vendedor debe contener al menos :min caracteres.',
            'seller_document.max' => 'El doc. del vendedor no puede exceder :max caracteres.',

            // Seller phone messages
            'seller_phone.required' => 'El Nº teléfono es obligatorio.',
            'seller_phone.unique' => 'El Nº teléfono ya existe.',
            'seller_phone.string' => 'El Nº teléfono solo debe contener números.',
            'seller_phone.regex' => 'El Nº teléfono no puede contener letras ni símbolos.',
            'seller_phone.min' => 'El Nº teléfono debe contener al menos :min letras.',
            'seller_phone.max' => 'El Nº teléfono no puede exceder :max caracteres.',
        ];
    }
}
