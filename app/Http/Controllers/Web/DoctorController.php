<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Models\Specialty;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('specialty')
            ->when(request('buscar'), function ($query, $buscar) {
                $query->where(function ($query) use ($buscar) {
                    $query->where('nombres', 'like', "%{$buscar}%")
                        ->orWhere('apellidos', 'like', "%{$buscar}%");
                });
            })
            ->when(request('especialidad'), function ($query, $especialidadId) {
                $query->where('specialty_id', $especialidadId);
            })
            ->orderBy('apellidos')
            ->paginate(10)
            ->withQueryString();

        $specialties = Specialty::activas()->get();

        return view('doctors.index', compact('doctors', 'specialties'));
    }

    public function create()
    {
        $specialties = Specialty::activas()->get();

        return view('doctors.create', compact('specialties'));
    }

    public function store(StoreDoctorRequest $request)
    {
        Doctor::create(
            $request->validated() + [
                'estado' => 'activo',
            ]
        );

        return redirect()
            ->route('doctors.index')
            ->with('success', 'Médico registrado correctamente.');
    }

    public function show(Doctor $doctor)
    {
        $doctor->load([
            'specialty',
            'appointments.patient',
        ]);

        return view('doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        $specialties = Specialty::activas()->get();

        return view('doctors.edit', compact('doctor', 'specialties'));
    }

    public function update(
        UpdateDoctorRequest $request,
        Doctor $doctor
    ) {
        $doctor->update($request->validated());

        return redirect()
            ->route('doctors.index')
            ->with('success', 'Médico actualizado correctamente.');
    }

    public function destroy(Doctor $doctor)
    {
        if ($doctor->appointments()->exists()) {
            return redirect()
                ->route('doctors.index')
                ->with(
                    'error',
                    'No se puede eliminar el médico porque tiene citas registradas. Puedes inactivarlo en su lugar.'
                );
        }

        $doctor->delete();

        return redirect()
            ->route('doctors.index')
            ->with('success', 'Médico eliminado correctamente.');
    }
}
