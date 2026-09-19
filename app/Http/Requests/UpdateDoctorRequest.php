<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $doctorId = $this->route('doctor')->id;

        return [
            'specialty_id' => 'required|exists:specialties,id',
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'numero_identificacion' => ['required', 'string', 'max:20', Rule::unique('doctors', 'numero_identificacion')->ignore($doctorId)],
            'registro_profesional' => ['required', 'string', 'max:50', Rule::unique('doctors', 'registro_profesional')->ignore($doctorId)],
            'telefono' => 'required|string|max:20',
            'correo' => ['required', 'email', 'max:150', Rule::unique('doctors', 'correo')->ignore($doctorId)],
            'estado' => 'required|in:activo,inactivo',
        ];
    }

    public function messages(): array
    {
        return [
            'specialty_id.required' => 'Debes seleccionar una especialidad.',
            'numero_identificacion.unique' => 'Ya existe otro médico con este número de identificación.',
            'registro_profesional.unique' => 'Ya existe otro médico con este número de registro profesional.',
            'correo.unique' => 'Ya existe otro médico registrado con este correo.',
        ];
    }
}
