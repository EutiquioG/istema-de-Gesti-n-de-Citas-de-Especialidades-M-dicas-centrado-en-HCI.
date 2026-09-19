<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Validation\ValidationException;

class AppointmentService
{
    /**
     * Verifica si un médico está disponible
     * en una fecha y hora específica.
     */
    public function estaDisponible(
        int $doctorId,
        string $fecha,
        string $hora,
        ?int $ignoreAppointmentId = null
    ): bool {

        $query = Appointment::where('doctor_id', $doctorId)
            ->where('fecha', $fecha)
            ->where('hora', $hora)
            ->whereNotIn('estado', ['cancelada']);

        if ($ignoreAppointmentId) {
            $query->where('id', '!=', $ignoreAppointmentId);
        }

        return ! $query->exists();
    }

    /**
     * Valida que el médico esté disponible.
     */
    public function validarDisponibilidad(
        int $doctorId,
        string $fecha,
        string $hora,
        ?int $ignoreAppointmentId = null
    ): void {

        if (
            ! $this->estaDisponible(
                $doctorId,
                $fecha,
                $hora,
                $ignoreAppointmentId
            )
        ) {
            throw ValidationException::withMessages([
                'hora' =>
                'La cita no pudo registrarse porque el médico ya tiene una cita programada en ese horario.'
            ]);
        }
    }

    /**
     * Obtiene las horas ocupadas de un médico
     * en una fecha determinada.
     */
    public function horasOcupadas(
        int $doctorId,
        string $fecha
    ): array {

        return Appointment::where('doctor_id', $doctorId)
            ->where('fecha', $fecha)
            ->whereNotIn('estado', ['cancelada'])
            ->pluck('hora')
            ->map(fn($hora) => substr($hora, 0, 5))
            ->toArray();
    }

    /**
     * Crea una cita validando previamente
     * la disponibilidad del médico.
     */
    public function crear(array $datos): Appointment
    {
        $this->validarDisponibilidad(
            $datos['doctor_id'],
            $datos['fecha'],
            $datos['hora']
        );

        return Appointment::create($datos);
    }

    /**
     * Actualiza una cita validando disponibilidad.
     */
    public function actualizar(
        Appointment $appointment,
        array $datos
    ): Appointment {

        $this->validarDisponibilidad(
            $datos['doctor_id'],
            $datos['fecha'],
            $datos['hora'],
            $appointment->id
        );

        $appointment->update($datos);

        return $appointment;
    }

    /**
     * Obtiene los médicos activos de una especialidad.
     *
     * Este método es utilizado por el formulario
     * de creación de citas.
     */
    public function medicosPorEspecialidad(int $specialtyId)
    {
        return Doctor::where('specialty_id', $specialtyId)
            ->where('estado', 'activo')
            ->orderBy('apellidos')
            ->orderBy('nombres')
            ->get([
                'id',
                'nombres',
                'apellidos',
                'specialty_id'
            ]);
    }
}
