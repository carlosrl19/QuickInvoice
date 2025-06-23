<?php

namespace App\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_name' =>  'required|string|max:55|unique:categories|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/|',
            'category_description' => 'required|string|max:155',
        ];
    }

    public function messages(): array
    {
        return [
            // Category name messages
            'category_name.required' => 'El nombre es obligatorio.',
            'category_name.string' => 'El nombre debe ser una cadena de texto.',
            'category_name.max' => 'El nombre no puede tener más de :max caracteres.',
            'category_name.unique' => 'El nombre ya existe.',
            'category_name.regex' => 'El nombre solo debe contener letras.',

            // Category description messages
            'category_description.required' => 'La descripción es obligatoria.',
            'category_description.string' => 'La descripción debe ser una cadena de texto.',
            'category_description.max' => 'La descripción no puede tener más de :max caracteres.',
        ];
    }
}
