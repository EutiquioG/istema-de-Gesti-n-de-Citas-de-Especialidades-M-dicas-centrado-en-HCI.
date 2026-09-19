
@extends('layouts.app')

@section('title', 'Citas')

@section('content')

<div class="appointments-module">

    {{-- =========================================================
        ENCABEZADO
    ========================================================== --}}
    <div class="page-header">

        <div>

            <p class="page-header-eyebrow">

                @if(auth()->user()->role === 'admin')
                    Gestión de citas
                @else
                    Mis citas
                @endif

            </p>

            <h1 class="page-title">

                @if(auth()->user()->role === 'paciente')
                    Mis citas
                @else
                    Citas
                @endif

            </h1>

            <p class="page-description">

                @if(auth()->user()->role === 'paciente')

                    Consulta el estado y la información de tus citas médicas.

                @else

                    Administra las citas médicas registradas en el sistema.

                @endif

            </p>

        </div>

        <div class="page-actions">

            <button
                type="button"
                class="btn btn-primary"
                onclick="openModal('modalCreateAppointment')"
            >

                @if(auth()->user()->role === 'paciente')
                    + Solicitar cita
                @else
                    + Nueva cita
                @endif

            </button>

        </div>

    </div>


    {{-- =========================================================
        MENSAJES
    ========================================================== --}}

    @if(session('success'))

        <div class="alert alert-success">

            <div class="alert-icon">
                ✓
            </div>

            <div>
                {{ session('success') }}
            </div>

        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-error">

            <div class="alert-icon">
                !
            </div>

            <div>
                {{ session('error') }}
            </div>

        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-error">

            <div class="alert-icon">
                !
            </div>

            <div>

                <strong>
                    Revisa la información ingresada.
                </strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        </div>

    @endif


    {{-- =========================================================
        AVISO DE CITA CONFIRMADA PARA PACIENTE
    ========================================================== --}}

    @if(auth()->user()->role === 'paciente')

        @php

            $citasConfirmadas = $appointments->filter(
                fn($appointment) =>
                    $appointment->estado === 'confirmada'
            )->count();

        @endphp

        @if($citasConfirmadas > 0)

            <div class="patient-confirmation-banner">

                <div class="patient-confirmation-icon">
                    ✓
                </div>

                <div class="patient-confirmation-content">

                    <strong>
                        Tienes una cita confirmada
                    </strong>

                    <p>
                        Tu cita médica ha sido confirmada.
                        Consulta los detalles en el listado de Mis citas.
                    </p>

                </div>

            </div>

        @endif

    @endif


    {{-- =========================================================
        FILTROS
    ========================================================== --}}

    @if(auth()->user()->role === 'admin')

        <div class="filters-card">

            <form
                method="GET"
                action="{{ route('appointments.index') }}"
                class="filters-form"
            >

                <div class="filter-group">

                    <label for="buscar">
                        Buscar paciente
                    </label>

                    <input
                        type="text"
                        id="buscar"
                        name="buscar"
                        class="form-control"
                        value="{{ request('buscar') }}"
                        placeholder="Nombre, apellido o documento"
                    >

                </div>


                <div class="filter-group">

                    <label for="especialidad">
                        Especialidad
                    </label>

                    <select
                        id="especialidad"
                        name="especialidad"
                        class="form-control"
                    >

                        <option value="">
                            Todas las especialidades
                        </option>

                        @foreach($specialties as $specialty)

                            <option
                                value="{{ $specialty->id }}"
                                @selected(request('especialidad') == $specialty->id)
                            >
                                {{ $specialty->nombre }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="filter-group">

                    <label for="estado">
                        Estado
                    </label>

                    <select
                        id="estado"
                        name="estado"
                        class="form-control"
                    >

                        <option value="">
                            Todos los estados
                        </option>

                        <option
                            value="pendiente"
                            @selected(request('estado') === 'pendiente')
                        >
                            Pendiente
                        </option>

                        <option
                            value="confirmada"
                            @selected(request('estado') === 'confirmada')
                        >
                            Confirmada
                        </option>

                        <option
                            value="atendida"
                            @selected(request('estado') === 'atendida')
                        >
                            Atendida
                        </option>

                        <option
                            value="cancelada"
                            @selected(request('estado') === 'cancelada')
                        >
                            Cancelada
                        </option>

                    </select>

                </div>


                <div class="filter-actions">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Filtrar
                    </button>

                    <a
                        href="{{ route('appointments.index') }}"
                        class="btn btn-secondary"
                    >
                        Limpiar
                    </a>

                </div>

            </form>

        </div>

    @endif


    {{-- =========================================================
        TABLA
    ========================================================== --}}

    <div class="table-card">

        <div class="table-header">

            <div>

                <h2>
                    @if(auth()->user()->role === 'paciente')
                        Mis citas médicas
                    @else
                        Citas registradas
                    @endif
                </h2>

                <p>
                    Consulta la información y el estado de las citas.
                </p>

            </div>

        </div>


        <div class="table-responsive">

            <table class="appointments-table">

                <thead>

                    <tr>

                        @if(auth()->user()->role === 'admin')
                            <th>Paciente</th>
                        @endif

                        <th>Fecha</th>

                        <th>Hora</th>

                        <th>Especialidad</th>

                        <th>Médico</th>

                        <th>Motivo</th>

                        <th>Estado</th>

                        <th class="text-center">
                            Acciones
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($appointments as $appointment)

                        <tr>

                            {{-- PACIENTE --}}
                            @if(auth()->user()->role === 'admin')

                                <td>

                                    @if($appointment->patient)

                                        <div class="patient-cell">

                                            <div class="patient-avatar">
                                                {{ strtoupper(substr($appointment->patient->nombres, 0, 1)) }}
                                            </div>

                                            <div>

                                                <strong>
                                                    {{ $appointment->patient->nombres }}
                                                    {{ $appointment->patient->apellidos }}
                                                </strong>

                                                <span>
                                                    {{ $appointment->patient->numero_documento }}
                                                </span>

                                            </div>

                                        </div>

                                    @else

                                        <span class="text-muted">
                                            Sin paciente
                                        </span>

                                    @endif

                                </td>

                            @endif


                            {{-- FECHA --}}
                            <td>

                                <span class="table-primary-text">

                                    {{ \Carbon\Carbon::parse($appointment->fecha)->format('d/m/Y') }}

                                </span>

                            </td>


                            {{-- HORA --}}
                            <td>

                                <span class="time-badge">

                                    {{ \Carbon\Carbon::parse($appointment->hora)->format('H:i') }}

                                </span>

                            </td>


                            {{-- ESPECIALIDAD --}}
                            <td>

                                @if($appointment->specialty)

                                    {{ $appointment->specialty->nombre }}

                                @else

                                    <span class="text-muted">
                                        Sin especialidad
                                    </span>

                                @endif

                            </td>


                            {{-- MÉDICO --}}
                            <td>

                                @if($appointment->doctor)

                                    <div class="doctor-cell">

                                        <strong>
                                            {{ $appointment->doctor->nombres }}
                                            {{ $appointment->doctor->apellidos }}
                                        </strong>

                                    </div>

                                @else

                                    <span class="text-muted">
                                        Sin médico
                                    </span>

                                @endif

                            </td>


                            {{-- MOTIVO --}}
                            <td>

                                <div class="reason-cell">

                                    {{ \Illuminate\Support\Str::limit(
                                        $appointment->motivo_consulta,
                                        35
                                    ) }}

                                </div>

                            </td>


                            {{-- ESTADO --}}
                            <td>

                                @if($appointment->estado === 'pendiente')

                                    <span class="status-badge status-pending">
                                        <span class="status-dot"></span>
                                        Pendiente
                                    </span>

                                @elseif($appointment->estado === 'confirmada')

                                    <span class="status-badge status-confirmed">
                                        <span class="status-dot"></span>
                                        Confirmada
                                    </span>

                                @elseif($appointment->estado === 'atendida')

                                    <span class="status-badge status-attended">
                                        <span class="status-dot"></span>
                                        Atendida
                                    </span>

                                @elseif($appointment->estado === 'cancelada')

                                    <span class="status-badge status-cancelled">
                                        <span class="status-dot"></span>
                                        Cancelada
                                    </span>

                                @endif

                            </td>


                            {{-- ACCIONES --}}
                            <td>

                                <div class="table-actions">

                                    <button
                                        type="button"
                                        class="action-btn action-view"
                                        onclick="openModal('modalShowAppointment{{ $appointment->id }}')"
                                        title="Ver cita"
                                    >
                                        Ver
                                    </button>


                                    <button
                                        type="button"
                                        class="action-btn action-edit"
                                        onclick="openModal('modalEditAppointment{{ $appointment->id }}')"
                                        title="Editar cita"
                                    >
                                        Editar
                                    </button>


                                    @if($appointment->estado !== 'cancelada')

                                        <button
                                            type="button"
                                            class="action-btn action-delete"
                                            onclick="openModal('modalCancelAppointment{{ $appointment->id }}')"
                                            title="Cancelar cita"
                                        >
                                            Cancelar
                                        </button>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="{{ auth()->user()->role === 'admin' ? 8 : 7 }}"
                                class="empty-state"
                            >

                                <div class="empty-icon">
                                    📅
                                </div>

                                <strong>
                                    @if(auth()->user()->role === 'paciente')
                                        No tienes citas registradas
                                    @else
                                        No hay citas registradas
                                    @endif
                                </strong>

                                <p>
                                    @if(auth()->user()->role === 'paciente')
                                        Cuando solicites una cita, aparecerá aquí.
                                    @else
                                        Las citas registradas aparecerán en este listado.
                                    @endif
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINACIÓN --}}
        @if($appointments->hasPages())

            <div class="pagination-wrapper">

                {{ $appointments->links() }}

            </div>

        @endif

    </div>


    {{-- =========================================================
        MODAL CREAR CITA
    ========================================================== --}}

    <div
        id="modalCreateAppointment"
        class="modal-overlay"
        onclick="closeModalOutside(event, 'modalCreateAppointment')"
    >

        <div class="modal-container">

            <div class="modal-header">

                <div>

                    <p class="modal-eyebrow">
                        Nueva cita
                    </p>

                    <h2>
                        Registrar cita médica
                    </h2>

                    <p>
                        Completa la información para registrar la cita.
                    </p>

                </div>

                <button
                    type="button"
                    class="modal-close"
                    onclick="closeModal('modalCreateAppointment')"
                >
                    ×
                </button>

            </div>


            <form
                method="POST"
                action="{{ route('appointments.store') }}"
                id="createAppointmentForm"
            >

                @csrf

                <div class="modal-body">

                    {{-- PACIENTE SOLO ADMIN --}}
                    @if(auth()->user()->role === 'admin')

                        <div class="form-group">

                            <label for="create_patient_id">
                                Paciente
                                <span class="required">*</span>
                            </label>

                            <select
                                name="patient_id"
                                id="create_patient_id"
                                class="form-control"
                                required
                            >

                                <option value="">
                                    Selecciona un paciente
                                </option>

                                @foreach($patients as $patient)

                                    <option
                                        value="{{ $patient->id }}"
                                        @selected(old('patient_id') == $patient->id)
                                    >

                                        {{ $patient->nombres }}
                                        {{ $patient->apellidos }}
                                        —
                                        {{ $patient->numero_documento }}

                                    </option>

                                @endforeach

                            </select>

                            <small class="form-help">
                                Selecciona el paciente al que se le registrará la cita.
                            </small>

                        </div>

                    @endif


                    {{-- ESPECIALIDAD --}}
                    <div class="form-group">

                        <label for="create_specialty_id">
                            Especialidad
                            <span class="required">*</span>
                        </label>

                        <select
                            name="specialty_id"
                            id="create_specialty_id"
                            class="form-control"
                            required
                        >

                            <option value="">
                                Selecciona una especialidad
                            </option>

                            @foreach($specialties as $specialty)

                                <option
                                    value="{{ $specialty->id }}"
                                    @selected(old('specialty_id') == $specialty->id)
                                >
                                    {{ $specialty->nombre }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- MÉDICO --}}
                    <div class="form-group">

                        <label for="create_doctor_id">
                            Médico
                            <span class="required">*</span>
                        </label>

                        <select
                            name="doctor_id"
                            id="create_doctor_id"
                            class="form-control"
                            required
                            disabled
                        >

                            <option value="">
                                Primero selecciona una especialidad
                            </option>

                        </select>

                    </div>


                    <div class="form-row">

                        {{-- FECHA --}}
                        <div class="form-group">

                            <label for="create_fecha">
                                Fecha
                                <span class="required">*</span>
                            </label>

                            <input
                                type="date"
                                name="fecha"
                                id="create_fecha"
                                class="form-control"
                                value="{{ old('fecha') }}"
                                min="{{ now()->format('Y-m-d') }}"
                                required
                            >

                        </div>


                        {{-- HORA --}}
                        <div class="form-group">

                            <label for="create_hora">
                                Hora
                                <span class="required">*</span>
                            </label>

                            <input
                                type="time"
                                name="hora"
                                id="create_hora"
                                class="form-control"
                                value="{{ old('hora') }}"
                                required
                            >

                        </div>

                    </div>


                    {{-- MOTIVO --}}
                    <div class="form-group">

                        <label for="create_motivo_consulta">
                            Motivo de consulta
                            <span class="required">*</span>
                        </label>

                        <textarea
                            name="motivo_consulta"
                            id="create_motivo_consulta"
                            class="form-control textarea"
                            rows="4"
                            maxlength="255"
                            placeholder="Describe brevemente el motivo de la consulta"
                            required
                        >{{ old('motivo_consulta') }}</textarea>

                        <small class="form-help">
                            Máximo 255 caracteres.
                        </small>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        onclick="closeModal('modalCreateAppointment')"
                    >
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Registrar cita
                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- =========================================================
        MODALES DE CADA CITA
    ========================================================== --}}

    @foreach($appointments as $appointment)

        {{-- =====================================================
            MODAL VER
        ====================================================== --}}

        <div
            id="modalShowAppointment{{ $appointment->id }}"
            class="modal-overlay"
            onclick="closeModalOutside(event, 'modalShowAppointment{{ $appointment->id }}')"
        >

            <div class="modal-container">

                <div class="modal-header">

                    <div>

                        <p class="modal-eyebrow">
                            Información de la cita
                        </p>

                        <h2>
                            Detalle de la cita
                        </h2>

                        <p>
                            Consulta toda la información registrada.
                        </p>

                    </div>

                    <button
                        type="button"
                        class="modal-close"
                        onclick="closeModal('modalShowAppointment{{ $appointment->id }}')"
                    >
                        ×
                    </button>

                </div>


                <div class="modal-body">


                    {{-- =================================================
                        MENSAJE DE ESTADO PARA PACIENTE
                    ================================================== --}}

                    @if(auth()->user()->role === 'paciente')

                        @if($appointment->estado === 'confirmada')

                            <div class="appointment-status-message status-message-confirmed">

                                <div class="appointment-status-icon">
                                    ✓
                                </div>

                                <div>

                                    <strong>
                                        Tu cita ha sido confirmada
                                    </strong>

                                    <p>
                                        Tu cita médica está confirmada.
                                        Te esperamos en la fecha y hora programadas.
                                    </p>

                                </div>

                            </div>

                        @elseif($appointment->estado === 'pendiente')

                            <div class="appointment-status-message status-message-pending">

                                <div class="appointment-status-icon">
                                    !
                                </div>

                                <div>

                                    <strong>
                                        Tu cita está pendiente de confirmación
                                    </strong>

                                    <p>
                                        La solicitud fue registrada correctamente.
                                        Estamos a la espera de su confirmación.
                                    </p>

                                </div>

                            </div>

                        @elseif($appointment->estado === 'atendida')

                            <div class="appointment-status-message status-message-attended">

                                <div class="appointment-status-icon">
                                    ✓
                                </div>

                                <div>

                                    <strong>
                                        Cita atendida
                                    </strong>

                                    <p>
                                        Esta cita ya fue registrada como atendida.
                                    </p>

                                </div>

                            </div>

                        @elseif($appointment->estado === 'cancelada')

                            <div class="appointment-status-message status-message-cancelled">

                                <div class="appointment-status-icon">
                                    ×
                                </div>

                                <div>

                                    <strong>
                                        Esta cita fue cancelada
                                    </strong>

                                    <p>
                                        La cita ya no se encuentra disponible.
                                    </p>

                                </div>

                            </div>

                        @endif

                    @endif


                    {{-- =================================================
                        INFORMACIÓN DEL PACIENTE
                    ================================================== --}}

                    @if($appointment->patient)

                        <div class="detail-section">

                            <h3>
                                Información del paciente
                            </h3>

                            <div class="details-grid">

                                <div class="detail-item">

                                    <span>
                                        Nombre completo
                                    </span>

                                    <strong>
                                        {{ $appointment->patient->nombres }}
                                        {{ $appointment->patient->apellidos }}
                                    </strong>

                                </div>

                                <div class="detail-item">

                                    <span>
                                        Documento
                                    </span>

                                    <strong>
                                        {{ $appointment->patient->tipo_documento }}
                                        {{ $appointment->patient->numero_documento }}
                                    </strong>

                                </div>

                            </div>

                        </div>

                    @endif


                    {{-- =================================================
                        INFORMACIÓN MÉDICA
                    ================================================== --}}

                    <div class="detail-section">

                        <h3>
                            Información médica
                        </h3>

                        <div class="details-grid">

                            <div class="detail-item">

                                <span>
                                    Especialidad
                                </span>

                                <strong>
                                    {{ $appointment->specialty?->nombre ?? 'Sin especialidad' }}
                                </strong>

                            </div>

                            <div class="detail-item">

                                <span>
                                    Médico
                                </span>

                                <strong>

                                    @if($appointment->doctor)

                                        {{ $appointment->doctor->nombres }}
                                        {{ $appointment->doctor->apellidos }}

                                    @else

                                        Sin médico

                                    @endif

                                </strong>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        FECHA Y HORA
                    ================================================== --}}

                    <div class="detail-section">

                        <h3>
                            Fecha y hora
                        </h3>

                        <div class="details-grid">

                            <div class="detail-item">

                                <span>
                                    Fecha
                                </span>

                                <strong>
                                    {{ \Carbon\Carbon::parse($appointment->fecha)->format('d/m/Y') }}
                                </strong>

                            </div>

                            <div class="detail-item">

                                <span>
                                    Hora
                                </span>

                                <strong>
                                    {{ \Carbon\Carbon::parse($appointment->hora)->format('H:i') }}
                                </strong>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        MOTIVO
                    ================================================== --}}

                    <div class="detail-section">

                        <h3>
                            Motivo de consulta
                        </h3>

                        <div class="reason-detail">

                            {{ $appointment->motivo_consulta }}

                        </div>

                    </div>


                    {{-- =================================================
                        ESTADO
                    ================================================== --}}

                    <div class="detail-section">

                        <h3>
                            Estado de la cita
                        </h3>

                        <div>

                            @if($appointment->estado === 'pendiente')

                                <span class="status-badge status-pending">
                                    <span class="status-dot"></span>
                                    Pendiente
                                </span>

                            @elseif($appointment->estado === 'confirmada')

                                <span class="status-badge status-confirmed">
                                    <span class="status-dot"></span>
                                    Confirmada
                                </span>

                            @elseif($appointment->estado === 'atendida')

                                <span class="status-badge status-attended">
                                    <span class="status-dot"></span>
                                    Atendida
                                </span>

                            @elseif($appointment->estado === 'cancelada')

                                <span class="status-badge status-cancelled">
                                    <span class="status-dot"></span>
                                    Cancelada
                                </span>

                            @endif

                        </div>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        onclick="closeModal('modalShowAppointment{{ $appointment->id }}')"
                    >
                        Cerrar
                    </button>

                </div>

            </div>

        </div>


        {{-- =====================================================
            MODAL EDITAR
        ====================================================== --}}

        <div
            id="modalEditAppointment{{ $appointment->id }}"
            class="modal-overlay"
            onclick="closeModalOutside(event, 'modalEditAppointment{{ $appointment->id }}')"
        >

            <div class="modal-container">

                <div class="modal-header">

                    <div>

                        <p class="modal-eyebrow">
                            Editar cita
                        </p>

                        <h2>
                            Actualizar cita médica
                        </h2>

                        <p>
                            Modifica la información de la cita.
                        </p>

                    </div>

                    <button
                        type="button"
                        class="modal-close"
                        onclick="closeModal('modalEditAppointment{{ $appointment->id }}')"
                    >
                        ×
                    </button>

                </div>


                <form
                    method="POST"
                    action="{{ route('appointments.update', $appointment) }}"
                >

                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        {{-- PACIENTE ADMIN --}}
                        @if(auth()->user()->role === 'admin')

                            <div class="form-group">

                                <label for="edit_patient_id_{{ $appointment->id }}">
                                    Paciente
                                    <span class="required">*</span>
                                </label>

                                <select
                                    name="patient_id"
                                    id="edit_patient_id_{{ $appointment->id }}"
                                    class="form-control"
                                    required
                                >

                                    <option value="">
                                        Selecciona un paciente
                                    </option>

                                    @foreach($patients as $patient)

                                        <option
                                            value="{{ $patient->id }}"
                                            @selected($appointment->patient_id == $patient->id)
                                        >

                                            {{ $patient->nombres }}
                                            {{ $patient->apellidos }}
                                            —
                                            {{ $patient->numero_documento }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        @endif


                        {{-- ESPECIALIDAD --}}
                        <div class="form-group">

                            <label for="edit_specialty_id_{{ $appointment->id }}">
                                Especialidad
                                <span class="required">*</span>
                            </label>

                            <select
                                name="specialty_id"
                                id="edit_specialty_id_{{ $appointment->id }}"
                                class="form-control edit-specialty"
                                data-appointment="{{ $appointment->id }}"
                                required
                            >

                                <option value="">
                                    Selecciona una especialidad
                                </option>

                                @foreach($specialties as $specialty)

                                    <option
                                        value="{{ $specialty->id }}"
                                        @selected($appointment->specialty_id == $specialty->id)
                                    >
                                        {{ $specialty->nombre }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- MÉDICO --}}
                        <div class="form-group">

                            <label for="edit_doctor_id_{{ $appointment->id }}">
                                Médico
                                <span class="required">*</span>
                            </label>

                            <select
                                name="doctor_id"
                                id="edit_doctor_id_{{ $appointment->id }}"
                                class="form-control edit-doctor"
                                data-current="{{ $appointment->doctor_id }}"
                                required
                            >

                                @if($appointment->doctor)

                                    <option
                                        value="{{ $appointment->doctor->id }}"
                                        selected
                                    >

                                        {{ $appointment->doctor->nombres }}
                                        {{ $appointment->doctor->apellidos }}

                                    </option>

                                @else

                                    <option value="">
                                        Selecciona un médico
                                    </option>

                                @endif

                            </select>

                        </div>


                        <div class="form-row">

                            {{-- FECHA --}}
                            <div class="form-group">

                                <label for="edit_fecha_{{ $appointment->id }}">
                                    Fecha
                                    <span class="required">*</span>
                                </label>

                                <input
                                    type="date"
                                    name="fecha"
                                    id="edit_fecha_{{ $appointment->id }}"
                                    class="form-control"
                                    value="{{ \Carbon\Carbon::parse($appointment->fecha)->format('Y-m-d') }}"
                                    required
                                >

                            </div>


                            {{-- HORA --}}
                            <div class="form-group">

                                <label for="edit_hora_{{ $appointment->id }}">
                                    Hora
                                    <span class="required">*</span>
                                </label>

                                <input
                                    type="time"
                                    name="hora"
                                    id="edit_hora_{{ $appointment->id }}"
                                    class="form-control"
                                    value="{{ \Carbon\Carbon::parse($appointment->hora)->format('H:i') }}"
                                    required
                                >

                            </div>

                        </div>


                        {{-- MOTIVO --}}
                        <div class="form-group">

                            <label for="edit_motivo_{{ $appointment->id }}">
                                Motivo de consulta
                                <span class="required">*</span>
                            </label>

                            <textarea
                                name="motivo_consulta"
                                id="edit_motivo_{{ $appointment->id }}"
                                class="form-control textarea"
                                rows="4"
                                maxlength="255"
                                required
                            >{{ $appointment->motivo_consulta }}</textarea>

                        </div>


                        {{-- ESTADO --}}
                        <div class="form-group">

                            <label for="edit_estado_{{ $appointment->id }}">
                                Estado de la cita
                                <span class="required">*</span>
                            </label>

                            <select
                                id="edit_estado_{{ $appointment->id }}"
                                name="estado"
                                class="form-control"
                                required
                            >

                                <option
                                    value="pendiente"
                                    @selected($appointment->estado === 'pendiente')
                                >
                                    Pendiente
                                </option>

                                <option
                                    value="confirmada"
                                    @selected($appointment->estado === 'confirmada')
                                >
                                    Confirmada
                                </option>

                                <option
                                    value="atendida"
                                    @selected($appointment->estado === 'atendida')
                                >
                                    Atendida
                                </option>

                                <option
                                    value="cancelada"
                                    @selected($appointment->estado === 'cancelada')
                                >
                                    Cancelada
                                </option>

                            </select>

                            <small class="form-help">
                                Al seleccionar "Confirmada", el paciente podrá visualizar que su cita fue confirmada.
                            </small>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            onclick="closeModal('modalEditAppointment{{ $appointment->id }}')"
                        >
                            Cancelar
                        </button>

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Guardar cambios
                        </button>

                    </div>

                </form>

            </div>

        </div>


        {{-- =====================================================
            MODAL CANCELAR
        ====================================================== --}}

        <div
            id="modalCancelAppointment{{ $appointment->id }}"
            class="modal-overlay"
            onclick="closeModalOutside(event, 'modalCancelAppointment{{ $appointment->id }}')"
        >

            <div class="modal-container modal-small">

                <div class="modal-header">

                    <div>

                        <p class="modal-eyebrow">
                            Cancelar cita
                        </p>

                        <h2>
                            ¿Cancelar esta cita?
                        </h2>

                        <p>
                            Esta acción cambiará el estado de la cita a cancelada.
                        </p>

                    </div>

                    <button
                        type="button"
                        class="modal-close"
                        onclick="closeModal('modalCancelAppointment{{ $appointment->id }}')"
                    >
                        ×
                    </button>

                </div>


                <div class="modal-body">

                    <div class="cancel-warning">

                        <div class="cancel-warning-icon">
                            !
                        </div>

                        <div>

                            <strong>
                                Confirma la cancelación
                            </strong>

                            <p>
                                La cita del
                                <strong>
                                    {{ \Carbon\Carbon::parse($appointment->fecha)->format('d/m/Y') }}
                                </strong>
                                a las
                                <strong>
                                    {{ \Carbon\Carbon::parse($appointment->hora)->format('H:i') }}
                                </strong>
                                será marcada como cancelada.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        onclick="closeModal('modalCancelAppointment{{ $appointment->id }}')"
                    >
                        No, regresar
                    </button>

                    <form
                        method="POST"
                        action="{{ route('appointments.destroy', $appointment) }}"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger"
                        >
                            Sí, cancelar cita
                        </button>

                    </form>

                </div>

            </div>

        </div>

    @endforeach

