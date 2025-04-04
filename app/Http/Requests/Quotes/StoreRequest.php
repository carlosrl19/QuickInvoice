<?php

namespace App\Http\Requests\Quotes;

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
            // Quote
            'quote_code' => 'required|string|min:9|max:9|regex:/^[A-Z0-9]+$/|unique:quotes',
            'client_id' => 'required|integer|exists:clients,id',
            'seller_id' => 'required|integer|exists:sellers,id',
            'quote_type' => 'required|string|min:1|max:2',
            'quote_total_amount' => 'required|numeric|min:0.01',
            'quote_discount' => 'required|numeric|min:0|max:100',
            'quote_tax' => 'required|numeric|min:0|max:100',
            'quote_expiration_date' => 'required|date:Y-m-d',
            'quote_status' => 'required|integer|in:0,1,2,3,4',
            'quote_answer' => 'nullable|string|min:3|max:75',

            // Quote Details
            'service_id' => 'nullable|array', // Nullable porque JSValidator no capturaba los service_id enviados, por qué?
            'service_id.*' => 'integer|exists:services,id',
            'quote_details' => 'required|array',
            'quote_details.*' => 'string',
            'quote_quantity' => 'required|array',
            'quote_quantity.*' => 'integer|min:1',
            'quote_price' => 'required|array',
            'quote_price.*' => 'numeric|min:0.01',
            'quote_subtotal' => 'required|array',
            'quote_subtotal.*' => 'numeric|min:0.01',
        ];
    }

    public function messages()
    {
        return [
            // Quote code messages
            'quote_code.required' => 'El código de cotización es obligatorio.',
            'quote_code.unique' => 'El código de cotización ya existe.',
            'quote_code.string' => 'El código de cotización solo debe contener letras y/o números.',
            'quote_code.regex' => 'El código de cotización no puede contener símbolos.',
            'quote_code.min' => 'El código de cotización debe contener al menos :min letras.',
            'quote_code.max' => 'El código de cotización no puede exceder :max letras.',

            // Client_id messages
            'client_id.required' => 'El cliente es obligatorio.',
            'client_id.integer' => 'El cliente debe ser un número entero (dev.request).',
            'client_id.exists' => 'El cliente seleccionado no existe.',

            // Seller_id messages
            'seller_id.required' => 'El vendedor es obligatorio.',
            'seller_id.integer' => 'El vendedor debe ser un número entero (dev.request).',
            'seller_id.exists' => 'El vendedor seleccionado no existe.',

            // Sale type messages
            'quote_type.required' => 'El tipo de cotización es obligatorio',
            'quote_type.string' => 'El tipo de cotización solo puede ser Gravada o Exenta.',
            'quote_type.min' => 'El tipo de cotización debe contener al menos :min caracter.',
            'quote_type.max' => 'El tipo de cotización debe contener como máximo :max caracter.',

            // quote_total_amount messages
            'quote_total_amount.required' => 'El monto total de la cotización es obligatorio.',
            'quote_total_amount.string' => 'El monto total de la cotización debe ser un número.',
            'quote_total_amount.min' => 'El monto total de la cotización debe ser al menos L. :min',

            // quote_discount messages
            'quote_discount.required' => 'El descuento de la cotización es obligatorio.',
            'quote_discount.numeric' => 'El descuento de la cotización debe ser un número.',
            'quote_discount.min' => 'El descuento de la cotización debe ser al menos L. :min',
            'quote_discount.max' => 'El descuento de la cotización no puede ser mayor que L. :max.',

            // quote_tax messages
            'quote_tax.required' => 'El ISV es obligatorio.',
            'quote_tax.numeric' => 'El ISV debe ser un número.',
            'quote_tax.min' => 'El ISV debe ser al menos :min%.',
            'quote_tax.max' => 'El ISV no puede ser mayor que :max%.',

            // Quote expiration date messages
            'quote_expiration_date.required' => 'La fecha de vencimiento de la cotización es obligatoria.',
            'quote_expiration_date.date' => 'El formato de la fecha de vencimiento debe ser Y-m-d.',

            // Quote status messages
            'quote_status.required' => 'El estado de la cotización es obligatoria.',
            'quote_status.integer' => 'El estado de la cotización solo debe contener números.',
            'quote_status.in' => 'El estado de la cotización debe ser: 0: En proceso, 1: Aceptada, 2: Rechazada, 3: Sin respuesta, 4: Vencida.',

            // Quote answer messages
            'quote_answer.string' => 'Las anotaciones de la cotización solo debe contener letras, números y símbolos.',
            'quote_answer.min' => 'Las anotaciones de la cotización debe contener al menos :min caracteres.',
            'quote_answer.max' => 'Las anotaciones de la cotización debe contener como máximo :min caracteres.',

            // Service_id messages
            'service_id.required' => 'El servicio es obligatorio.',
            'service_id.array' => 'El servicio debe ser un arreglo (dev.request).',
            'service_id.*.integer' => 'Cada servicio debe ser un número entero (dev.request).',
            'service_id.*.exists' => 'El servicio seleccionado no existe.',

            // quote_details messages
            'quote_details.required' => 'Los detalles de la cotización son obligatorios.',
            'quote_details.array' => 'Los detalles de la cotización deben ser un arreglo (dev.request).',
            'quote_details.*.string' => 'Cada detalle de la cotización debe ser una cadena.',

            // quote_quantity messages
            'quote_quantity.required' => 'La cantidad de la cotización es obligatoria.',
            'quote_quantity.array' => 'La cantidad de la cotización debe ser un arreglo (dev.request).',
            'quote_quantity.*.integer' => 'Cada cantidad de la cotización debe ser un número entero.',
            'quote_quantity.*.min' => 'Cada cantidad de la cotización debe ser al menos L. :min',

            // quote_price messages
            'quote_price.required' => 'El precio es obligatorio.',
            'quote_price.array' => 'El precio debe ser un arreglo.',
            'quote_price.*.numeric' => 'Cada precio debe ser un número.',
            'quote_price.*.min' => 'Cada precio debe ser al menos L. :min',

            // quote_subtotal messages
            'quote_subtotal.required' => 'El subtotal de la cotización es obligatorio.',
            'quote_subtotal.array' => 'El subtotal de la cotización debe ser un arreglo.',
            'quote_subtotal.*.numeric' => 'Cada subtotal de la cotización debe ser un número.',
            'quote_subtotal.*.min' => 'Cada subtotal de la cotización debe ser al menos L. :min',
        ];
    }
}
