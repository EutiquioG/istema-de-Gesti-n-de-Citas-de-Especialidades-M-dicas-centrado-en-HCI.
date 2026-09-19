<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')
                ->constrained('patients')->cascadeOnDelete();
            $table->foreignId('doctor_id')
                ->constrained('doctors')->restrictOnDelete();
            $table->foreignId('specialty_id')
                ->constrained('specialties')->restrictOnDelete();

            $table->date('fecha');
            $table->time('hora');
            $table->string('motivo_consulta', 255);
            $table->enum('estado', ['pendiente', 'confirmada', 'atendida', 'cancelada'])
                ->default('pendiente');

            $table->timestamps();

            // Evita dos citas para el mismo médico en la misma fecha y hora
            $table->unique(['doctor_id', 'fecha', 'hora'], 'unico_medico_fecha_hora');

            $table->index(['fecha', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
