
@extends('layouts.app')

@section('title', 'Detalle del paciente')

@section('content')

<div class="page-header">

    <div>
        <p class="page-header-eyebrow">Paciente</p>

        <h1 class="page-title">
            {{ $patient->nombre_completo }}
        </h1>

        <p class="page-description">
            Información general y citas registradas del paciente.
        </p>
    </div>

    <div class="page-actions">

        <a
            href="{{ route('patients.edit', $patient) }}"
            class="btn btn-primary"
        >
            Editar paciente
        </a>

        <a
            href="{{ route('patients.index') }}"
            class="btn btn-secondary"
        >
            ← Volver
        </a>

    </div>

</div>


{{-- Información principal --}}
<section class="detail-card">

    <div class="detail-card-header">

        <div>

            <h2 class="section-title">
                Información personal
            </h2>

            <p class="section-description">
                Datos de identificación del paciente.
            </p>

        </div>


        <div>

            @if($patient->estado === 'activo')

                <span class="badge badge-success">
                    Activo
                </span>

            @else

                <span class="badge badge-danger">
                    Inactivo
                </span>

            @endif

        </div>

    </div>


    <div class="detail-grid">

        <div class="detail-item">
            <span class="detail-label">
                Tipo de documento
            </span>

            <strong class="detail-value">
                {{ $patient->tipo_documento }}
            </strong>
        </div>


        <div class="detail-item">
            <span class="detail-label">
                Número de documento
            </span>

            <strong class="detail-value">
                {{ $patient->numero_documento }}
            </strong>
        </div>


        <div class="detail-item">
            <span class="detail-label">
                Nombres
            </span>

            <strong class="detail-value">
                {{ $patient->nombres }}
            </strong>
        </div>


        <div class="detail-item">
            <span class="detail-label">
                Apellidos
            </span>

            <strong class="detail-value">
                {{ $patient->apellidos }}
            </strong>
        </div>


        <div class="detail-item">
            <span class="detail-label">
                Fecha de nacimiento
            </span>

            <strong class="detail-value">

                @if($patient->fecha_nacimiento)

                    {{ \Carbon\Carbon::parse($patient->fecha_nacimiento)->format('d/m/Y') }}

                @else

                    No registrada

                @endif

            </strong>
        </div>


        <div class="detail-item">
            <span class="detail-label">
                Edad
            </span>

            <strong class="detail-value">

                @if($patient->fecha_nacimiento)

                    {{ \Carbon\Carbon::parse($patient->fecha_nacimiento)->age }}
                    años

                @else

                    No disponible

                @endif

            </strong>
        </div>

    </div>

</section>


{{-- Contacto --}}
<section class="detail-card">

    <div class="detail-card-header">

        <div>

            <h2 class="section-title">
                Información de contacto
            </h2>

            <p class="section-description">
                Datos de contacto registrados.
            </p>

        </div>

    </div>


    <div class="detail-grid">

        <div class="detail-item">

            <span class="detail-label">
                Teléfono
            </span>

            <strong class="detail-value">
                {{ $patient->telefono }}
            </strong>

        </div>


        <div class="detail-item">

            <span class="detail-label">
                Correo electrónico
            </span>

            <strong class="detail-value">
                {{ $patient->correo }}
            </strong>

        </div>


        <div class="detail-item detail-item-full">

            <span class="detail-label">
                Dirección
            </span>

            <strong class="detail-value">
                {{ $patient->direccion ?: 'No registrada' }}
            </strong>

        </div>

    </div>

</section>


