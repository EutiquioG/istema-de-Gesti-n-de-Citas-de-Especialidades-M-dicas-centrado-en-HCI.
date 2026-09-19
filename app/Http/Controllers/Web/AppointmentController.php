<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Specialty;
use App\Services\AppointmentService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    protected AppointmentService $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * =========================================================
     * LISTADO DE CITAS
     * =========================================================
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | CONSULTA BASE
        |--------------------------------------------------------------------------
        */
        $query = Appointment::with([
            'patient',
            'doctor',
            'specialty',
        ]);

        /*
        |--------------------------------------------------------------------------
        | PACIENTE
        |--------------------------------------------------------------------------
        | El paciente solamente puede ver sus propias citas.
        */
        if ($user->role === 'paciente') {

            $patient = $user->patient;

            if (!$patient) {

                $appointments = Appointment::whereRaw('1 = 0')
                    ->paginate(10)
                    ->withQueryString();
            } else {

                $query->where(
                    'patient_id',
                    $patient->id
                );

                $appointments = $query
                    ->when(
                        $request->estado,
                        fn($q, $estado) =>
                        $q->where('estado', $estado)
                    )
                    ->when(
                        $request->especialidad,
                        fn($q, $id) =>
                        $q->where('specialty_id', $id)
                    )
                    ->orderByDesc('fecha')
                    ->orderByDesc('hora')
                    ->paginate(10)
                    ->withQueryString();
            }
        } else {

            /*
            |--------------------------------------------------------------------------
            | ADMINISTRADOR
            |--------------------------------------------------------------------------
            | El administrador puede ver todas las citas.
            */
            $appointments = $query
                ->when(
                    $request->estado,
                    fn($q, $estado) =>
                    $q->where('estado', $estado)
                )
                ->when(
                    $request->especialidad,
                    fn($q, $id) =>
                    $q->where('specialty_id', $id)
                )
                ->when(
                    $request->buscar,
                    function ($q, $buscar) {

                        $q->whereHas(
                            'patient',
                            function ($sub) use ($buscar) {

                                $sub->where(function ($sub) use ($buscar) {

                                    $sub->where(
                                        'nombres',
                                        'like',
                                        "%{$buscar}%"
                                    )
                                        ->orWhere(
                                            'apellidos',
                                            'like',
                                            "%{$buscar}%"
                                        )
                                        ->orWhere(
                                            'numero_documento',
                                            'like',
                                            "%{$buscar}%"
                                        );
                                });
                            }
                        );
                    }
                )
                ->orderByDesc('fecha')
                ->orderByDesc('hora')
                ->paginate(10)
                ->withQueryString();
        }

        /*
        |--------------------------------------------------------------------------
        | ESPECIALIDADES
        |--------------------------------------------------------------------------
        */
        $specialties = Specialty::activas()
            ->orderBy('nombre')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | PACIENTES
        |--------------------------------------------------------------------------
        | Siempre definimos la variable para evitar:
        |
        | Undefined variable $patients
        |
        | Solo el administrador necesita cargar los pacientes.
        */
        $patients = collect();

        if ($user->role === 'admin') {

            $patients = Patient::activos()
                ->orderBy('apellidos')
                ->orderBy('nombres')
                ->get();
        }

        return view(
            'appointments.index',
            compact(
                'appointments',
                'specialties',
                'patients'
            )
        );
    }

    /**
     * =========================================================
     * CREAR CITA
     * =========================================================
     */
    public function create()
    {
        $user = auth()->user();

        $specialties = Specialty::activas()
            ->orderBy('nombre')
            ->get();

        $patients = collect();

        /*
        |--------------------------------------------------------------------------
        | SOLO ADMINISTRADOR CARGA PACIENTES
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'admin') {

            $patients = Patient::activos()
                ->orderBy('apellidos')
                ->orderBy('nombres')
                ->get();
        }

        return view(
            'appointments.create',
            compact(
                'specialties',
                'patients'
            )
        );
    }

    /**
     * =========================================================
     * GUARDAR CITA
     * =========================================================
     */
    public function store(StoreAppointmentRequest $request)
    {
        $user = auth()->user();

        $data = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | PACIENTE
        |--------------------------------------------------------------------------
        | El paciente no selecciona patient_id.
        | El sistema lo obtiene automáticamente.
        */
        if ($user->role === 'paciente') {

            $patient = $user->patient;

            if (!$patient) {

                return back()
                    ->with(
                        'error',
                        'Tu usuario no tiene un perfil de paciente asociado.'
                    )
                    ->withInput();
            }

            /*
            | Seguridad:
            | ignoramos cualquier patient_id enviado manualmente.
            */
            $data['patient_id'] = $patient->id;
        }

        /*
        |--------------------------------------------------------------------------
        | ADMINISTRADOR
        |--------------------------------------------------------------------------
        | El administrador sí debe seleccionar un paciente.
        */
        if ($user->role === 'admin') {

            if (empty($data['patient_id'])) {

                return back()
                    ->with(
                        'error',
                        'Debes seleccionar un paciente para registrar la cita.'
                    )
                    ->withInput();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | ESTADO INICIAL
        |--------------------------------------------------------------------------
        */
        $data['estado'] = 'pendiente';

        try {

            $this->appointmentService->crear($data);
        } catch (ValidationException $e) {

            return back()
                ->withErrors($e->errors())
                ->withInput();
        }

        return redirect()
            ->route('appointments.index')
            ->with(
                'success',
                'Cita registrada correctamente.'
            );
    }

    /**
     * =========================================================
     * VER CITA
     * =========================================================
     */
    public function show(Appointment $appointment)
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | PACIENTE SOLO PUEDE VER SUS CITAS
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'paciente') {

            $patient = $user->patient;

            if (
                !$patient ||
                $appointment->patient_id !== $patient->id
            ) {
                abort(403);
            }
        }

        $appointment->load([
            'patient',
            'doctor',
            'specialty',
        ]);

        return view(
            'appointments.show',
            compact('appointment')
        );
    }

    /**
     * =========================================================
     * EDITAR CITA
     * =========================================================
     */
    public function edit(Appointment $appointment)
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | PACIENTE SOLO PUEDE EDITAR SUS CITAS
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'paciente') {

            $patient = $user->patient;

            if (
                !$patient ||
                $appointment->patient_id !== $patient->id
            ) {
                abort(403);
            }
        }

        $specialties = Specialty::activas()
            ->orderBy('nombre')
            ->get();

        $patients = collect();

        /*
        |--------------------------------------------------------------------------
        | ADMINISTRADOR
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'admin') {

            $patients = Patient::activos()
                ->orderBy('apellidos')
                ->orderBy('nombres')
                ->get();
        }

        $appointment->load([
            'patient',
            'doctor',
            'specialty',
        ]);

        return view(
            'appointments.edit',
            compact(
                'appointment',
                'specialties',
                'patients'
            )
        );
    }

    /**
     * =========================================================
     * ACTUALIZAR CITA
     * =========================================================
     */
    public function update(
        UpdateAppointmentRequest $request,
        Appointment $appointment
    ) {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | PACIENTE SOLO PUEDE ACTUALIZAR SUS CITAS
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'paciente') {

            $patient = $user->patient;

            if (
                !$patient ||
                $appointment->patient_id !== $patient->id
            ) {
                abort(403);
            }
        }

        $data = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | PACIENTE
        |--------------------------------------------------------------------------
        | No puede modificar el paciente de la cita.
        */
        if ($user->role === 'paciente') {

            $patient = $user->patient;

            if (!$patient) {

                return back()
                    ->with(
                        'error',
                        'Tu usuario no tiene un perfil de paciente asociado.'
                    )
                    ->withInput();
            }

            $data['patient_id'] = $patient->id;
        }

        /*
        |--------------------------------------------------------------------------
        | ADMINISTRADOR
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'admin') {

            if (empty($data['patient_id'])) {

                return back()
                    ->with(
                        'error',
                        'Debes seleccionar un paciente.'
                    )
                    ->withInput();
            }
        }

        try {

            $this->appointmentService->actualizar(
                $appointment,
                $data
            );
        } catch (ValidationException $e) {

            return back()
                ->withErrors($e->errors())
                ->withInput();
        }

        return redirect()
            ->route('appointments.index')
            ->with(
                'success',
                'Cita actualizada correctamente.'
            );
    }

    /**
     * =========================================================
     * CANCELAR CITA
     * =========================================================
     */
    public function destroy(Appointment $appointment)
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | PACIENTE SOLO PUEDE CANCELAR SUS CITAS
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'paciente') {

            $patient = $user->patient;

            if (
                !$patient ||
                $appointment->patient_id !== $patient->id
            ) {
                abort(403);
            }
        }

        $appointment->update([
            'estado' => 'cancelada',
        ]);

        return redirect()
            ->route('appointments.index')
            ->with(
                'success',
                'Cita cancelada correctamente.'
            );
    }

    /**
     * =========================================================
     * MÉDICOS POR ESPECIALIDAD
     * =========================================================
     */
    public function doctorsBySpecialty(Specialty $specialty)
    {
        $doctors = Doctor::where(
            'specialty_id',
            $specialty->id
        )
            ->where(
                'estado',
                'activo'
            )
            ->orderBy('apellidos')
            ->orderBy('nombres')
            ->get([
                'id',
                'nombres',
                'apellidos',
            ]);

        return response()->json([
            'data' => $doctors,
        ]);
    }
}
