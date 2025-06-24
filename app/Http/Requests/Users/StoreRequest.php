<?php

namespace App\Http\Requests\Users;

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
            'name' => 'required|string|min:3|max:55|regex:/^[^\d]+$/|unique:users',
            'email' => 'required|string|max:55|unique:users',
            'profile_photo' => 'required', 
            'password' => 'required|min:8',
            'role' => 'required|exists:roles,name', 
        ];
    }

    public function messages()
    {
        return [
            // User name messages
            'name.required' => 'El nombre del usuario es obligatorio.',
            'name.unique' => 'El nombre del usuario ya existe.',
            'name.string' => 'El nombre del usuario solo debe contener letras.',
            'name.regex' => 'El nombre del usuario no puede contener números ni símbolos.',
            'name.min' => 'El nombre del usuario debe contener al menos 3 letras.',
            'name.max' => 'El nombre del usuario no puede exceder 55 letras.',

            // User email messages
            'email.required' => 'El email del usuario es obligatorio.',
            'email.unique' => 'El email del usuario ya existe.',
            'email.string' => 'El email del usuario solo debe contener números y letras.',
            'email.regex' => 'El email del usuario no puede contener símbolos ni espacios.',
            'email.max' => 'El email del usuario no puede exceder 55 letras.',

            // User profile image messages
            'profile_photo.required' => 'La imagen de perfil del usuario es obligatoria.',

            // User password messages
            'password.required' => 'La contraseña del usuario es obligatorio.',
            'password.min' => 'La contraseña del usuario debe contener al menos 8 letras.',

            // Role messages
            'role.required' => 'El rol del usuario es obligatorio.',
            'role.exists' => 'El rol seleccionado no existe en la base de datos.'
        ];
    }
}