</div>


{{-- =============================================================
    ESTILOS
============================================================= --}}

<style>

.appointments-module {
    width: 100%;
    max-width: 1450px;
    margin: 0 auto;
    padding: 10px 0 40px;
}


/* =============================================================
   HEADER
============================================================= */

.appointments-module .page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 25px;
}

.appointments-module .page-header-eyebrow {
    margin: 0 0 5px;
    color: #2563eb;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .04em;
    text-transform: uppercase;
}

.appointments-module .page-title {
    margin: 0;
    color: #111827;
    font-size: 28px;
    font-weight: 700;
    line-height: 1.2;
}

.appointments-module .page-description {
    margin: 7px 0 0;
    color: #6b7280;
    font-size: 14px;
}

.appointments-module .page-actions {
    display: flex;
    align-items: center;
}


/* =============================================================
   BOTONES
============================================================= */

.appointments-module .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 40px;
    padding: 9px 16px;
    border: 1px solid transparent;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: .2s ease;
}

.appointments-module .btn-primary {
    background: #2563eb;
    color: #ffffff;
}

.appointments-module .btn-primary:hover {
    background: #1d4ed8;
}

.appointments-module .btn-secondary {
    background: #ffffff;
    border-color: #d1d5db;
    color: #374151;
}

.appointments-module .btn-secondary:hover {
    background: #f9fafb;
}

