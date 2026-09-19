<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Specialty;

class DashboardController extends Controller
{
    public function index()
    {

        $totalPacientes = Patient::activos()->count();
        $totalMedicos = Doctor::activos()->count();
        $totalEspecialidades = Specialty::activas()->count();

        $citasPendientes = Appointment::pendientes()->count();
        $citasConfirmadas = Appointment::confirmadas()->count();

        $citasAtendidas = Appointment::where('estado', 'atendida')->count();
        $citasCanceladas = Appointment::where('estado', 'cancelada')->count();
        $totalCitas = Appointment::count();

        $proximasCitas = Appointment::with([
            'patient',
            'doctor',
            'specialty',
        ])
            ->proximas()
            ->limit(10)
            ->get();

        return view('dashboard.index', compact(
            'totalPacientes',
            'totalMedicos',
            'totalEspecialidades',
            'citasPendientes',
            'citasConfirmadas',
            'citasAtendidas',
            'citasCanceladas',
            'totalCitas',
            'proximasCitas'
        ));
    }
}
