<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')
                    ->where(function ($query) {
                        $query->where('role', 'paciente');
                    }),
                Rule::unique('patients', 'user_id'),
            ],

            'tipo_documento' => [
                'required',
                'in:CC,TI,CE,PA',
            ],

            'numero_documento' => [
                'required',
                'string',
                'max:20',
                'unique:patients,numero_documento',
            ],

            'nombres' => [
                'required',
                'string',
                'max:100',
            ],

            'apellidos' => [
                'required',
                'string',
                'max:100',
            ],

            'fecha_nacimiento' => [
                'required',
                'date',
                'before:today',
            ],

            'telefono' => [
                'required',
                'string',
                'max:20',
            ],

            'correo' => [
                'required',
                'email',
                'max:150',
                'unique:patients,correo',
            ],

            'direccion' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' =>
            'Debes seleccionar la cuenta de usuario del paciente.',

            'user_id.exists' =>
            'El usuario seleccionado no es válido o no tiene el rol de paciente.',

            'user_id.unique' =>
            'Este usuario ya está asociado a otro paciente.',

            'tipo_documento.required' =>
            'Debes seleccionar el tipo de documento.',

            'numero_documento.required' =>
            'El número de documento es obligatorio.',

            'numero_documento.unique' =>
            'Ya existe un paciente registrado con este número de documento.',

            'nombres.required' =>
            'El nombre del paciente es obligatorio.',

            'apellidos.required' =>
            'El apellido del paciente es obligatorio.',

            'fecha_nacimiento.required' =>
            'La fecha de nacimiento es obligatoria.',

            'fecha_nacimiento.before' =>
            'La fecha de nacimiento debe ser anterior a hoy.',

            'telefono.required' =>
            'El teléfono es obligatorio.',

            'correo.required' =>
            'El correo electrónico es obligatorio.',

            'correo.email' =>
            'Ingresa un correo electrónico válido.',

            'correo.unique' =>
            'Ya existe un paciente registrado con este correo.',
        ];
    }
}