.appointments-module .btn-danger {
    background: #dc2626;
    color: #ffffff;
}

.appointments-module .btn-danger:hover {
    background: #b91c1c;
}


/* =============================================================
   ALERTAS
============================================================= */

.appointments-module .alert {
    display: flex;
    align-items: flex-start;
    gap: 11px;
    margin-bottom: 18px;
    padding: 13px 15px;
    border-radius: 9px;
    font-size: 13px;
}

.appointments-module .alert-success {
    border: 1px solid #bbf7d0;
    background: #f0fdf4;
    color: #166534;
}

.appointments-module .alert-error {
    border: 1px solid #fecaca;
    background: #fef2f2;
    color: #991b1b;
}

.appointments-module .alert-icon {
    width: 24px;
    height: 24px;
    flex: 0 0 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: rgba(255,255,255,.65);
    font-weight: 700;
}

.appointments-module .alert ul {
    margin: 6px 0 0 18px;
    padding: 0;
}


/* =============================================================
   AVISO PACIENTE
============================================================= */

.appointments-module .patient-confirmation-banner {
    display: flex;
    align-items: center;
    gap: 13px;
    margin-bottom: 20px;
    padding: 15px 17px;
    border: 1px solid #bbf7d0;
    border-radius: 11px;
    background: #f0fdf4;
}

