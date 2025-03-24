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
            'show_system_name' => 'nullable|in:0,1',
            'company_name' => 'nullable|string|min:|3:max:25',
            'company_rtn' => 'nullable|string|min:14|max:14',
            'company_phone' => 'nullable|string|min:8|max:8',
            'company_email' => 'nullable|email|max:50',
            'company_address' => 'nullable|string|min:3|max:75',
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

            // Show system name messages
            'show_system_name.in' => 'El campo de mostrar nombre del sistema debe ser 0: Desactivado o 1: Activado.',

            // Company name messages
            'company_name.string' => 'El nombre de la empresa debe contener solo letras, números y símbolos.',
            'company_name.min' => 'El nombre de la empresa debe contener al menos :min caracteres.',
            'company_name.max' => 'El nombre de la empresa no debe exceder los :max caracteres.',

            // Company name RTN messages
            'company_rtn.numeric' => 'El RTN de la empresa debe contener solo números.',
            'company_rtn.min' => 'El RTN de la empresa debe contener al menos :min caracteres.',
            'company_rtn.max' => 'El RTN de la empresa no debe exceder los :max caracteres.',

            // Company name phone messages
            'company_phone.numeric' => 'El teléfono de la empresa debe contener solo números.',
            'company_phone.min' => 'El teléfono de la empresa debe contener al menos :min caracteres.',
            'company_phone.max' => 'El teléfono de la empresa no debe exceder los :max caracteres.',

            // Company name email messages
            'company_email.email' => 'El correo electrónico de la empresa debe ser un correo válido.',
            'company_email.max' => 'El correo electrónico de la empresa no debe exceder los :max caracteres.',

            // Company name address messages
            'company_address.string' => 'La dirección de la empresa debe contener solo letras, números y símbolos.',
            'company_address.min' => 'La dirección de la empresa debe contener al menos :min caracteres.',
            'company_address.max' => 'La dirección de la empresa no debe exceder los :max caracteres.',
        ];
    }
}
