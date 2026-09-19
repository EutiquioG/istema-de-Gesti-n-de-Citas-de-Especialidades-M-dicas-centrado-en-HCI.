<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Services\AppointmentService;
use Illuminate\Http\JsonResponse;

class DoctorController extends Controller
{
    /**
     * Listado de médicos.
     */
    public function index(): JsonResponse
    {
        $doctors = Doctor::with('specialty')
            ->when(
                request('specialty_id'),
                fn($q, $id) =>
                $q->where('specialty_id', $id)
            )
            ->when(
                request('estado'),
                fn($q, $estado) =>
                $q->where('estado', $estado)
            )
            ->orderBy('apellidos')
            ->paginate(15);

        return response()->json([
            'data' => DoctorResource::collection($doctors),
            'meta' => [
                'total' => $doctors->total(),
                'pagina_actual' => $doctors->currentPage(),
                'ultima_pagina' => $doctors->lastPage(),
            ],
        ]);
    }

    /**
     * Registrar médico.
     */
    public function store(StoreDoctorRequest $request): JsonResponse
    {
        $doctor = Doctor::create(
            $request->validated() + [
                'estado' => 'activo'
            ]
        );

        return response()->json([
            'message' => 'Médico registrado correctamente.',
            'data' => new DoctorResource(
                $doctor->load('specialty')
            ),
        ], 201);
    }

    /**
     * Mostrar médico.
     */
    public function show(Doctor $doctor): JsonResponse
    {
        return response()->json([
            'data' => new DoctorResource(
                $doctor->load('specialty')
            ),
        ]);
    }

    /**
     * Actualizar médico.
     */
    public function update(
        UpdateDoctorRequest $request,
        Doctor $doctor
    ): JsonResponse {

        $doctor->update(
            $request->validated()
        );

        return response()->json([
            'message' => 'Médico actualizado correctamente.',
            'data' => new DoctorResource(
                $doctor->load('specialty')
            ),
        ]);
    }

    /**
     * Eliminar médico.
     */
    public function destroy(Doctor $doctor): JsonResponse
    {
        if ($doctor->appointments()->exists()) {

            return response()->json([
                'message' =>
                'No se puede eliminar el médico porque tiene citas registradas.',
            ], 409);
        }

        $doctor->delete();

        return response()->json([
            'message' =>
            'Médico eliminado correctamente.',
        ]);
    }

    /**
     * Obtiene los médicos activos
     * pertenecientes a una especialidad.
     *
     * GET:
     * /api/doctors/by-specialty/{specialty}
     */
    public function porEspecialidad(
        int $specialty,
        AppointmentService $service
    ): JsonResponse {

        $medicos = $service->medicosPorEspecialidad(
            $specialty
        );

        return response()->json([
            'data' => $medicos,
        ]);
    }
}
