<?php

namespace App\Http\Requests\Services;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $serviceId = $this->route('service')->id;

        return [
            'service_name' => 'required|string|min:3|max:55|regex:/^[^\d]+$/|unique:services,service_name,' . $serviceId . '',
            'service_nomenclature' => 'required|string|min:2|max:6|regex:/^[^\d]+$/|unique:services,service_nomenclature,' . $serviceId . '',
            'service_type' => 'required|numeric|in:0,1',
            'service_description' => 'nullable|string|min:3|max:155',
        ];
    }

    public function messages(): array
    {
        return [
            // Service name messages
            'service_name.required' => 'El nombre del servicio es obligatorio.',
            'service_name.unique' => 'El nombre del servicio ya existe.',
            'service_name.string' => 'El nombre del servicio solo debe contener letras.',
            'service_name.regex' => 'El nombre del servicio no puede contener números ni símbolos.',
            'service_name.min' => 'El nombre del servicio debe contener al menos :min caracteres.',
            'service_name.max' => 'El nombre del servicio no puede exceder :max caracteres.',

            // Service nomenclature messages
            'service_nomenclature.required' => 'La nomenclatura del servicio obligatoria.',
            'service_nomenclature.unique' => 'La nomenclatura del servicio ya existe.',
            'service_nomenclature.string' => 'La nomenclatura del servicio solo debe contener letras.',
            'service_nomenclature.regex' => 'La nomenclatura del servicio no puede contener números ni símbolos.',
            'service_nomenclature.min' => 'La nomenclatura del servicio debe contener al menos :min caracteres.',
            'service_nomenclature.max' => 'La nomenclatura del servicio no puede exceder :max caracteres.',
            
            // Service tax messages
            'service_type.required' => 'El impuesto del servicio es obligatorio.',
            'service_type.numeric' => 'El impuesto del servicio solo debe contener números.',
            'service_type.regex' => 'El impuesto del servicio no puede contener letras ni símbolos.',
            'service_type.in' => 'El impuesto del servicio debe ser: 0: Exento de ISV, 1: ISV incluido.',

            // Service description messages
            'service_description.string' => 'La descripción del servicio solo debe contener letras y números.',
            'service_description.min' => 'La descripción del servicio debe contener al menos :min caracteres.',
            'service_description.max' => 'La descripción del servicio no puede exceder :max caracteres.',
        ];
    }
}
