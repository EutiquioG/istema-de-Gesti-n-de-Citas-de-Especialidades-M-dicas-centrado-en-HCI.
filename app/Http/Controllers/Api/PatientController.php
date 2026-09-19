<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use Illuminate\Http\JsonResponse;

class PatientController extends Controller
{
    public function index(): JsonResponse
    {
        $patients = Patient::query()
            ->when(request('estado'), fn($q, $estado) => $q->where('estado', $estado))
            ->when(request('buscar'), function ($q, $buscar) {
                $q->where('nombres', 'like', "%{$buscar}%")
                    ->orWhere('apellidos', 'like', "%{$buscar}%");
            })
            ->orderBy('apellidos')
            ->paginate(15);

        return response()->json([
            'data' => PatientResource::collection($patients),
            'meta' => [
                'total' => $patients->total(),
                'pagina_actual' => $patients->currentPage(),
                'ultima_pagina' => $patients->lastPage(),
            ],
        ]);
    }

    public function store(StorePatientRequest $request): JsonResponse
    {
        $patient = Patient::create($request->validated() + ['estado' => 'activo']);

        return response()->json([
            'message' => 'Paciente registrado correctamente.',
            'data' => new PatientResource($patient),
        ], 201);
    }

    public function show(Patient $patient): JsonResponse
    {
        return response()->json([
            'data' => new PatientResource($patient),
        ]);
    }

    public function update(UpdatePatientRequest $request, Patient $patient): JsonResponse
    {
        $patient->update($request->validated());

        return response()->json([
            'message' => 'Paciente actualizado correctamente.',
            'data' => new PatientResource($patient),
        ]);
    }

    public function destroy(Patient $patient): JsonResponse
    {
        if ($patient->appointments()->exists()) {
            return response()->json([
                'message' => 'No se puede eliminar el paciente porque tiene citas registradas.',
            ], 409);
        }

        $patient->delete();

        return response()->json([
            'message' => 'Paciente eliminado correctamente.',
        ]);
    }
}
