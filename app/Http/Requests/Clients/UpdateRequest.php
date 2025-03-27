<?php

namespace App\Http\Requests\Clients;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clientId = $this->route('client')->id;

        return [
            'client_name' => 'required|string|min:3|max:55|regex:/^[^\d]+$/|unique:clients,client_name,' . $clientId . '',
            'client_code' => 'required|string|min:9|max:9|regex:/^[a-zA-Z0-9]+$/|unique:clients,client_code,' . $clientId . '',
            'client_document' => 'required|string|min:13|max:14|regex:/^[0-9]+$/|unique:clients,client_document,' . $clientId . '',
            'client_type' => 'required|string|min:1|max:1|regex:/^[^\d]+$/',
            'client_phone1' => 'required|string|min:8|max:11|regex:/^[0-9]+$/|unique:clients,client_phone1,' . $clientId . '',
            'client_phone2' => 'nullable|string|min:8|max:11|regex:/^[0-9]+$/|unique:clients,client_phone2,' . $clientId . '',
            'client_birthdate' => 'nullable|date:Y-m-d',
            'client_phone_home' => 'nullable|string|min:8|max:8|regex:/^[0-9]+$/',
            'client_actual_job' => 'nullable|string|min:3|max:55|regex:/^[^\d]+$/',
            'client_job_length' => 'nullable|numeric|min:1|',
            'client_phone_work' => 'nullable|string|min:8|max:8|regex:/^[0-9]+$/',
            'client_last_job' => 'nullable|string|min:3|max:55|regex:/^[^\d]+$/',
            'client_email' => 'nullable|email|min:3|max:55|unique:clients,client_email,' . $clientId . '',
            'client_own_business' => 'nullable|numeric|in:0,1',
            'client_exonerated' => 'nullable|numeric|in:0,1',
            'client_status' => 'nullable|numeric|in:0,1',
            'client_address' => 'nullable|string|min:3|max:155',
        ];
    }

    public function messages(): array
    {
        return [
            // Client name messages
            'client_name.required' => 'El nombre del cliente es obligatorio.',
            'client_name.unique' => 'El nombre del cliente ya existe.',
            'client_name.string' => 'El nombre del cliente solo debe contener letras.',
            'client_name.regex' => 'El nombre del cliente no puede contener números ni símbolos.',
            'client_name.min' => 'El nombre del cliente debe contener al menos :min caracteres.',
            'client_name.max' => 'El nombre del cliente no puede exceder :max caracteres.',

            // Client code messages
            'client_code.required' => 'El código del cliente es obligatorio.',
            'client_code.unique' => 'El código del cliente ya existe.',
            'client_code.string' => 'El código del cliente solo debe contener letras y/o números.',
            'client_code.regex' => 'El código del cliente no puede contener símbolos.',
            'client_code.min' => 'El código del cliente debe contener al menos :min letras.',
            'client_code.max' => 'El código del cliente no puede exceder :max letras.',

            // Client document messages
            'client_document.required' => 'El doc. del cliente es obligatorio.',
            'client_document.unique' => 'El doc. del cliente ya existe.',
            'client_document.string' => 'El doc. del cliente solo debe contener números.',
            'client_document.regex' => 'El doc. del cliente no puede contener letras ni símbolos.',
            'client_document.min' => 'El doc. del cliente debe contener al menos :min caracteres.',
            'client_document.max' => 'El doc. del cliente no puede exceder :max caracteres.',

            // Client type messages
            'client_type.required' => 'El tipo de cliente es obligatorio.',
            'client_type.string' => 'El tipo de cliente solo debe contener letras.',
            'client_type.regex' => 'El tipo de cliente no puede contener números ni símbolos.',
            'client_type.min' => 'El tipo de cliente debe contener al menos :min caracter.',
            'client_type.max' => 'El tipo de cliente no puede exceder :max caracter.',

            // Client phone1 messages
            'client_phone1.required' => 'El Nº teléfono principal es obligatorio.',
            'client_phone1.unique' => 'El Nº teléfono principal ya existe.',
            'client_phone1.string' => 'El Nº teléfono principal solo debe contener números.',
            'client_phone1.regex' => 'El Nº teléfono principal no puede contener letras ni símbolos.',
            'client_phone1.min' => 'El Nº teléfono principal debe contener al menos :min letras.',
            'client_phone1.max' => 'El Nº teléfono principal no puede exceder :max caracteres.',

            // Client phone2 messages
            'client_phone2.unique' => 'El Nº teléfono secundario ya existe.',
            'client_phone2.string' => 'El Nº teléfono secundario solo debe contener números.',
            'client_phone2.regex' => 'El Nº teléfono secundario no puede contener letras ni símbolos.',
            'client_phone2.min' => 'El Nº teléfono secundario debe contener al menos :min caracteres.',
            'client_phone2.max' => 'El Nº teléfono secundario no puede exceder :max caracteres.',

            // Client birthdate messages
            'client_birthdate.date' => 'El formato de fecha de cumpleaños debe ser Y-m-d.',

            // Client phone home messages
            'client_phone_home.string' => 'El Nº teléfono de casa solo debe contener números.',
            'client_phone_home.regex' => 'El Nº teléfono de casa no puede contener letras ni símbolos.',
            'client_phone_home.min' => 'El Nº teléfono de casa debe contener al menos :min letras.',
            'client_phone_home.max' => 'El Nº teléfono de casa no puede exceder :max caracteres.',

            // Client actual job messages
            'client_actual_job.regex' => 'El trabajo actual no puede contener números ni símbolos.',
            'client_actual_job.min' => 'El trabajo actual debe contener al menos :min caracteres.',
            'client_actual_job.max' => 'El trabajo actual no puede exceder :max caracteres.',

            // Client job lenght messages
            'client_job_length.numeric' => 'La antiguedad laboral debe ser numérico.',
            'client_job_length.min' => 'La antiguedad laboral debe como mínimo :min mes.',

            // Client phone work messages
            'client_phone_work.string' => 'El Nº teléfono del trabajo solo debe contener números.',
            'client_phone_work.regex' => 'El Nº teléfono del trabajo no puede contener letras ni símbolos.',
            'client_phone_work.min' => 'El Nº teléfono del trabajo debe contener al menos :min letras.',
            'client_phone_work.max' => 'El Nº teléfono del trabajo no puede exceder :max caracteres.',

            // Client last job messages
            'client_last_job.regex' => 'El trabajo anterior no puede contener números ni símbolos.',
            'client_last_job.min' => 'El trabajo anterior debe contener al menos :min caracteres.',
            'client_last_job.max' => 'El trabajo anterior no puede exceder :max caracteres.',

            // Client own business messages
            'client_own_business.numeric' => 'Si el cliente tiene negocios, debe ser numérico.',
            'client_own_business.in' => 'Si el cliente tiene negocios solo puede ser 0: Sin negocios o 1: Con negocios.',

            // Client email messages
            'client_email.unique' => 'El email ya existe.',
            'client_email.email' => 'El email debe ser un email válido.',
            'client_email.min' => 'El email debe contener al menos :min letras.',
            'client_email.max' => 'El email no puede exceder :max caracteres.',

            // Client exonerated messages
            'client_exonerated.numeric' => 'El exonerado debe ser numérico.',
            'client_exonerated.in' => 'El exonerado solo puede ser 0: Sin exonerar o 1: Exonerado.',

            // Client status messages
            'client_status.numeric' => 'El estado debe ser numérico.',
            'client_status.in' => 'El estado solo puede ser 0: Inactivo o 1: Activo.',

            // Client address messages
            'client_address.string' => 'El domicilio del cliente solo debe contener letras y números.',
            'client_address.min' => 'El domicilio del cliente debe contener al menos :min caracteres.',
            'client_address.max' => 'El domicilio del cliente no puede exceder :max caracteres.',
        ];
    }
}
