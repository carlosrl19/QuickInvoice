<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'logo_company' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'system_icon' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'show_system_name' => 'required|in:0,1',
            'company_name' => 'required|string|min:3|max:25',
            'company_cai' => 'required|string|min:37|max:37',
            'company_rtn' => 'required|string|min:14|max:14',
            'company_phone' => 'required|string|min:9|max:9',
            'company_email' => 'required|email|max:50',
            'company_address' => 'required|string|min:3|max:75',
            'company_short_address' => 'required|string|min:3|max:35',
        ];
    }

    public function messages(): array
    {
        return [
            // Logo Company messages
            'logo_company.image' => 'El logo de la empresa debe ser una imagen.',
            'logo_company.mimes' => 'El logo de la empresa debe ser un archivo de tipo: jpeg, png, jpg, webp, svg.',
            'logo_company.max' => 'El logo de la empresa no debe pesar más de 2MB.',

            // System Icon messages
            'system_icon.image' => 'El ícono del sistema debe ser una imagen.',
            'system_icon.mimes' => 'El ícono del sistema debe ser un archivo de tipo: jpeg, png, jpg, webp, svg.',
            'system_icon.max' => 'El ícono del sistema no debe pesar más de 2MB.',

            'show_system_name.required' => 'Mostrar/ocultar nombre del sistema es obligatorio.',
            'show_system_name.in' => 'Mostrar/ocultar nombre del sistema debe ser 0: Desactivado o 1: Activado.',

            // Company name messages
            'company_name.required' => 'El nombre de la empresa es obligatorio.',
            'company_name.string' => 'El nombre de la empresa debe contener solo letras, números y símbolos.',
            'company_name.min' => 'El nombre de la empresa debe contener al menos :min caracteres.',
            'company_name.max' => 'El nombre de la empresa no debe exceder los :max caracteres.',

            // Company CAI messages
            'company_cai.required' => 'El CAI de la empresa es obligatorio.',
            'company_cai.string' => 'El CAI de la empresa debe contener solo letras, números y símbolos.',
            'company_cai.min' => 'El CAI de la empresa debe contener al menos :min caracteres.',
            'company_cai.max' => 'El CAI de la empresa no debe exceder los :max caracteres.',

            // Company RTN messages
            'company_rtn.required' => 'El RTN de la empresa es obligatorio.',
            'company_rtn.string' => 'El RTN de la empresa debe contener solo números.',
            'company_rtn.min' => 'El RTN de la empresa debe contener al menos :min caracteres.',
            'company_rtn.max' => 'El RTN de la empresa no debe exceder los :max caracteres.',

            // Company phone messages
            'company_phone.required' => 'El teléfono de la empresa es obligatorio.',
            'company_phone.string' => 'El teléfono de la empresa debe contener solo números.',
            'company_phone.min' => 'El teléfono de la empresa debe contener al menos :min caracteres.',
            'company_phone.max' => 'El teléfono de la empresa no debe exceder los :max caracteres.',

            // Company email messages
            'company_email.required' => 'El correo electrónico de la empresa es obligatorio.',
            'company_email.email' => 'El correo electrónico de la empresa debe ser un correo válido.',
            'company_email.max' => 'El correo electrónico de la empresa no debe exceder los :max caracteres.',

            // Company address messages
            'company_address.required' => 'La dirección de la empresa es obligatoria.',
            'company_address.string' => 'La dirección de la empresa debe contener solo letras, números y símbolos.',
            'company_address.min' => 'La dirección de la empresa debe contener al menos :min caracteres.',
            'company_address.max' => 'La dirección de la empresa no debe exceder los :max caracteres.',

            // Company short address messages
            'company_short_address.required' => 'La dirección corta de la empresa es obligatoria.',
            'company_short_address.string' => 'La dirección corta de la empresa debe contener solo letras, números y símbolos.',
            'company_short_address.min' => 'La dirección corta de la empresa debe contener al menos :min caracteres.',
            'company_short_address.max' => 'La dirección corta de la empresa no debe exceder los :max caracteres.',
        ];
    }
}
