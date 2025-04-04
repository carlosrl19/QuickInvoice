<?php

namespace App\Http\Requests\Quotes;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'quote_status' => 'required|integer|in:0,1,2,3,4',
            'quote_answer' => 'nullable|string|min:3|max:75',
        ];
    }

    public function messages(): array
    {
        return [
            // Quote status messages
            'quote_status.required' => 'El estado de la cotización es obligatoria.',
            'quote_status.integer' => 'El estado de la cotización solo debe contener números.',
            'quote_status.in' => 'El estado de la cotización debe ser: 0: En proceso, 1: Aceptada, 2: Rechazada, 3: Sin respuesta, 4: Vencida.',

            // Quote answer messages
            'quote_answer.string' => 'Las anotaciones de la cotización solo debe contener letras, números y símbolos.',
            'quote_answer.min' => 'Las anotaciones de la cotización debe contener al menos :min caracteres.',
            'quote_answer.max' => 'Las anotaciones de la cotización debe contener como máximo :min caracteres.',
        ];
    }
}
