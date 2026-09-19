<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSpecialtyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $specialtyId = $this->route('specialty')->id;

        return [
            'nombre' => ['required', 'string', 'max:100', Rule::unique('specialties', 'nombre')->ignore($specialtyId)],
            'descripcion' => 'nullable|string|max:255',
            'estado' => 'required|in:activo,inactivo',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la especialidad es obligatorio.',
            'nombre.unique' => 'Ya existe otra especialidad con este nombre.',
        ];
    }
}
