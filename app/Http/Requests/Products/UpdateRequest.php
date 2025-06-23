<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $productId = $this->route('product');

        return [
            'category_id' => 'required|integer|exists:categories,id',
            'product_barcode' => [
                'nullable',
                'string',
                'regex:/^[0-9]+$/',
                'min:4',
                'max:13',
                Rule::unique('products', 'product_barcode')->ignore($productId)
                    ->where(function ($query) use ($productId) {
                        return $query->where('id', '!=', $productId);
                    }),
            ],
            'product_name' => [
                'required',
                'string',
                'min:3',
                'max:40',
                Rule::unique('products', 'product_name')->ignore($productId)
                    ->where(function ($query) use ($productId) {
                        return $query->where('id', '!=', $productId);
                    }),
            ],
            'product_nomenclature' => [
                'required',
                'string',
                'max:20',
                Rule::unique('products', 'product_nomenclature')->ignore($productId)
                    ->where(function ($query) use ($productId) {
                        return $query->where('id', '!=', $productId);
                    }),
            ],

            'product_code' => 'required|string|max:10',
            'product_brand' => 'required|string|max:20|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9 ,.\s]+$/|',
            'product_model' => 'nullable|string|max:20|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9 ,.\s]+$/|',
            'product_status' => 'required|integer|in:0,1,2,3',
            'product_stock' => 'required|integer',
            'product_price' => 'required|numeric|between:0,99999999.99',
            'product_description' => 'nullable|string|max:600',
            'product_status_description' => 'required|string|max:600',
            'product_image' => 'nullable',
            'product_image.*' => 'image',
            'product_reviewed_by' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            // Product code messages
            'product_code.required' => 'El código es obligatorio.',
            'product_code.string' => 'El código debe ser una cadena de texto.',
            'product_code.max' => 'El código no puede tener más de :max caracteres.',

            // Product nomenclature messages
            'product_nomenclature.required' => 'La nomenclatura es obligatoria.',
            'product_nomenclature.string' => 'La nomenclatura debe ser una cadena de texto.',
            'product_nomenclature.max' => 'La nomenclatura no puede tener más de :max caracteres.',
            'product_nomenclature.unique' => 'La nomenclatura ya existe.',

            // Product name messages
            'product_name.required' => 'El nombre es obligatorio.',
            'product_name.string' => 'El nombre debe ser una cadena de texto.',
            'product_name.max' => 'El nombre no puede tener más de :max caracteres.',
            'product_name.unique' => 'El nombre ya existe.',
            'product_name.regex' => 'El nombre solo debe contener letras, puntos y/o números.',

            // Product brand messages
            'product_brand.required' => 'La marca es obligatoria.',
            'product_brand.string' => 'La marca debe ser una cadena de texto.',
            'product_brand.max' => 'La marca no puede tener más de :max caracteres.',
            'product_brand.regex' => 'La marca solo debe contener letras, puntos y/o números.',

            // Product model messages
            'product_model.string' => 'El modelo debe ser una cadena de texto.',
            'product_model.max' => 'El modelo no puede tener más de :max caracteres.',
            'product_model.regex' => 'El modelo solo debe contener letras, puntos y/o números.',

            // Product status messages
            'product_status.required' => 'El estado es obligatorio.',
            'product_status.integer' => 'El estado debe ser un número entero.',
            'product_status.in' => 'El estado debe estar entre 0 y 3.',

            // Category id messages
            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.numeric' => 'La categoría seleccionada es inválida (dev.request).',
            'category_id.exists' => 'La categoría seleccionada no existe.',

            // Product stock messages
            'product_stock.required' => 'El stock es obligatorio.',
            'product_stock.integer' => 'El stock debe ser un número entero.',

            // Product price messages
            'product_price.required' => 'El precio es obligatorio.',
            'product_price.numeric' => 'El precio debe ser un número.',
            'product_price.between' => 'El precio debe estar entre 0 y 99,999,999.99.',

            // Product description messages
            'product_description.string' => 'La descripción debe ser una cadena de texto.',
            'product_description.max' => 'La descripción no puede tener más de :max caracteres.',

            // Product status description messages
            'product_status_description.required' => 'La descripción del estado es obligatoria.',
            'product_status_description.string' => 'La descripción del estado debe ser una cadena de texto.',
            'product_status_description.max' => 'La descripción del estado no puede tener más de 600 caracteres.',

            // Product reviewed by messages
            'product_reviewed_by.required' => 'El encargado es obligatorio.',
            'product_reviewed_by.string' => 'El encargado debe ser una nombre válido.',

            // Product image messages
            'product_image.image' => 'La imagen del producto debe ser un archivo de tipo imagen (.png, .jpeg, .jpg, .webp).',
            'product_image.max' => 'La imagen que intenta subir es demasiado grande, intente optimizar la imagen.()',
        ];
    }
}
