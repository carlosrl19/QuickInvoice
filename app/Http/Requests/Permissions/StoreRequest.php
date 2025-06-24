<?php

namespace App\Http\Requests\Permissions;

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
            'name' => 'required|string|min:3|max:55|regex:/^[^\d]+$/|unique:permissions',
            'permission_description' => 'required|string|min:3|max:255',
        ];
    }

    public function messages()
    {
        return [
            // Permission name messages
            'name.required' => 'El nombre del permiso es obligatorio.',
            'name.unique' => 'El nombre del permiso ya existe.',
            'name.string' => 'El nombre del permiso solo debe contener letras.',
            'name.regex' => 'El nombre del permiso no puede contener números ni símbolos.',
            'name.min' => 'El nombre del permiso debe contener al menos 3 letras.',
            'name.max' => 'El nombre del permiso no puede exceder 55 letras.',

            // Permission description messages
            'permission_description.required' => 'La descripción del permiso son obligatorios.',
            'permission_description.string' => 'La descripción del permiso solo deben contener letras, números y/o símbolos.',
            'permission_description.min' => 'La descripción del permiso debe tener al menos 3 caracteres.',
            'permission_description.max' => 'La descripción del permiso no puede tener más de 255 caracteres.',
        ];
    }
}
