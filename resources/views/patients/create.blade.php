
@extends('layouts.app')

@section('title', 'Registrar paciente')

@section('content')

<div class="page-header">

    <div>
        <p class="page-header-eyebrow">Pacientes</p>

        <h1 class="page-title">
            Registrar paciente
        </h1>

        <p class="page-description">
            Completa los datos básicos para registrar un nuevo paciente.
        </p>
    </div>

    <div class="page-actions">
        <a
            href="{{ route('patients.index') }}"
            class="btn btn-secondary"
        >
            ← Volver
        </a>
    </div>

</div>


<div class="form-container">

    <form
        action="{{ route('patients.store') }}"
        method="POST"
        novalidate
    >

        @csrf


        {{-- Información personal --}}
        <section class="form-section">

            <div class="form-section-header">

                <div>

                    <h2 class="form-section-title">
                        Información personal
                    </h2>

                    <p class="form-section-description">
                        Datos utilizados para identificar al paciente.
                    </p>

                </div>

            </div>


            <div class="form-grid">

                <div class="form-group">

                    <label for="tipo_documento" class="form-label">
                        Tipo de documento
                        <span class="form-required">*</span>
                    </label>

                    <select
                        id="tipo_documento"
                        name="tipo_documento"
                        class="form-control @error('tipo_documento') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            Selecciona una opción
                        </option>

                        <option value="CC" @selected(old('tipo_documento') === 'CC')>
                            Cédula de ciudadanía
                        </option>

                        <option value="TI" @selected(old('tipo_documento') === 'TI')>
                            Tarjeta de identidad
                        </option>

                        <option value="CE" @selected(old('tipo_documento') === 'CE')>
                            Cédula de extranjería
                        </option>

                        <option value="PA" @selected(old('tipo_documento') === 'PA')>
                            Pasaporte
                        </option>

                    </select>

                    @error('tipo_documento')
                        <span class="form-error">{{ $message }}</span>
                    @enderror

                </div>


                <div class="form-group">

                    <label for="numero_documento" class="form-label">
                        Número de documento
                        <span class="form-required">*</span>
                    </label>

                    <input
                        type="text"
                        id="numero_documento"
                        name="numero_documento"
                        value="{{ old('numero_documento') }}"
                        class="form-control @error('numero_documento') is-invalid @enderror"
                        maxlength="20"
                        inputmode="numeric"
                        required
                    >

                    <span class="form-help">
                        Ingresa el número sin puntos ni espacios.
                    </span>

                    @error('numero_documento')
                        <span class="form-error">{{ $message }}</span>
                    @enderror

                </div>


                <div class="form-group">

                    <label for="nombres" class="form-label">
                        Nombres
                        <span class="form-required">*</span>
                    </label>

                    <input
                        type="text"
                        id="nombres"
                        name="nombres"
                        value="{{ old('nombres') }}"
                        class="form-control @error('nombres') is-invalid @enderror"
                        maxlength="100"
                        autocomplete="given-name"
                        required
                    >

                    @error('nombres')
                        <span class="form-error">{{ $message }}</span>
                    @enderror

                </div>


                <div class="form-group">

                    <label for="apellidos" class="form-label">
                        Apellidos
                        <span class="form-required">*</span>
                    </label>

                    <input
                        type="text"
                        id="apellidos"
                        name="apellidos"
                        value="{{ old('apellidos') }}"
                        class="form-control @error('apellidos') is-invalid @enderror"
                        maxlength="100"
                        autocomplete="family-name"
                        required
                    >

                    @error('apellidos')
                        <span class="form-error">{{ $message }}</span>
                    @enderror

                </div>


                <div class="form-group">

                    <label for="fecha_nacimiento" class="form-label">
                        Fecha de nacimiento
                        <span class="form-required">*</span>
                    </label>

                    <input
                        type="date"
                        id="fecha_nacimiento"
                        name="fecha_nacimiento"
                        value="{{ old('fecha_nacimiento') }}"
                        class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                        autocomplete="bday"
                        required
                    >

                    @error('fecha_nacimiento')
                        <span class="form-error">{{ $message }}</span>
                    @enderror

                </div>

            </div>

        </section>


        {{-- Contacto --}}
        <section class="form-section">

            <div class="form-section-header">

                <div>

                    <h2 class="form-section-title">
                        Información de contacto
                    </h2>

                    <p class="form-section-description">
                        Datos para comunicarnos con el paciente.
                    </p>

                </div>

            </div>


            <div class="form-grid">

                <div class="form-group">

                    <label for="telefono" class="form-label">
                        Teléfono
                        <span class="form-required">*</span>
                    </label>

                    <input
                        type="tel"
                        id="telefono"
                        name="telefono"
                        value="{{ old('telefono') }}"
                        class="form-control @error('telefono') is-invalid @enderror"
                        maxlength="20"
                        autocomplete="tel"
                        required
                    >

                    @error('telefono')
                        <span class="form-error">{{ $message }}</span>
                    @enderror

                </div>


                <div class="form-group">

                    <label for="correo" class="form-label">
                        Correo electrónico
                        <span class="form-required">*</span>
                    </label>

                    <input
                        type="email"
                        id="correo"
                        name="correo"
                        value="{{ old('correo') }}"
                        class="form-control @error('correo') is-invalid @enderror"
                        maxlength="150"
                        autocomplete="email"
                        required
                    >

                    @error('correo')
                        <span class="form-error">{{ $message }}</span>
                    @enderror

                </div>


                <div class="form-group form-group-full">

                    <label for="direccion" class="form-label">
                        Dirección
                        <span class="form-required-optional">
                            Opcional
                        </span>
                    </label>

                    <input
                        type="text"
                        id="direccion"
                        name="direccion"
                        value="{{ old('direccion') }}"
                        class="form-control @error('direccion') is-invalid @enderror"
                        maxlength="255"
                        autocomplete="street-address"
                    >

                    @error('direccion')
                        <span class="form-error">{{ $message }}</span>
                    @enderror

                </div>

            </div>

        </section>


        {{-- Estado --}}
        <section class="form-section">

            <div class="form-section-header">

                <div>

                    <h2 class="form-section-title">
                        Estado del registro
                    </h2>

                    <p class="form-section-description">
                        Los pacientes nuevos se registran como activos.
                    </p>

                </div>

            </div>


            <div class="status-preview">

                <div
                    class="status-preview-indicator"
                    aria-hidden="true"
                ></div>

                <div class="status-preview-text">

                    <strong>Paciente activo</strong>

                    <span>
                        Podrá ser seleccionado posteriormente para programar una cita.
                    </span>

                </div>

            </div>

        </section>


        {{-- Acciones --}}
        <div class="form-actions">

            <a
                href="{{ route('patients.index') }}"
                class="btn btn-secondary"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >
                Registrar paciente
            </button>

        </div>

    </form>

</div>

@endsection

