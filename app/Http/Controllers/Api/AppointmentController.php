<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Services\AppointmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    public function __construct(protected AppointmentService $appointmentService) {}

    public function index(): JsonResponse
    {
        $appointments = Appointment::with(['patient', 'doctor', 'specialty'])
            ->when(request('estado'), fn($q, $estado) => $q->where('estado', $estado))
            ->when(request('specialty_id'), fn($q, $id) => $q->where('specialty_id', $id))
            ->when(request('doctor_id'), fn($q, $id) => $q->where('doctor_id', $id))
            ->when(request('fecha'), fn($q, $fecha) => $q->where('fecha', $fecha))
            ->orderByDesc('fecha')
            ->orderByDesc('hora')
            ->paginate(15);

        return response()->json([
            'data' => AppointmentResource::collection($appointments),
            'meta' => [
                'total' => $appointments->total(),
                'pagina_actual' => $appointments->currentPage(),
                'ultima_pagina' => $appointments->lastPage(),
            ],
        ]);
    }

    public function store(StoreAppointmentRequest $request): JsonResponse
    {
        try {
            $appointment = $this->appointmentService->crear(
                $request->validated() + ['estado' => 'pendiente']
            );
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'No se pudo registrar la cita.',
                'errors' => $e->errors(),
            ], 422);
        }

        return response()->json([
            'message' => 'Cita registrada correctamente.',
            'data' => new AppointmentResource($appointment->load('patient', 'doctor', 'specialty')),
        ], 201);
    }

    public function show(Appointment $appointment): JsonResponse
    {
        return response()->json([
            'data' => new AppointmentResource($appointment->load('patient', 'doctor', 'specialty')),
        ]);
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment): JsonResponse
    {
        try {
            $this->appointmentService->actualizar($appointment, $request->validated());
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'No se pudo actualizar la cita.',
                'errors' => $e->errors(),
            ], 422);
        }

        return response()->json([
            'message' => 'Cita actualizada correctamente.',
            'data' => new AppointmentResource($appointment->load('patient', 'doctor', 'specialty')),
        ]);
    }

    public function destroy(Appointment $appointment): JsonResponse
    {
        $appointment->update(['estado' => 'cancelada']);

        return response()->json([
            'message' => 'Cita cancelada correctamente.',
        ]);
    }

    /**
     * Endpoint clave para el formulario en cascada del frontend (Fase 6):
     * GET /api/appointments/horas-ocupadas?doctor_id=X&fecha=YYYY-MM-DD
     */
    public function horasOcupadas(): JsonResponse
    {
        $doctorId = request()->integer('doctor_id');
        $fecha = request('fecha');

        return response()->json([
            'data' => $this->appointmentService->horasOcupadas($doctorId, $fecha),
        ]);
    }
}