{{-- Citas --}}
<section class="content-section">

    <div class="section-header">

        <div>

            <h2 class="section-title">
                Historial de citas
            </h2>

            <p class="section-description">
                Citas médicas asociadas a este paciente.
            </p>

        </div>


        <div>

            <a
                href="{{ route('appointments.create') }}"
                class="btn btn-primary"
            >
                Nueva cita
            </a>

        </div>

    </div>


    @if($patient->appointments->count())

        <div class="table-container">

            <table class="data-table">

                <thead>

                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Especialidad</th>
                        <th>Médico</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($patient->appointments as $appointment)

                        <tr>

                            <td>
                                {{ \Carbon\Carbon::parse($appointment->fecha)->format('d/m/Y') }}
                            </td>

                            <td>
                                {{ substr($appointment->hora, 0, 5) }}
                            </td>

                            <td>
                                {{ $appointment->specialty->nombre ?? 'Sin especialidad' }}
                            </td>

                            <td>
                                {{ $appointment->doctor->nombre_completo ?? 'Sin médico' }}
                            </td>

                            <td>

                                @switch($appointment->estado)

                                    @case('pendiente')
                                        <span class="badge badge-warning">
                                            Pendiente
                                        </span>
                                        @break

                                    @case('confirmada')
                                        <span class="badge badge-success">
                                            Confirmada
                                        </span>
                                        @break

                                    @case('atendida')
                                        <span class="badge badge-primary">
                                            Atendida
                                        </span>
                                        @break

                                    @case('cancelada')
                                        <span class="badge badge-danger">
                                            Cancelada
                                        </span>
                                        @break

                                    @default
                                        <span class="badge">
                                            {{ ucfirst($appointment->estado) }}
                                        </span>

                                @endswitch

                            </td>

                            <td>

                                <a
                                    href="{{ route('appointments.show', $appointment) }}"
                                    class="btn btn-sm btn-secondary"
                                >
                                    Ver cita
                                </a>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="empty-state">

            <div class="empty-state-icon" aria-hidden="true">
                📅
            </div>

            <h3 class="empty-state-title">
                No hay citas registradas
            </h3>

            <p class="empty-state-description">
                Este paciente todavía no tiene citas médicas asociadas.
            </p>

            <a
                href="{{ route('appointments.create') }}"
                class="btn btn-primary"
            >
                Registrar una cita
            </a>

        </div>

    @endif

</section>

@endsection
```

---

### `resources/views/patients/edit.blade.php`

```blade
@extends('layouts.app')

@section('title', 'Editar paciente')

@section('content')

<div class="page-header">

    <div>

        <p class="page-header-eyebrow">
            Pacientes
        </p>

        <h1 class="page-title">
            Editar paciente
        </h1>

        <p class="page-description">
            Actualiza la información de {{ $patient->nombre_completo }}.
        </p>

    </div>


    <div class="page-actions">

        <a
            href="{{ route('patients.show', $patient) }}"
            class="btn btn-secondary"
        >
            ← Volver
        </a>

    </div>

</div>


