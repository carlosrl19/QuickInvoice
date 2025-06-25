<?php

namespace App\Http\Requests\SaleDetails;

use App\Models\Products;
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
            'sale_id' => 'required|numeric|exists:sales,id',
            'product_id' => 'required|numeric|exists:products,id',
            'product_quantity' => 'required|numeric|min:1',
            'sale_subtotal' => 'required|numeric|min:0.01'
        ];
    }

    public function messages(): array
    {
        return [
            // Sale ID messages
            'sale_id.required' => 'El ID de la venta es obligatorio.',
            'sale_id.numeric' => 'El ID de la venta debe ser un número.',
            'sale_id.exists' => 'El ID de la venta no existe en la tabla de ventas.',

            // Product ID messages
            'product_id.required' => 'El ID del producto es obligatorio.',
            'product_id.numeric' => 'El ID del producto debe ser un número.',
            'product_id.exists' => 'El ID del producto no existe en la tabla de productos.',

            // Product quantity messages
            'product_quantity.required' => 'La cantidad del producto es obligatoria.',
            'product_quantity.numeric' => 'La cantidad del producto debe ser un número.',
            'product_quantity.min' => 'La cantidad del producto debe ser al menos 1.',

            // Sale subtotal messages
            'sale_subtotal.required' => 'El subtotal de la venta es obligatorio.',
            'sale_subtotal.numeric' => 'El subtotal de la venta debe ser un número.',
            'sale_subtotal.min' => 'El subtotal de la venta debe ser al menos 0.01.'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $productId = request()->input('product_id');
            $productQuantity = request()->input('product_quantity');

            if ($productId && $productQuantity) {
                $product = Products::findOrFail($productId);

                if ($product && $productQuantity > $product->product_stock) {
                    $validator->errors()->add(
                        'product_quantity',
                        'La cantidad de producto ' . $product->product_name . ' ingresada excede el stock disponible.'
                    );
                }
            }
        });
    }
}