.appointments-module .patient-confirmation-icon {
    width: 38px;
    height: 38px;
    flex: 0 0 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #dcfce7;
    color: #15803d;
    font-size: 18px;
    font-weight: 700;
}

.appointments-module .patient-confirmation-content {
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.appointments-module .patient-confirmation-content strong {
    color: #166534;
    font-size: 14px;
    font-weight: 700;
}

.appointments-module .patient-confirmation-content p {
    margin: 0;
    color: #15803d;
    font-size: 12px;
}


/* =============================================================
   FILTROS
============================================================= */

.appointments-module .filters-card {
    margin-bottom: 20px;
    padding: 18px;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    background: #ffffff;
}

.appointments-module .filters-form {
    display: grid;
    grid-template-columns: 1.5fr 1fr 1fr auto;
    align-items: end;
    gap: 14px;
}

.appointments-module .filter-group,
.appointments-module .form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.appointments-module label {
    color: #374151;
    font-size: 12px;
    font-weight: 600;
}

.appointments-module .form-control {
    width: 100%;
    min-height: 40px;
    padding: 9px 11px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    background: #ffffff;
    color: #111827;
    font-size: 13px;
    outline: none;
    transition: .2s ease;
    box-sizing: border-box;
}

.appointments-module .form-control:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,.10);
}

