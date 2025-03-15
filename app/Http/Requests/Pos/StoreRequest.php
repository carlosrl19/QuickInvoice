<?php

namespace App\Http\Requests\Pos;

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

    public function rules()
    {
        return [
            // POS
            'client_id' => 'required|integer|exists:clients,id',
            'seller_id' => 'required|integer|exists:sellers,id',
            'sale_total_amount' => 'required|numeric|min:0.01',
            'sale_discount' => 'required|numeric|min:0|max:100',
            'sale_tax' => 'required|numeric|min:0|max:100',
            'sale_payment' => 'required|numeric|min:0.01|gte:sale_total_amount',
            'sale_payment_type' => 'required|numeric|in:1,2,3',
            'sale_payment_change' => 'required|numeric|min:0',

            // POS Details
            'service_id' => 'required|array',
            'service_id.*' => 'integer|exists:services,id',
            'sale_details' => 'required|array',
            'sale_details.*' => 'string',
            'sale_quantity' => 'required|array',
            'sale_quantity.*' => 'integer|min:1',
            'sale_price' => 'required|array',
            'sale_price.*' => 'numeric|min:0.01',
            'sale_subtotal' => 'required|array',
            'sale_subtotal.*' => 'numeric|min:0.01',
        ];
    }

    public function messages()
    {
        return [
            // Client_id messages
            'client_id.required' => 'El cliente es obligatorio.',
            'client_id.integer' => 'El cliente debe ser un número entero (dev.request).',
            'client_id.exists' => 'El cliente seleccionado no existe.',

            // Seller_id messages
            'seller_id.required' => 'El vendedor es obligatorio.',
            'seller_id.integer' => 'El vendedor debe ser un número entero (dev.request).',
            'seller_id.exists' => 'El vendedor seleccionado no existe.',

            // Sale_total_amount messages
            'sale_total_amount.required' => 'El monto total de la venta es obligatorio.',
            'sale_total_amount.numeric' => 'El monto total de la venta debe ser un número.',
            'sale_total_amount.min' => 'El monto total de la venta debe ser al menos L. :min',

            // Sale_discount messages
            'sale_discount.required' => 'El descuento de la venta es obligatorio.',
            'sale_discount.numeric' => 'El descuento de la venta debe ser un número.',
            'sale_discount.min' => 'El descuento de la venta debe ser al menos L. :min',
            'sale_discount.max' => 'El descuento de la venta no puede ser mayor que L. :max.',

            // Sale_tax messages
            'sale_tax.required' => 'El ISV es obligatorio.',
            'sale_tax.numeric' => 'El ISV debe ser un número.',
            'sale_tax.min' => 'El ISV debe ser al menos :min%.',
            'sale_tax.max' => 'El ISV no puede ser mayor que :max%.',

            // Sale payment type messages
            'sale_payment.required' => 'El pago de la venta es obligatorio.',
            'sale_payment.numeric' => 'El pago de la venta debe ser un número.',
            'sale_payment.min' => 'El pago de la venta debe ser al menos L. :min',
            'sale_payment.gte' => 'El pago de la venta debe ser mayor o igual a :min',

            // Sale payment messages
            'sale_payment_type.required' => 'El tipo de pago es obligatorio.',
            'sale_payment_type.numeric' => 'El tipo de pago debe ser EFECTIVO, TARJETA O DEPÓSITO.',
            'sale_payment_type.in' => 'El tipo de pago debe ser mayor o igual a :min',

            // Sale payment change messages
            'sale_payment_change.required' => 'El cambio del pago de la venta es obligatorio.',
            'sale_payment_change.numeric' => 'El cambio del pago de la venta debe ser un número.',
            'sale_payment_change.min' => 'El cambio del pago de la venta debe ser al menos L. :min',

            // Service_id. essages
            'service_id.required' => 'El servicio es obligatorio.',
            'service_id.array' => 'El servicio debe ser un arreglo (dev.request).',
            'service_id.*.integer' => 'Cada servicio debe ser un número entero (dev.request).',
            'service_id.*.exists' => 'El servicio seleccionado no existe.',

            // Sale_details messages
            'sale_details.required' => 'Los detalles de la venta son obligatorios.',
            'sale_details.array' => 'Los detalles de la venta deben ser un arreglo (dev.request).',
            'sale_details.*.string' => 'Cada detalle de la venta debe ser una cadena.',

            // Sale_quantity messages
            'sale_quantity.required' => 'La cantidad de la venta es obligatoria.',
            'sale_quantity.array' => 'La cantidad de la venta debe ser un arreglo (dev.request).',
            'sale_quantity.*.integer' => 'Cada cantidad de la venta debe ser un número entero.',
            'sale_quantity.*.min' => 'Cada cantidad de la venta debe ser al menos L. :min',

            // Sale_price messages
            'sale_price.required' => 'El precio de la venta es obligatorio.',
            'sale_price.array' => 'El precio de la venta debe ser un arreglo.',
            'sale_price.*.numeric' => 'Cada precio de la venta debe ser un número.',
            'sale_price.*.min' => 'Cada precio de la venta debe ser al menos L. :min',

            // Sale_subtotal messages
            'sale_subtotal.required' => 'El subtotal de la venta es obligatorio.',
            'sale_subtotal.array' => 'El subtotal de la venta debe ser un arreglo.',
            'sale_subtotal.*.numeric' => 'Cada subtotal de la venta debe ser un número.',
            'sale_subtotal.*.min' => 'Cada subtotal de la venta debe ser al menos L. :min',
        ];
    }
}
