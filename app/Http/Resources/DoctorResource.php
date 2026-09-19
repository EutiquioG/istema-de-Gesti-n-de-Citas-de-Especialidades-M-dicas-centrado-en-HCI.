<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'nombre_completo' => $this->nombre_completo,
            'numero_identificacion' => $this->numero_identificacion,
            'registro_profesional' => $this->registro_profesional,
            'telefono' => $this->telefono,
            'correo' => $this->correo,
            'estado' => $this->estado,
            'specialty' => [
                'id' => $this->specialty->id,
                'nombre' => $this->specialty->nombre,
            ],
        ];
    }
}
