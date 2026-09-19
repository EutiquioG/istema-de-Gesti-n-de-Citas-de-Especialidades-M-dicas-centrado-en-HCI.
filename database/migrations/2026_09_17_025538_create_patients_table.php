<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()
                ->constrained('users')->nullOnDelete();

            $table->enum('tipo_documento', ['CC', 'TI', 'CE', 'PA'])->default('CC');
            $table->string('numero_documento', 20)->unique();
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->date('fecha_nacimiento');
            $table->string('telefono', 20);
            $table->string('correo', 150)->unique();
            $table->string('direccion', 255)->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');

            $table->timestamps();

            $table->index(['nombres', 'apellidos']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
