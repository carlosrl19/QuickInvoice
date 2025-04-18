<?php

namespace App\Http\Requests\Banks;

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
            "account_name" => "required|string|min:3|max:55",
            "bank_name" => "required|string|min:3|max:55",
            "bank_account_number" => "required|string|min:16|max:16|unique:banks,bank_account_number",
        ];
    }

    public function messages(): array
    {
        return [
            // Account name messages
            "account_name.required" => "El nombre del titular de la cuenta es obligatorio",
            "account_name.string" => "El nombre del titular de la cuenta debe ser una cadena de texto",
            "account_name.min" => "El nombre del titular de la cuenta debe tener al menos :min caracteres",
            "account_name.max" => "El nombre del titular de la cuenta no debe superar los :max caracteres",

            // Bank name messages
            "bank_name.required" => "El nombre del banco es obligatorio",
            "bank_name.string" => "El nombre del banco debe ser una cadena de texto",
            "bank_name.min" => "El nombre del banco debe tener al menos :min caracteres",
            "bank_name.max" => "El nombre del banco no debe superar los :max caracteres",

            // Bank account number messages
            "bank_account_number.required" => "El número de cuenta bancaria es obligatorio",
            "bank_account_number.string" => "El número de cuenta bancaria debe ser una cadena de texto",
            "bank_account_number.min" => "El número de cuenta bancaria debe tener al menos :min caracteres",
            "bank_account_number.max" => "El número de cuenta bancaria no debe superar los :max caracteres",
            "bank_account_number.unique" => "El número de cuenta bancaria ya existe",

        ];
    }
}
