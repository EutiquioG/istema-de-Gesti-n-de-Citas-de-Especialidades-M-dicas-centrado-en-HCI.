<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()
                ->constrained('users')->nullOnDelete();
            $table->foreignId('specialty_id')
                ->constrained('specialties')->restrictOnDelete();

            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->string('numero_identificacion', 20)->unique();
            $table->string('registro_profesional', 50)->unique();
            $table->string('telefono', 20);
            $table->string('correo', 150)->unique();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');

            $table->timestamps();

            $table->index(['nombres', 'apellidos']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
