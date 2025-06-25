<?php

namespace App\Http\Requests\Sales;

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
            'sale_doc_number' => 'required|string|min:10|max:10|unique:sales',
            'sale_total_amount' => 'required|numeric|min:0.01',
            'sale_discount' => 'required|min:0|max:100',
            'sale_description' => 'required|string|min:3|max:600',
            'user_id' => 'required|numeric|exists:users,id'
        ];
    }

    public function messages(): array
    {
        return [
            // Sale doc number messages
            'sale_doc_number.required' => 'El número de documento de la salida es obligatorio.',
            'sale_doc_number.string' => 'El número de documento de la salida debe ser una cadena de texto.',
            'sale_doc_number.min' => 'El número de documento de la salida debe tener al menos :min caracteres.',
            'sale_doc_number.max' => 'El número de documento de la salida debe tener como máximo :max caracteres.',
            'sale_doc_number.unique' => 'El número de documento de la salida ya existe.',

            // Sale total amount messages
            'sale_total_amount.required' => 'El monto total de la salida es obligatorio.',
            'sale_total_amount.numeric' => 'El monto total de la salida debe ser un número.',
            'sale_total_amount.min' => 'El monto total de la salida debe ser mayor o igual a L. :min.',

            // Sale discount messages
            'sale_discount.required' => 'El descuento de la salida es obligatorio.',
            'sale_discount.min' => 'El descuento de la salida debe ser mayor o igual a :min%.',
            'sale_discount.max' => 'El descuento de la salida debe ser menor o igual a :max%.',

            // Sale description messages
            'sale_description.required' => 'La descripción de la salida es obligatorio.',
            'sale_description.string' => 'La descripción de la salida debe ser una cadena de texto.',
            'sale_description.min' => 'La descripción de la salida debe tener al menos :min caracteres.',
            'sale_description.max' => 'La descripción de la salida debe tener como máximo :max caracteres.',

            // User ID messages
            'user_id.required' => 'El usuario es obligatorio (dev.request).',
            'user_id.numeric' => 'El usuario debe ser un número (dev.request).',
            'user_id.exists' => 'El usuario no existe (dev.request).'
        ];
    }
}
