<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAppointmentRequest extends FormRequest
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
            | Solo es obligatorio cuando el usuario es administrador.
            |
            | Si es paciente, el controlador obtiene automáticamente
            | el patient_id desde el usuario autenticado.
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
            | MOTIVO
            |--------------------------------------------------------------------------
            */
            'motivo_consulta' => [
                'required',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | ESTADO
            |--------------------------------------------------------------------------
            */
            'estado' => [
                'required',
                'in:pendiente,confirmada,atendida,cancelada',
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

            'hora.required' =>
            'Debes seleccionar una hora.',

            'hora.date_format' =>
            'La hora seleccionada no tiene un formato válido.',

            'motivo_consulta.required' =>
            'Debes indicar el motivo de la consulta.',

            'motivo_consulta.max' =>
            'El motivo de consulta no puede superar los 255 caracteres.',

            'estado.required' =>
            'Debes indicar el estado de la cita.',

            'estado.in' =>
            'El estado seleccionado no es válido.',
        ];
    }
}
