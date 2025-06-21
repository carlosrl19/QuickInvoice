<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'category_id' => 'required|integer|exists:categories,id',
            'product_barcode' =>  'nullable|string|regex:/^[0-9]+$/|min:4|max:13|unique:products',
            'product_name' => 'required|string|min:3|max:40|unique:products',
            'product_description' => 'nullable|string|min:3|max:255',
            'product_stock' =>  'required|numeric|min:0',
            'product_buy_price' => 'required|numeric|min:0.01|lt:product_sell_price',
            'product_sell_price' => 'required|numeric|gt:product_buy_price',
            'product_image' => 'nullable|string', // Es un token, no un archivo | // Default (images/resources/no_image_available.png)
        ];
    }

    public function messages()
    {
        return [
            // Category id messages
            'category_id.required' => 'La categoría del producto es obligatoria.',
            'category_id.integer' => 'La categoría debe ser un número entero (dev.request).',
            'category_id.exists' => 'La categoría seleccionada no existe.',

            // Product barcode messages
            'product_barcode.string' => 'El código de barra del producto solo acepta números.',
            'product_barcode.min' => 'El código de barra del producto debe contener al menos :min digitos.',
            'product_barcode.max' => 'El código de barra del producto no puede exceder :max digitos.',
            'product_barcode.unique' => 'El código de barra del producto ya existe.',
            'product_barcode.regex' => 'El código de barra del producto debe contener únicamente números.',

            // Product product_name messages
            'product_name.required' => 'El nombre del producto es obligatorio.',
            'product_name.string' => 'El nombre del producto solo debe contener letras y números.',
            'product_name.min' => 'El nombre del producto debe contener al menos :min letras.',
            'product_name.unique' => 'El nombre del producto ya existe.',
            'product_name.max' => 'El nombre del producto no puede exceder :max letras.',

            // Product description messages
            'product_description.string' => 'La descripción del producto solo debe contener letras.',
            'product_description.min' => 'La descripción del producto debe contener al menos :min letras.',
            'product_description.max' => 'La descripción del producto no puede exceder :max letras.',

            // Product existance messages
            'product_stock.required' => 'La existencia del producto es obligatoria.',
            'product_stock.numeric' => 'La existencia del producto solo debe contener números.',
            'product_stock.min' => 'La existencia del producto debe ser mayor o igual a L. :min.',

            // Product purchase price
            'product_buy_price.numeric' => 'El precio de compra solo debe contener números.',
            'product_buy_price.required' => 'El precio de compra es obligatorio.',
            'product_buy_price.min' => 'El precio de compra debe ser superior a L. :min.',
            'product_buy_price.lt' => 'El precio de compra debe ser inferior al precio de venta.',

            // Product final price
            'product_sell_price.numeric' => 'El precio de venta solo acepta números.',
            'product_sell_price.required' => 'El precio de venta es obligatorio.',
            'product_sell_price.min' => 'El precio de venta debe ser superior al precio de venta al por mayor.',
            'product_sell_price.gt' => 'El precio de venta debe ser mayor al precio de compra.',

            // Product image
            'product_image.image' => 'La imagen del producto debe ser un archivo de tipo imagen (.png, .jpeg, .jpg, .webp).',
            'product_image.max' => 'La imagen que intenta subir es demasiado grande, intente optimizar la imagen.()',
        ];
    }
}
