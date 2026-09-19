<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $patient = $this->route('patient');

        $patientId = $patient->id;

        return [
            'user_id' => [
                'required',
                'integer',

                Rule::exists('users', 'id')
                    ->where(function ($query) {
                        $query->where('role', 'paciente');
                    }),

                Rule::unique('patients', 'user_id')
                    ->ignore($patientId),
            ],

            'tipo_documento' => [
                'required',
                'in:CC,TI,CE,PA',
            ],

            'numero_documento' => [
                'required',
                'string',
                'max:20',
                Rule::unique(
                    'patients',
                    'numero_documento'
                )->ignore($patientId),
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
                Rule::unique(
                    'patients',
                    'correo'
                )->ignore($patientId),
            ],

            'direccion' => [
                'nullable',
                'string',
                'max:255',
            ],

            'estado' => [
                'required',
                'in:activo,inactivo',
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

            'numero_documento.unique' =>
            'Ya existe otro paciente registrado con este número de documento.',

            'correo.unique' =>
            'Ya existe otro paciente registrado con este correo.',

            'fecha_nacimiento.before' =>
            'La fecha de nacimiento debe ser anterior a hoy.',

            'estado.required' =>
            'Debes indicar si el paciente está activo o inactivo.',
        ];
    }
}