.appointments-module .form-control:disabled {
    background: #f3f4f6;
    color: #9ca3af;
    cursor: not-allowed;
}

.appointments-module .textarea {
    min-height: 95px;
    resize: vertical;
}

.appointments-module .form-help {
    color: #6b7280;
    font-size: 11px;
}

.appointments-module .required {
    color: #dc2626;
}

.appointments-module .filter-actions {
    display: flex;
    gap: 8px;
}


/* =============================================================
   TABLA
============================================================= */

.appointments-module .table-card {
    overflow: hidden;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    background: #ffffff;
}

.appointments-module .table-header {
    padding: 19px 20px;
    border-bottom: 1px solid #e5e7eb;
}

.appointments-module .table-header h2 {
    margin: 0;
    color: #111827;
    font-size: 16px;
    font-weight: 700;
}

.appointments-module .table-header p {
    margin: 5px 0 0;
    color: #6b7280;
    font-size: 12px;
}

.appointments-module .table-responsive {
    width: 100%;
    overflow-x: auto;
}

.appointments-module .appointments-table {
    width: 100%;
    min-width: 1000px;
    border-collapse: collapse;
}

.appointments-module .appointments-table th {
    padding: 12px 15px;
    border-bottom: 1px solid #e5e7eb;
    background: #f9fafb;
    color: #6b7280;
    font-size: 11px;
    font-weight: 700;
    text-align: left;
    white-space: nowrap;
    text-transform: uppercase;
    letter-spacing: .03em;
}