<div class="form-container">

    <form
        action="{{ route('patients.update', $patient) }}"
        method="POST"
        novalidate
    >

        @csrf
        @method('PUT')


        {{-- Información personal --}}
        <section class="form-section">

            <div class="form-section-header">

                <div>

                    <h2 class="form-section-title">
                        Información personal
                    </h2>

                    <p class="form-section-description">
                        Actualiza los datos de identificación.
                    </p>

                </div>

            </div>


            <div class="form-grid">

                {{-- Tipo documento --}}
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

                        <option value="CC" @selected(old('tipo_documento', $patient->tipo_documento) === 'CC')>
                            Cédula de ciudadanía
                        </option>

                        <option value="TI" @selected(old('tipo_documento', $patient->tipo_documento) === 'TI')>
                            Tarjeta de identidad
                        </option>

                        <option value="CE" @selected(old('tipo_documento', $patient->tipo_documento) === 'CE')>
                            Cédula de extranjería
                        </option>

                        <option value="PA" @selected(old('tipo_documento', $patient->tipo_documento) === 'PA')>
                            Pasaporte
                        </option>

                    </select>

                    @error('tipo_documento')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Documento --}}
                <div class="form-group">

                    <label for="numero_documento" class="form-label">
                        Número de documento
                        <span class="form-required">*</span>
                    </label>

                    <input
                        type="text"
                        id="numero_documento"
                        name="numero_documento"
                        value="{{ old('numero_documento', $patient->numero_documento) }}"
                        class="form-control @error('numero_documento') is-invalid @enderror"
                        maxlength="20"
                        inputmode="numeric"
                        required
                    >

                    @error('numero_documento')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Nombres --}}
                <div class="form-group">

                    <label for="nombres" class="form-label">
                        Nombres
                        <span class="form-required">*</span>
                    </label>

                    <input
                        type="text"
                        id="nombres"
                        name="nombres"
                        value="{{ old('nombres', $patient->nombres) }}"
                        class="form-control @error('nombres') is-invalid @enderror"
                        maxlength="100"
                        autocomplete="given-name"
                        required
                    >

                    @error('nombres')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Apellidos --}}
                <div class="form-group">

                    <label for="apellidos" class="form-label">
                        Apellidos
                        <span class="form-required">*</span>
                    </label>

                    <input
                        type="text"
                        id="apellidos"
                        name="apellidos"
                        value="{{ old('apellidos', $patient->apellidos) }}"
                        class="form-control @error('apellidos') is-invalid @enderror"
                        maxlength="100"
                        autocomplete="family-name"
                        required
                    >

                    @error('apellidos')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Fecha --}}
                <div class="form-group">

                    <label for="fecha_nacimiento" class="form-label">
                        Fecha de nacimiento
                        <span class="form-required">*</span>
                    </label>

                    <input
                        type="date"
                        id="fecha_nacimiento"
                        name="fecha_nacimiento"
                        value="{{ old('fecha_nacimiento', optional($patient->fecha_nacimiento)->format('Y-m-d')) }}"
                        class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                        autocomplete="bday"
                        required
                    >

                    @error('fecha_nacimiento')
                        <span class="form-error">
                            {{ $message }}
                        </span>
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
                        Actualiza los datos de contacto.
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
                        value="{{ old('telefono', $patient->telefono) }}"
                        class="form-control @error('telefono') is-invalid @enderror"
                        maxlength="20"
                        autocomplete="tel"
                        required
                    >

                    @error('telefono')
                        <span class="form-error">
                            {{ $message }}
                        </span>
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
                        value="{{ old('correo', $patient->correo) }}"
                        class="form-control @error('correo') is-invalid @enderror"
                        maxlength="150"
                        autocomplete="email"
                        required
                    >

                    @error('correo')
                        <span class="form-error">
                            {{ $message }}
                        </span>
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
                        value="{{ old('direccion', $patient->direccion) }}"
                        class="form-control @error('direccion') is-invalid @enderror"
                        maxlength="255"
                        autocomplete="street-address"
                    >

                    @error('direccion')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

            </div>

        </section>


        {{-- Estado --}}
        <section class="form-section">

            <div class="form-section-header">

                <div>

                    <h2 class="form-section-title">
                        Estado del paciente
                    </h2>

                    <p class="form-section-description">
                        Controla si el paciente puede ser utilizado para nuevas citas.
                    </p>

                </div>

            </div>


            <div class="form-group">

                <label
                    for="estado"
                    class="form-label"
                >
                    Estado
                    <span class="form-required">*</span>
                </label>

                <select
                    id="estado"
                    name="estado"
                    class="form-control @error('estado') is-invalid @enderror"
                    required
                >

                    <option
                        value="activo"
                        @selected(old('estado', $patient->estado) === 'activo')
                    >
                        Activo
                    </option>

                    <option
                        value="inactivo"
                        @selected(old('estado', $patient->estado) === 'inactivo')
                    >
                        Inactivo
                    </option>

                </select>

                <span class="form-help">
                    Un paciente inactivo no debería utilizarse para nuevas citas.
                </span>

                @error('estado')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>

        </section>


        {{-- Acciones --}}
        <div class="form-actions">

            <a
                href="{{ route('patients.show', $patient) }}"
                class="btn btn-secondary"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >
                Guardar cambios
            </button>

        </div>

    </form>

</div>

@endsection

