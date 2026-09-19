<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fecha' => $this->fecha->format('Y-m-d'),
            'hora' => substr($this->hora, 0, 5),
            'motivo_consulta' => $this->motivo_consulta,
            'estado' => $this->estado,
            'paciente' => [
                'id' => $this->patient->id,
                'nombre_completo' => $this->patient->nombre_completo,
            ],
            'medico' => [
                'id' => $this->doctor->id,
                'nombre_completo' => $this->doctor->nombre_completo,
            ],
            'especialidad' => [
                'id' => $this->specialty->id,
                'nombre' => $this->specialty->nombre,
            ],
            'created_at' => $this->created_at->format('Y-m-d H:i'),
        ];
    }
}