.appointments-module .appointments-table td {
    padding: 14px 15px;
    border-bottom: 1px solid #f3f4f6;
    color: #374151;
    font-size: 12px;
    vertical-align: middle;
}

.appointments-module .appointments-table tbody tr:hover {
    background: #fafafa;
}

.appointments-module .table-primary-text {
    color: #111827;
    font-weight: 600;
}

.appointments-module .text-center {
    text-align: center !important;
}

.appointments-module .text-muted {
    color: #9ca3af;
}


/* =============================================================
   PACIENTE / MÉDICO
============================================================= */

.appointments-module .patient-cell {
    display: flex;
    align-items: center;
    gap: 9px;
}

.appointments-module .patient-avatar {
    width: 32px;
    height: 32px;
    flex: 0 0 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #eff6ff;
    color: #2563eb;
    font-size: 12px;
    font-weight: 700;
}

.appointments-module .patient-cell strong,
.appointments-module .doctor-cell strong {
    display: block;
    color: #111827;
    font-size: 12px;
    font-weight: 600;
}

.appointments-module .patient-cell span {
    display: block;
    margin-top: 2px;
    color: #6b7280;
    font-size: 11px;
}

.appointments-module .time-badge {
    display: inline-flex;
    align-items: center;
    padding: 5px 8px;
    border-radius: 6px;
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 11px;
    font-weight: 700;
}

.appointments-module .reason-cell {
    max-width: 190px;
    color: #6b7280;
    line-height: 1.4;
}


/* =============================================================
   ESTADOS
============================================================= */

.appointments-module .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 9px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
}

.appointments-module .status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
}

.appointments-module .status-pending {
    background: #fef3c7;
    color: #92400e;
}

.appointments-module .status-pending .status-dot {
    background: #f59e0b;
}

.appointments-module .status-confirmed {
    background: #dcfce7;
    color: #166534;
}

.appointments-module .status-confirmed .status-dot {
    background: #16a34a;
}

.appointments-module .status-attended {
    background: #dbeafe;
    color: #1e40af;
}

.appointments-module .status-attended .status-dot {
    background: #2563eb;
}

.appointments-module .status-cancelled {
    background: #fee2e2;
    color: #991b1b;
}

.appointments-module .status-cancelled .status-dot {
    background: #dc2626;
}


/* =============================================================
   ACCIONES
============================================================= */

.appointments-module .table-actions {
    display: flex;
    justify-content: center;
    gap: 5px;
}

.appointments-module .action-btn {
    padding: 6px 8px;
    border: 0;
    border-radius: 6px;
    background: transparent;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
}

.appointments-module .action-view {
    color: #2563eb;
}

.appointments-module .action-view:hover {
    background: #eff6ff;
}

.appointments-module .action-edit {
    color: #4b5563;
}

.appointments-module .action-edit:hover {
    background: #f3f4f6;
}

.appointments-module .action-delete {
    color: #dc2626;
}

.appointments-module .action-delete:hover {
    background: #fef2f2;
}


/* =============================================================
   EMPTY
============================================================= */

.appointments-module .empty-state {
    padding: 55px 20px !important;
    text-align: center;
}

.appointments-module .empty-icon {
    margin-bottom: 10px;
    font-size: 28px;
}

.appointments-module .empty-state strong {
    display: block;
    color: #374151;
    font-size: 14px;
}

.appointments-module .empty-state p {
    margin: 5px 0 0;
    color: #9ca3af;
    font-size: 12px;
}


/* =============================================================
   MODALES
============================================================= */

.appointments-module .modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: rgba(17, 24, 39, .48);
}

.appointments-module .modal-overlay.active {
    display: flex;
}

.appointments-module .modal-container {
    width: 100%;
    max-width: 650px;
    max-height: 92vh;
    overflow-y: auto;
    border-radius: 14px;
    background: #ffffff;
    box-shadow: 0 20px 50px rgba(0,0,0,.18);
}

.appointments-module .modal-small {
    max-width: 500px;
}

.appointments-module .modal-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 15px;
    padding: 20px 22px;
    border-bottom: 1px solid #e5e7eb;
}

.appointments-module .modal-eyebrow {
    margin: 0 0 4px;
    color: #2563eb;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .04em;
}

.appointments-module .modal-header h2 {
    margin: 0;
    color: #111827;
    font-size: 18px;
    font-weight: 700;
}

.appointments-module .modal-header p:last-child {
    margin: 5px 0 0;
    color: #6b7280;
    font-size: 12px;
}

