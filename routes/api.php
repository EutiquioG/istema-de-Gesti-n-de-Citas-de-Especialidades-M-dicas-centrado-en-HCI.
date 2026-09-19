<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\SpecialtyController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('patients', PatientController::class);

    Route::apiResource('doctors', DoctorController::class);

    Route::apiResource('specialties', SpecialtyController::class);

    Route::apiResource('appointments', AppointmentController::class);

    /*
    |--------------------------------------------------------------------------
    | Médicos por especialidad
    |--------------------------------------------------------------------------
    */

    Route::get(
        'doctors/by-specialty/{specialty}',
        [DoctorController::class, 'porEspecialidad']
    );

    /*
    |--------------------------------------------------------------------------
    | Horas ocupadas de un médico
    |--------------------------------------------------------------------------
    */

    Route::get(
        'appointments/horas-ocupadas',
        [AppointmentController::class, 'horasOcupadas']
    );
});
