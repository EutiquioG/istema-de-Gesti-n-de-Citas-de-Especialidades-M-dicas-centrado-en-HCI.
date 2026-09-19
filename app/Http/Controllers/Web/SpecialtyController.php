<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSpecialtyRequest;
use App\Http\Requests\UpdateSpecialtyRequest;
use App\Models\Specialty;

class SpecialtyController extends Controller
{
    public function index()
    {
        $specialties = Specialty::withCount('doctors')
            ->orderBy('nombre')
            ->paginate(10);

        return view('specialties.index', compact('specialties'));
    }

    public function create()
    {
        return view('specialties.create');
    }

    public function store(StoreSpecialtyRequest $request)
    {
        Specialty::create(
            $request->validated() + [
                'estado' => 'activo',
            ]
        );

        return redirect()
            ->route('specialties.index')
            ->with('success', 'Especialidad creada correctamente.');
    }

    public function edit(Specialty $specialty)
    {
        return view('specialties.edit', compact('specialty'));
    }

    public function update(
        UpdateSpecialtyRequest $request,
        Specialty $specialty
    ) {
        $specialty->update($request->validated());

        return redirect()
            ->route('specialties.index')
            ->with('success', 'Especialidad actualizada correctamente.');
    }

    public function destroy(Specialty $specialty)
    {
        if ($specialty->doctors()->exists()) {
            return redirect()
                ->route('specialties.index')
                ->with(
                    'error',
                    'No se puede eliminar la especialidad porque tiene médicos asignados.'
                );
        }

        $specialty->delete();

        return redirect()
            ->route('specialties.index')
            ->with('success', 'Especialidad eliminada correctamente.');
    }
}
