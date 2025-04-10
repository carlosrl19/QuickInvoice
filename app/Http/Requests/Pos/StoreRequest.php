<?php

namespace App\Http\Requests\Pos;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

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
            'folio_id' => 'required|integer|exists:fiscal_folios,id',
            'bank_id' => 'nullable|required_if:sale_payment_type,3|integer|exists:banks,id',
            'sale_type' => 'required|string|min:1|max:2', // E, G, ET
            'exempt_purchase_order_correlative' => 'nullable|required_if:sale_type,E|string|min:12|max:12|unique:pos,exempt_purchase_order_correlative',
            'exonerated_certificate' => 'nullable|required_if:sale_type,E|string|min:11|max:11|unique:pos,exonerated_certificate',
            'folio_invoice_number' => 'required|string|min:19|max:19|unique:pos,folio_invoice_number',
            'sale_total_amount' => 'required|numeric|min:1',
            'sale_discount' => 'required|numeric|min:0|max:100',
            'sale_tax' => 'required|numeric|min:0|max:100',
            'sale_payment_received' => 'required|numeric|min:1|gte:sale_total_amount',
            'sale_payment_type' => 'required|numeric|in:1,2,3,4,5', // 1: Efectivo, 2: Tarjeta, 3: Deposito, 4: Cheque, 5: Transferencia
            'sale_card_last_digits' => 'nullable|required_if:sale_payment_type,2|string|min:4|max:4|regex:/^[0-9]+$/', // Solo si se usa Tarjeta como sale_payment_type
            'sale_card_auth_number' => 'nullable|required_if:sale_payment_type,2|string|min:6|max:12|regex:/^[A-Z0-9]+$/', // Solo si se usa Tarjeta como sale_payment_type
            'sale_bank_operation_number' => 'nullable|required_if:sale_payment_type,3|string|min:6|max:12|regex:/^[A-Z0-9]+$/', // Solo si se usa Deposito como sale_payment_type
            'sale_bankcheck_info' => 'nullable|required_if:sale_payment_type,4|string|min:10|max:40|regex:/^[A-Z0-9\/]+$/', // Solo si se usa Cheque como sale_payment_type
            'sale_payment_change' => 'required|numeric|min:0',

            // POS Details
            'service_id' => 'nullable|array', // Nullable porque JSValidator no capturaba los service_id enviados, por qué?
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

            // Folio_id messages
            'folio_id.required' => 'El folio fiscal es obligatorio.',
            'folio_id.integer' => 'El folio fiscal debe ser un número entero (dev.request).',
            'folio_id.exists' => 'El folio fiscal seleccionado no existe.',

            // Bank_id messages
            'bank_id.required_if' => 'El banco es obligatorio.',
            'bank_id.integer' => 'El banco debe ser un número entero (dev.request).',
            'bank_id.exists' => 'El banco seleccionado no existe.',

            // Sale type messages
            'sale_type.required' => 'El tipo de venta es obligatorio',
            'sale_type.string' => 'El tipo de venta solo puede ser Gravada o Exenta.',
            'sale_type.min' => 'El tipo de venta debe contener al menos :min caracter.',
            'sale_type.max' => 'El tipo de venta debe contener como máximo :max caracter.',

            // Nº Correlativo orden de compra exenta
            'exempt_purchase_order_correlative.string' => 'El correlativo de orden compra exenta solo debe contener letras y números.',
            'exempt_purchase_order_correlative.unique' => 'El correlativo de orden compra exenta ya fue registrado antes.',
            'exempt_purchase_order_correlative.min' => 'El correlativo de orden compra exenta solo debe contener al menos :min caracteres.',
            'exempt_purchase_order_correlative.max' => 'El correlativo de orden compra exenta debe contener como máximo :max caractes.',

            // Nº Correlativo constancia registro exonerado
            'exonerated_certificate.string' => 'El correlativo de constancia del registro exonerado solo debe contener letras y números.',
            'exonerated_certificate.unique' => 'El correlativo de constancia del registro exonerado ya fue registrado antes.',
            'exonerated_certificate.min' => 'El correlativo de constancia del registro exonerado solo debe contener al menos :min caracteres.',
            'exonerated_certificate.max' => 'El correlativo de constancia del registro exonerado debe contener como máximo :max caractes.',

            // Sale_total_amount messages
            'sale_total_amount.required' => 'El monto total de la venta es obligatorio.',
            'sale_total_amount.string' => 'El monto total de la venta debe ser un número.',
            'sale_total_amount.min' => 'El monto total de la venta debe ser al menos L. :min',

            // folio_invoice_number messages
            'folio_invoice_number.required' => 'El número de factura es obligatorio.',
            'folio_invoice_number.numeric' => 'El número de factura debe ser un número.',
            'folio_invoice_number.min' => 'El número de factura debe tener al menos :min caracteres',
            'folio_invoice_number.max' => 'El número de factura debe tener como máximo :min caracteres',

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
            'sale_payment_received.required' => 'El pago de la venta es obligatorio.',
            'sale_payment_received.numeric' => 'El pago de la venta debe ser un número.',
            'sale_payment_received.min' => 'El pago de la venta debe ser al menos L. :min',
            'sale_payment_received.gte' => 'El pago de la venta debe ser mayor o igual al valor de la venta.',

            // Sale payment messages
            'sale_payment_type.required' => 'El tipo de pago es obligatorio.',
            'sale_payment_type.numeric' => 'El tipo de pago debe ser EFECTIVO, TARJETA O DEPÓSITO.',
            'sale_payment_type.in' => 'El tipo de pago debe ser mayor o igual a :min',

            // Card last digits messages
            'sale_card_last_digits.required_if' => 'Los últimos 4 digitos son obligatorios.',
            'sale_card_last_digits.string' => 'Los últimos 4 digitos deben contener solo números.',
            'sale_card_last_digits.regex' => 'Los últimos 4 digitos deben contener solo números.',
            'sale_card_last_digits.min' => 'Los últimos 4 digitos deben contener al menos :min caracteres.',
            'sale_card_last_digits.max' => 'Los últimos 4 digitos no puede contener más de :max caracteres.',

            // Card auth number messages
            'sale_card_auth_number.required_if' => 'La autorización es obligatoria.',
            'sale_card_auth_number.string' => 'La autorización debe contener solo letras y caracteres.',
            'sale_card_auth_number.regex' => 'La autorización debe contener solo letras y caracteres.',
            'sale_card_auth_number.min' => 'La autorización debe contener al menos :min caracteres.',
            'sale_card_auth_number.max' => 'La autorización no puede contener más de :max caracteres.',

            // Sale bank operation number messages
            'sale_bank_operation_number.required_if' => 'El Nº de operación es obligatorio.',
            'sale_bank_operation_number.string' => 'El Nº de operación debe contener solo letras y caracteres.',
            'sale_bank_operation_number.regex' => 'El Nº de operación no debe contener símbolos.',
            'sale_bank_operation_number.min' => 'El Nº de operación debe contener al menos :min caracteres.',
            'sale_bank_operation_number.max' => 'El Nº de operación no puede contener más de :max caracteres.',

            // Sale bankcheck info messages
            'sale_bankchek_info.required_if' => 'El Banco / Nº cuenta es obligatorio.',
            'sale_bankchek_info.string' => 'El Banco / Nº cuenta debe contener solo letras, números y signo /.',
            'sale_bankchek_info.regex' => 'El Banco / Nº cuenta no debe contener símbolos distintos a /.',
            'sale_bankchek_info.min' => 'El Banco / Nº cuenta debe contener al menos :min caracteres.',
            'sale_bankchek_info.max' => 'El Banco / Nº cuenta no puede contener más de :max caracteres.',

            // Sale payment change messages
            'sale_payment_change.required' => 'El cambio del pago de la venta es obligatorio.',
            'sale_payment_change.numeric' => 'El cambio del pago de la venta debe ser un número.',
            'sale_payment_change.min' => 'El cambio del pago de la venta debe ser al menos L. :min',

            // Service_id messages
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
