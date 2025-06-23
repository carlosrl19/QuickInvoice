<?php

namespace App\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $categoryId = $this->route('category');

        return [
            'category_name' => [
                'required',
                'string',
                'min:3',
                'max:55',
                'regex:/^[^\d]+$/',
                Rule::unique('categories', 'category_name')->ignore($categoryId)
                    ->where(function ($query) use ($categoryId) {
                        return $query->where('id', '!=', $categoryId);
                    }),
            ],
            'category_description' => 'required|string|max:155',
        ];
    }

    public function messages()
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
