<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Web\AppointmentController;
use App\Http\Controllers\Web\DoctorController;
use App\Http\Controllers\Web\PatientController;
use App\Http\Controllers\Web\SpecialtyController;
use Illuminate\Support\Facades\Route;


// =========================================================
// PÁGINA PRINCIPAL
// =========================================================

Route::get('/', function () {

    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});


// =========================================================
// RUTAS PROTEGIDAS
// =========================================================

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])->name('dashboard');


    // Perfil
    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');


    // Pacientes
    Route::resource(
        'patients',
        PatientController::class
    );


    // Médicos
    Route::resource(
        'doctors',
        DoctorController::class
    );


    // Especialidades
    Route::resource(
        'specialties',
        SpecialtyController::class
    );


    // =====================================================
    // CITAS
    // =====================================================

    Route::resource(
        'appointments',
        AppointmentController::class
    );

    // Médicos según la especialidad seleccionada
    Route::get(
        '/appointments/doctors/{specialty}',
        [AppointmentController::class, 'doctorsBySpecialty']
    )->name('appointments.doctors');
});


// =========================================================
// AUTENTICACIÓN
// =========================================================

require __DIR__ . '/auth.php';
