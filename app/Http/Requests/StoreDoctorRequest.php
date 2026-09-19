<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'specialty_id' => 'required|exists:specialties,id',
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'numero_identificacion' => 'required|string|max:20|unique:doctors,numero_identificacion',
            'registro_profesional' => 'required|string|max:50|unique:doctors,registro_profesional',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|max:150|unique:doctors,correo',
        ];
    }

    public function messages(): array
    {
        return [
            'specialty_id.required' => 'Debes seleccionar una especialidad.',
            'specialty_id.exists' => 'La especialidad seleccionada no es válida.',
            'numero_identificacion.unique' => 'Ya existe un médico con este número de identificación.',
            'registro_profesional.unique' => 'Ya existe un médico con este número de registro profesional.',
            'correo.unique' => 'Ya existe un médico registrado con este correo.',
        ];
    }
}