.appointments-module .modal-close {
    width: 32px;
    height: 32px;
    flex: 0 0 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 0;
    border-radius: 7px;
    background: #f3f4f6;
    color: #6b7280;
    font-size: 21px;
    line-height: 1;
    cursor: pointer;
}

.appointments-module .modal-close:hover {
    background: #e5e7eb;
    color: #111827;
}

.appointments-module .modal-body {
    padding: 22px;
}

.appointments-module .modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 9px;
    padding: 16px 22px;
    border-top: 1px solid #e5e7eb;
    background: #fafafa;
}


/* =============================================================
   FORMULARIOS MODAL
============================================================= */

.appointments-module .modal-body > .form-group {
    margin-bottom: 17px;
}

.appointments-module .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-bottom: 0;
}


/* =============================================================
   DETALLES
============================================================= */

.appointments-module .detail-section {
    margin-bottom: 22px;
}

.appointments-module .detail-section:last-child {
    margin-bottom: 0;
}

.appointments-module .detail-section h3 {
    margin: 0 0 11px;
    color: #374151;
    font-size: 12px;
    font-weight: 700;
}

.appointments-module .details-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.appointments-module .detail-item {
    padding: 12px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    background: #fafafa;
}

.appointments-module .detail-item span {
    display: block;
    margin-bottom: 4px;
    color: #6b7280;
    font-size: 11px;
}

.appointments-module .detail-item strong {
    color: #111827;
    font-size: 13px;
}

.appointments-module .reason-detail {
    padding: 13px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    background: #fafafa;
    color: #374151;
    font-size: 13px;
    line-height: 1.6;
}


/* =============================================================
   MENSAJES DE ESTADO DENTRO DEL MODAL
============================================================= */

.appointments-module .appointment-status-message {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 22px;
    padding: 15px;
    border-radius: 10px;
}

.appointments-module .appointment-status-icon {
    width: 34px;
    height: 34px;
    flex: 0 0 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 16px;
    font-weight: 700;
}

.appointments-module .appointment-status-message strong {
    display: block;
    margin-bottom: 4px;
    font-size: 13px;
}

.appointments-module .appointment-status-message p {
    margin: 0;
    font-size: 12px;
    line-height: 1.5;
}


/* CONFIRMADA */

.appointments-module .status-message-confirmed {
    border: 1px solid #bbf7d0;
    background: #f0fdf4;
    color: #166534;
}

.appointments-module .status-message-confirmed .appointment-status-icon {
    background: #dcfce7;
    color: #15803d;
}


/* PENDIENTE */

.appointments-module .status-message-pending {
    border: 1px solid #fde68a;
    background: #fffbeb;
    color: #92400e;
}

.appointments-module .status-message-pending .appointment-status-icon {
    background: #fef3c7;
    color: #d97706;
}


/* ATENDIDA */

.appointments-module .status-message-attended {
    border: 1px solid #bfdbfe;
    background: #eff6ff;
    color: #1e40af;
}

.appointments-module .status-message-attended .appointment-status-icon {
    background: #dbeafe;
    color: #2563eb;
}


/* CANCELADA */

.appointments-module .status-message-cancelled {
    border: 1px solid #fecaca;
    background: #fef2f2;
    color: #991b1b;
}

.appointments-module .status-message-cancelled .appointment-status-icon {
    background: #fee2e2;
    color: #dc2626;
}


/* =============================================================
   CANCELACIÓN
============================================================= */

.appointments-module .cancel-warning {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 15px;
    border: 1px solid #fecaca;
    border-radius: 10px;
    background: #fef2f2;
}

.appointments-module .cancel-warning-icon {
    width: 34px;
    height: 34px;
    flex: 0 0 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #fee2e2;
    color: #dc2626;
    font-weight: 700;
}

.appointments-module .cancel-warning strong {
    color: #991b1b;
    font-size: 13px;
}

.appointments-module .cancel-warning p {
    margin: 5px 0 0;
    color: #b91c1c;
    font-size: 12px;
    line-height: 1.5;
}


/* =============================================================
   PAGINACIÓN
============================================================= */

.appointments-module .pagination-wrapper {
    padding: 16px 20px;
    border-top: 1px solid #e5e7eb;
}


/* =============================================================
   RESPONSIVE
============================================================= */

@media (max-width: 900px) {

    .appointments-module .filters-form {
        grid-template-columns: 1fr 1fr;
    }

    .appointments-module .filter-actions {
        grid-column: 1 / -1;
    }

}

@media (max-width: 700px) {

    .appointments-module .page-header {
        flex-direction: column;
    }

    .appointments-module .page-actions {
        width: 100%;
    }

    .appointments-module .page-actions .btn {
        width: 100%;
    }

    .appointments-module .filters-form {
        grid-template-columns: 1fr;
    }

    .appointments-module .filter-actions {
        grid-column: auto;
    }

    .appointments-module .filter-actions .btn {
        flex: 1;
    }

    .appointments-module .form-row {
        grid-template-columns: 1fr;
    }

    .appointments-module .details-grid {
        grid-template-columns: 1fr;
    }

}

@media (max-width: 500px) {

    .appointments-module .modal-overlay {
        padding: 10px;
    }

    .appointments-module .modal-container {
        max-height: 95vh;
    }

    .appointments-module .modal-header,
    .appointments-module .modal-body,
    .appointments-module .modal-footer {
        padding-left: 16px;
        padding-right: 16px;
    }

    .appointments-module .modal-footer {
        flex-direction: column;
    }

    .appointments-module .modal-footer .btn,
    .appointments-module .modal-footer form {
        width: 100%;
    }

    .appointments-module .modal-footer form .btn {
        width: 100%;
    }

}

</style>


