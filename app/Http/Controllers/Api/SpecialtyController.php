<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSpecialtyRequest;
use App\Http\Requests\UpdateSpecialtyRequest;
use App\Http\Resources\SpecialtyResource;
use App\Models\Specialty;
use Illuminate\Http\JsonResponse;

class SpecialtyController extends Controller
{
    public function index(): JsonResponse
    {
        $specialties = Specialty::withCount('doctors')
            ->when(request('estado'), fn($q, $estado) => $q->where('estado', $estado))
            ->orderBy('nombre')
            ->get();

        return response()->json([
            'data' => SpecialtyResource::collection($specialties),
        ]);
    }

    public function store(StoreSpecialtyRequest $request): JsonResponse
    {
        $specialty = Specialty::create($request->validated() + ['estado' => 'activo']);

        return response()->json([
            'message' => 'Especialidad creada correctamente.',
            'data' => new SpecialtyResource($specialty),
        ], 201);
    }

    public function show(Specialty $specialty): JsonResponse
    {
        return response()->json([
            'data' => new SpecialtyResource($specialty->loadCount('doctors')),
        ]);
    }

    public function update(UpdateSpecialtyRequest $request, Specialty $specialty): JsonResponse
    {
        $specialty->update($request->validated());

        return response()->json([
            'message' => 'Especialidad actualizada correctamente.',
            'data' => new SpecialtyResource($specialty),
        ]);
    }

    public function destroy(Specialty $specialty): JsonResponse
    {
        if ($specialty->doctors()->exists()) {
            return response()->json([
                'message' => 'No se puede eliminar la especialidad porque tiene médicos asignados.',
            ], 409);
        }

        $specialty->delete();

        return response()->json([
            'message' => 'Especialidad eliminada correctamente.',
        ]);
    }
}
