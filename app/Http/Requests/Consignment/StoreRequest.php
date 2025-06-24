<?php

namespace App\Http\Requests\Consignment;

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
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'product_quantity' => 'required|array',
            'product_quantity.*' => 'integer|min:1',
            'person_name' => 'required|string|min:3|max:55',
            'person_dni' => 'required|string|min:13|max:13',
            'person_phone' => 'required|string|min:8|max:8',
            'person_address' => 'required|string|min:3|max:155',
            'consignment_code' => 'required|string|max:8',
            'consignment_date' => 'required|date_format:Y-m-d H:i:s',
            'consignment_amount' => 'required|numeric|min:0',
            'consignment_status' => 'required|in:completed',
        ];
    }

    public function messages(): array
    {
        return [
            // Product id messages
            'product_id.required' => 'Debe enviar al menos un producto.',
            'product_id.array' => 'El formato de los productos es inválido.',
            'product_id.*.exists' => 'El producto seleccionado no existe.',

            // Product quantity messages
            'product_quantity.required' => 'Debe enviar la cantidad para los productos.',
            'product_quantity.array' => 'El formato de las cantidades es inválido.',
            'product_quantity.*.integer' => 'La cantidad de cada producto debe ser un número válido.',
            'product_quantity.*.min' => 'La cantidad de cada producto debe ser al menos 1.',

            // Person name messages            
            'person_name.required' => 'El nombre es obligatorio.',
            'person_name.string' => 'El nombre debe contener solamente letras.',
            'person_name.min' => 'El nombre debe tener al menos :min caracteres.',
            'person_name.max' => 'El nombre no debe exceder los :max caracteres.',

            // Person DNI messages
            'person_dni.required' => 'El DNI es obligatorio.',
            'person_dni.string' => 'El DNI debe contener solamente letras y números.',
            'person_dni.min' => 'El DNI debe tener exactamente :min caracteres.',
            'person_dni.max' => 'El DNI no debe exceder los :max caracteres.',

            // Person phone messages
            'person_phone.required' => 'El teléfono es obligatorio.',
            'person_phone.string' => 'El teléfono debe contener solamente números.',
            'person_phone.min' => 'El teléfono debe tener exactamente :min caracteres.',
            'person_phone.max' => 'El teléfono no debe exceder los :max caracteres.',

            // Person address messages
            'person_address.required' => 'La dirección es obligatoria.',
            'person_address.string' => 'La dirección debe contener solamente letras y números.',
            'person_address.min' => 'La dirección debe tener al menos :min caracteres.',
            'person_address.max' => 'La dirección no debe exceder los :max caracteres.',

            // Consignment code messages
            'consignment_code.required' => 'El código de consignación es obligatorio.',
            'consignment_code.string' => 'El código de consignación debe contener solamente letras y números.',
            'consignment_code.max' => 'El código de consignación no debe exceder los :max caracteres.',

            // Consignment date messages
            'consignment_date.required' => 'El fecha de consignación es obligatorio.',
            'consignment_date.date_format' => 'El formato de la fecha de consignación debe ser Y-m-d H:i:s.',

            // Consignment amount messages
            'consignment_amount.required' => 'El valor de la consignación es obligatorio.',
            'consignment_amount.numeric' => 'El valor de la consignación debe ser un número válido.',
            'consignment_amount.min' => 'El valor de la consignación debe ser al menos :min.',

            // Consignment status messages
            'consignment_status.required' => 'El estado de consignación es obligatorio.',
            'consignment_status.in' => 'El estado de consignación debe ser "completed".',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $productIds = request()->input('product_id');
            $productQuantities = request()->input('product_quantity');

            if ($productIds && $productQuantities) {
                // Obtener todos los productos de una sola consulta
                $products = Products::whereIn('id', $productIds)->get()->keyBy('id');

                foreach ($productIds as $index => $productId) {
                    $product = $products->get($productId);
                    $quantity = $productQuantities[$index] ?? 0;

                    if (!$product) {
                        $validator->errors()->add(
                            'product_id.' . $index,
                            'El producto seleccionado no existe'
                        );
                        continue;
                    }

                    if ($quantity > $product->product_stock) {
                        $validator->errors()->add(
                            'product_quantity.' . $index,
                            'La cantidad para ' . $product->product_name . ' excede el stock disponible (Stock: ' . $product->product_stock . ')'
                        );
                    }
                }
            }
        });
    }
}