{{-- =============================================================
    JAVASCRIPT
============================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | MODALES
    |--------------------------------------------------------------------------
    */

    window.openModal = function (modalId) {

        const modal = document.getElementById(modalId);

        if (!modal) {
            return;
        }

        modal.classList.add('active');

        document.body.style.overflow = 'hidden';
    };


    window.closeModal = function (modalId) {

        const modal = document.getElementById(modalId);

        if (!modal) {
            return;
        }

        modal.classList.remove('active');

        document.body.style.overflow = '';
    };


    window.closeModalOutside = function (event, modalId) {

        if (event.target.id === modalId) {

            closeModal(modalId);

        }

    };


    /*
    |--------------------------------------------------------------------------
    | ESCAPE
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', function (event) {

        if (event.key !== 'Escape') {
            return;
        }

        const activeModal =
            document.querySelector(
                '.appointments-module .modal-overlay.active'
            );

        if (activeModal) {

            activeModal.classList.remove('active');

            document.body.style.overflow = '';

        }

    });


    /*
    |--------------------------------------------------------------------------
    | CREAR CITA
    | ESPECIALIDAD -> MÉDICOS
    |--------------------------------------------------------------------------
    */

    const createSpecialty =
        document.getElementById('create_specialty_id');

    const createDoctor =
        document.getElementById('create_doctor_id');


    if (createSpecialty && createDoctor) {

        createSpecialty.addEventListener(
            'change',
            function () {

                const specialtyId = this.value;

                createDoctor.innerHTML = '';

                if (!specialtyId) {

                    createDoctor.disabled = true;

                    createDoctor.innerHTML = `
                        <option value="">
                            Primero selecciona una especialidad
                        </option>
                    `;

                    return;
                }


                createDoctor.disabled = true;

                createDoctor.innerHTML = `
                    <option value="">
                        Cargando médicos...
                    </option>
                `;


                fetch(
                    `/appointments/doctors/${specialtyId}`,
                    {
                        headers: {
                            'Accept': 'application/json'
                        }
                    }
                )
                .then(response => {

                    if (!response.ok) {

                        throw new Error(
                            'No fue posible cargar los médicos.'
                        );

                    }

                    return response.json();

                })
                .then(data => {

                    createDoctor.innerHTML = '';

                    const doctors = data.data || [];


                    if (doctors.length === 0) {

                        createDoctor.disabled = true;

                        createDoctor.innerHTML = `
                            <option value="">
                                No hay médicos disponibles
                            </option>
                        `;

                        return;

                    }


                    createDoctor.disabled = false;

                    createDoctor.innerHTML = `
                        <option value="">
                            Selecciona un médico
                        </option>
                    `;


                    doctors.forEach(doctor => {

                        const option =
                            document.createElement('option');

                        option.value = doctor.id;

                        option.textContent =
                            `${doctor.nombres} ${doctor.apellidos}`;

                        createDoctor.appendChild(option);

                    });

                })
                .catch(error => {

                    console.error(error);

                    createDoctor.disabled = true;

                    createDoctor.innerHTML = `
                        <option value="">
                            Error al cargar médicos
                        </option>
                    `;

                });

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | EDITAR CITAS
    | ESPECIALIDAD -> MÉDICOS
    |--------------------------------------------------------------------------
    */

    const editSpecialties =
        document.querySelectorAll('.edit-specialty');


    editSpecialties.forEach(function (specialtySelect) {

        specialtySelect.addEventListener(
            'change',
            function () {

                const appointmentId =
                    this.dataset.appointment;

                const doctorSelect =
                    document.getElementById(
                        `edit_doctor_id_${appointmentId}`
                    );

                if (!doctorSelect) {
                    return;
                }

                const specialtyId = this.value;

                doctorSelect.innerHTML = '';

                if (!specialtyId) {

                    doctorSelect.disabled = true;

                    doctorSelect.innerHTML = `
                        <option value="">
                            Primero selecciona una especialidad
                        </option>
                    `;

                    return;

                }


                doctorSelect.disabled = true;

                doctorSelect.innerHTML = `
                    <option value="">
                        Cargando médicos...
                    </option>
                `;


                fetch(
                    `/appointments/doctors/${specialtyId}`,
                    {
                        headers: {
                            'Accept': 'application/json'
                        }
                    }
                )
                .then(response => {

                    if (!response.ok) {

                        throw new Error(
                            'No fue posible cargar los médicos.'
                        );

                    }

                    return response.json();

                })
                .then(data => {

                    doctorSelect.innerHTML = '';

                    const doctors = data.data || [];

                    const currentDoctor =
                        doctorSelect.dataset.current;


                    if (doctors.length === 0) {

                        doctorSelect.disabled = true;

                        doctorSelect.innerHTML = `
                            <option value="">
                                No hay médicos disponibles
                            </option>
                        `;

                        return;

                    }


                    doctorSelect.disabled = false;

                    doctorSelect.innerHTML = `
                        <option value="">
                            Selecciona un médico
                        </option>
                    `;


                    doctors.forEach(doctor => {

                        const option =
                            document.createElement('option');

                        option.value = doctor.id;

                        option.textContent =
                            `${doctor.nombres} ${doctor.apellidos}`;


                        if (
                            String(doctor.id) ===
                            String(currentDoctor)
                        ) {

                            option.selected = true;

                        }


                        doctorSelect.appendChild(option);

                    });

                })
                .catch(error => {

                    console.error(error);

                    doctorSelect.disabled = true;

                    doctorSelect.innerHTML = `
                        <option value="">
                            Error al cargar médicos
                        </option>
                    `;

                });

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | ABRIR AUTOMÁTICAMENTE MODAL DE CREACIÓN
    | CUANDO HAY ERRORES DE VALIDACIÓN
    |--------------------------------------------------------------------------
    */

    @if($errors->any())

        const createModal =
            document.getElementById(
                'modalCreateAppointment'
            );

        if (createModal) {

            createModal.classList.add('active');

            document.body.style.overflow = 'hidden';

        }

    @endif


    /*
    |--------------------------------------------------------------------------
    | RESTAURAR ESPECIALIDAD DESPUÉS DE ERROR
    |--------------------------------------------------------------------------
    */

    const oldSpecialty =
        @json(old('specialty_id'));

    const oldDoctor =
        @json(old('doctor_id'));


    if (
        oldSpecialty &&
        createSpecialty &&
        createDoctor
    ) {

        createSpecialty.value = oldSpecialty;

        createSpecialty.dispatchEvent(
            new Event('change')
        );


        const waitForDoctor =
            setInterval(function () {

                const option =
                    createDoctor.querySelector(
                        `option[value="${oldDoctor}"]`
                    );


                if (option) {

                    createDoctor.value = oldDoctor;

                    clearInterval(waitForDoctor);

                }

            }, 100);


        setTimeout(function () {

            clearInterval(waitForDoctor);

        }, 5000);

    }

});

</script>

@endsection
