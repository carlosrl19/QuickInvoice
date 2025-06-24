<?php

namespace App\Http\Requests\Roles;

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
            'name' => 'required|string|min:3|max:55|regex:/^[^\d]+$/|unique:roles',
            'role_description' => 'required|string|min:3|max:255',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ];
    }

    public function messages()
    {
        return [
            // Rol name messages
            'name.required' => 'El nombre del role es obligatorio.',
            'name.unique' => 'El nombre del role ya existe.',
            'name.string' => 'El nombre del role solo debe contener letras.',
            'name.regex' => 'El nombre del role no puede contener números ni símbolos.',
            'name.min' => 'El nombre del role debe contener al menos 3 letras.',
            'name.max' => 'El nombre del role no puede exceder 55 letras.',

            // Role description messages
            'role_description.required' => 'La descripción del role son obligatorios.',
            'role_description.string' => 'La descripción del role solo deben contener letras, números y/o símbolos.',
            'role_description.min' => 'La descripción del role debe tener al menos 3 caracteres.',
            'role_description.max' => 'La descripción del role no puede tener más de 255 caracteres.',

            // Permissions messages
            'permissions.required' => 'Debe seleccionar al menos un permiso para el role.',
            'permissions.array' => 'Los permisos se deben enviar con un array.',
            'permissions.exists' => 'Alguno de los permisos seleccionado no existe en la base de datos.'
        ];
    }
}
