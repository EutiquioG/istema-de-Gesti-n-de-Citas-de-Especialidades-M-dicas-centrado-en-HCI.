<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use App\Models\User;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::with('user')
            ->when(request('buscar'), function ($query, $buscar) {
                $query->where(function ($query) use ($buscar) {
                    $query->where('nombres', 'like', "%{$buscar}%")
                        ->orWhere('apellidos', 'like', "%{$buscar}%")
                        ->orWhere('numero_documento', 'like', "%{$buscar}%");
                });
            })
            ->orderBy('apellidos')
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Usuarios disponibles para asociar a pacientes
        |--------------------------------------------------------------------------
        |
        | Solamente se muestran usuarios cuyo rol sea "paciente".
        | Se carga también la relación patient para poder identificar
        | cuáles ya están asociados.
        |
        */

        $users = User::with('patient')
            ->where('role', 'paciente')
            ->orderBy('name')
            ->get();

        return view(
            'patients.index',
            compact(
                'patients',
                'users'
            )
        );
    }

    public function create()
    {
        $users = User::with('patient')
            ->where('role', 'paciente')
            ->orderBy('name')
            ->get();

        return view(
            'patients.create',
            compact('users')
        );
    }

    public function store(StorePatientRequest $request)
    {
        Patient::create(
            $request->validated() + [
                'estado' => 'activo',
            ]
        );

        return redirect()
            ->route('patients.index')
            ->with(
                'success',
                'Paciente registrado correctamente.'
            );
    }

    public function show(Patient $patient)
    {
        $patient->load([
            'user',
            'appointments.doctor',
            'appointments.specialty',
        ]);

        return view(
            'patients.show',
            compact('patient')
        );
    }

    public function edit(Patient $patient)
    {
        $patient->load('user');

        $users = User::with('patient')
            ->where('role', 'paciente')
            ->orderBy('name')
            ->get();

        return view(
            'patients.edit',
            compact(
                'patient',
                'users'
            )
        );
    }

    public function update(
        UpdatePatientRequest $request,
        Patient $patient
    ) {
        $patient->update(
            $request->validated()
        );

        return redirect()
            ->route('patients.index')
            ->with(
                'success',
                'Paciente actualizado correctamente.'
            );
    }

    public function destroy(Patient $patient)
    {
        if ($patient->appointments()->exists()) {
            return redirect()
                ->route('patients.index')
                ->with(
                    'error',
                    'No se puede eliminar el paciente porque tiene citas registradas. Puedes inactivarlo en su lugar.'
                );
        }

        $patient->delete();

        return redirect()
            ->route('patients.index')
            ->with(
                'success',
                'Paciente eliminado correctamente.'
            );
    }
}
