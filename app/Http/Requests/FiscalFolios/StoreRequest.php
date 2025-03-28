<?php

namespace App\Http\Requests\FiscalFolios;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Models\FiscalFolio;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'folio_authorized_range_start' => 'required|string|regex:/^[0-9-]+$/|min:19|max:19|unique:fiscal_folios',
            'folio_authorized_range_end' => 'required|string|regex:/^[0-9-]+$/|min:19|max:19|unique:fiscal_folios',
            'folio_total_invoices' => 'required|numeric|min:1',
            'folio_total_invoices_available' => 'required|numeric|min:0',
            'folio_authorized_emission_date' => 'required|date:Y-m-d',
            'folio_validation_status' => 'required|in:0,1',
            'folio_status' => 'required|in:0,1',
        ];
    }

    /**
     * Agregar una validación adicional después de las reglas estándar para validar que no hayan rangos que se solapen entre sí
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $start = $this->input('folio_authorized_range_start');
            $end = $this->input('folio_authorized_range_end');

            $exists = FiscalFolio::where(function ($query) use ($start, $end) {
                $query->where('folio_authorized_range_start', '<=', $end)
                    ->where('folio_authorized_range_end', '>=', $start);
            })->exists();

            if ($exists) {
                $validator->errors()->add('folio_authorized_range_start', 'El rango inicial ingresado se solapa con un rango existente.');
                $validator->errors()->add('folio_authorized_range_end', 'El rango final ingresado se solapa con un rango existente.');
            }
        });
    }

    public function messages(): array
    {
        return [
            // Folio autorized range start messages
            'folio_authorized_range_start.required' => 'El rango autorizado inicial es obligatorio.',
            'folio_authorized_range_start.string' => 'El rango autorizado inicial es inválido.',
            'folio_authorized_range_start.regex' => 'El rango autorizado inicial solo debe contener números y guiones.',
            'folio_authorized_range_start.min' => 'El rango autorizado inicial debe contener al menos 19 caracteres.',
            'folio_authorized_range_start.max' => 'El rango autorizado inicial debe contener como máximo 19 caracteres.',
            'folio_authorized_range_start.unique' => 'El rango autorizado inicial ya existe.',

            // Folio autorized range end messages
            'folio_authorized_range_end.required' => 'El rango autorizado final es obligatorio.',
            'folio_authorized_range_end.string' => 'El rango autorizado final es inválido.',
            'folio_authorized_range_end.regex' => 'El rango autorizado final solo debe contener números y guiones.',
            'folio_authorized_range_end.min' => 'El rango autorizado final debe contener al menos 19 caracteres.',
            'folio_authorized_range_end.max' => 'El rango autorizado final debe contener como máximo 19 caracteres.',
            'folio_authorized_range_end.unique' => 'El rango autorizado final ya existe.',

            // Folio total invoices messagess
            'folio_total_invoices.required' => 'El número total de facturas autorizadas es obligatorio.',
            'folio_total_invoices.numeric' => 'El número total de facturas autorizadas debe contener solo números.',
            'folio_total_invoices.min' => 'El número total de facturas autorizadas como mínimo es :min.',

            // Folio total invoices available messagess
            'folio_total_invoices_available.required' => 'El número total de facturas disponibles es obligatorio.',
            'folio_total_invoices_available.numeric' => 'El número total de facturas disponibles debe contener solo números.',
            'folio_total_invoices_available.min' => 'El número total de facturas disponibles como mínimo es :min.',

            // Folio autorized emission date messages
            'folio_authorized_emission_date.required' => 'La fecha limite de emisión es obligatoria.',
            'folio_authorized_emission_date.date' => 'El formato de fecha de la fecha limite de emisión debe ser Y-m-d.',

            // Folio validation status messages
            'folio_validation_status.required' => 'El estado de validez del folio es obligatorio.',
            'folio_validation_status.in' => 'El estado de validez del folio debe ser 0: Vencido o 1: Válido.',

            // Folio status messages
            'folio_status.required' => 'El estado del folio es obligatorio.',
            'folio_status.in' => 'El estado del folio debe ser 0: Sin usar o 1: En uso.'
        ];
    }
}
