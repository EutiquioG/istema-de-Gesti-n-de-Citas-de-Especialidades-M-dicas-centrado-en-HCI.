<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $user = auth()->user();

        return [
            /*
            |--------------------------------------------------------------------------
            | PACIENTE
            |--------------------------------------------------------------------------
            | Paciente:
            |   No selecciona paciente.
            |   El sistema lo obtiene automáticamente.
            |
            | Administrador:
            |   Debe seleccionar el paciente.
            */
            'patient_id' => [
                'nullable',
                Rule::requiredIf(
                    $user && $user->role === 'admin'
                ),
                'exists:patients,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | ESPECIALIDAD
            |--------------------------------------------------------------------------
            */
            'specialty_id' => [
                'required',
                'exists:specialties,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | MÉDICO
            |--------------------------------------------------------------------------
            */
            'doctor_id' => [
                'required',
                'exists:doctors,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | FECHA
            |--------------------------------------------------------------------------
            */
            'fecha' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            /*
            |--------------------------------------------------------------------------
            | HORA
            |--------------------------------------------------------------------------
            */
            'hora' => [
                'required',
                'date_format:H:i',
            ],

            /*
            |--------------------------------------------------------------------------
            | MOTIVO DE CONSULTA
            |--------------------------------------------------------------------------
            */
            'motivo_consulta' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' =>
            'Debes seleccionar un paciente.',

            'patient_id.exists' =>
            'El paciente seleccionado no es válido.',

            'specialty_id.required' =>
            'Debes seleccionar una especialidad.',

            'specialty_id.exists' =>
            'La especialidad seleccionada no es válida.',

            'doctor_id.required' =>
            'Debes seleccionar un médico.',

            'doctor_id.exists' =>
            'El médico seleccionado no es válido.',

            'fecha.required' =>
            'Debes seleccionar una fecha.',

            'fecha.date' =>
            'La fecha seleccionada no es válida.',

            'fecha.after_or_equal' =>
            'La fecha de la cita debe ser hoy o una fecha posterior.',

            'hora.required' =>
            'Debes seleccionar una hora.',

            'hora.date_format' =>
            'La hora seleccionada no tiene un formato válido.',

            'motivo_consulta.required' =>
            'Debes indicar el motivo de la consulta.',

            'motivo_consulta.max' =>
            'El motivo de consulta no puede superar los 255 caracteres.',
        ];
    }
}
