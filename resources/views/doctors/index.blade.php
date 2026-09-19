@extends('layouts.app')

@section('title', 'Médicos')

@section('content')

<div class="doctors-module">

    {{-- =========================================================
        ENCABEZADO
    ========================================================== --}}
    <div class="page-header">

        <div>
            <p class="page-header-eyebrow">Gestión de médicos</p>

            <h1 class="page-title">
                Médicos
            </h1>

            <p class="page-description">
                Administra los médicos y profesionales disponibles para la gestión de citas.
            </p>
        </div>

        <div class="page-actions">
            <button
                type="button"
                class="btn btn-primary"
                onclick="openModal('modalCreateDoctor')"
            >
                + Nuevo médico
            </button>
        </div>

    </div>


    {{-- =========================================================
        MENSAJES
    ========================================================== --}}
    @if(session('success'))
        <div class="alert alert-success">
            <div class="alert-icon">✓</div>

            <div>
                <strong>Operación realizada</strong>
                <p>{{ session('success') }}</p>
            </div>

            <button
                type="button"
                class="alert-close"
                onclick="this.parentElement.remove()"
            >
                ×
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <div class="alert-icon">!</div>

            <div>
                <strong>No fue posible realizar la operación</strong>
                <p>{{ session('error') }}</p>
            </div>

            <button
                type="button"
                class="alert-close"
                onclick="this.parentElement.remove()"
            >
                ×
            </button>
        </div>
    @endif


    {{-- =========================================================
        FILTROS
    ========================================================== --}}
    <div class="filter-card">

        <form
            action="{{ route('doctors.index') }}"
            method="GET"
            class="filter-form"
        >

            <div class="filter-group search-group">

                <label for="buscar" class="filter-label">
                    Buscar médico
                </label>

                <div class="search-input-wrapper">

                    <span class="search-icon">
                        ⌕
                    </span>

                    <input
                        type="text"
                        id="buscar"
                        name="buscar"
                        value="{{ request('buscar') }}"
                        class="form-control"
                        placeholder="Nombre o apellido..."
                    >

                </div>

            </div>


            <div class="filter-group">

                <label for="especialidad" class="filter-label">
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
                            @selected((string) request('especialidad') === (string) $specialty->id)
                        >
                            {{ $specialty->nombre }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="filter-actions">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Buscar
                </button>

                @if(request('buscar') || request('especialidad'))

                    <a
                        href="{{ route('doctors.index') }}"
                        class="btn btn-secondary"
                    >
                        Limpiar
                    </a>

                @endif

            </div>

        </form>

    </div>


    {{-- =========================================================
        TABLA
    ========================================================== --}}
    <div class="table-card">

        <div class="table-card-header">

            <div>
                <h2 class="table-card-title">
                    Listado de médicos
                </h2>

                <p class="table-card-description">
                    Médicos registrados en el sistema.
                </p>
            </div>

            <div class="table-counter">
                {{ $doctors->total() }}
                {{ $doctors->total() == 1 ? 'médico' : 'médicos' }}
            </div>

        </div>


        @if($doctors->count())

            <div class="table-wrapper">

                <table class="data-table">

                    <thead>
                        <tr>

                            <th>
                                Médico
                            </th>

                            <th>
                                Identificación
                            </th>

                            <th>
                                Especialidad
                            </th>

                            <th>
                                Registro profesional
                            </th>

                            <th>
                                Contacto
                            </th>

                            <th>
                                Estado
                            </th>

                            <th class="text-right">
                                Acciones
                            </th>

                        </tr>
                    </thead>

                    <tbody>

                        @foreach($doctors as $doctor)

                            <tr>

                                {{-- Médico --}}
                                <td>

                                    <div class="doctor-cell">

                                        <div class="doctor-avatar">
                                            {{ strtoupper(substr($doctor->nombres, 0, 1)) }}
                                        </div>

                                        <div class="doctor-info">

                                            <strong>
                                                Dr(a). {{ $doctor->nombres }} {{ $doctor->apellidos }}
                                            </strong>

                                            <span>
                                                Profesional médico
                                            </span>

                                        </div>

                                    </div>

                                </td>


                                {{-- Identificación --}}
                                <td>

                                    <span class="table-main-text">
                                        {{ $doctor->numero_identificacion }}
                                    </span>

                                </td>


                                {{-- Especialidad --}}
                                <td>

                                    @if($doctor->specialty)

                                        <span class="specialty-badge">
                                            {{ $doctor->specialty->nombre }}
                                        </span>

                                    @else

                                        <span class="table-muted">
                                            Sin especialidad
                                        </span>

                                    @endif

                                </td>


                                {{-- Registro profesional --}}
                                <td>

                                    <span class="table-main-text">
                                        {{ $doctor->registro_profesional }}
                                    </span>

                                </td>


                                {{-- Contacto --}}
                                <td>

                                    <div class="contact-cell">

                                        <span>
                                            {{ $doctor->telefono }}
                                        </span>

                                        <small>
                                            {{ $doctor->correo }}
                                        </small>

                                    </div>

                                </td>


                                {{-- Estado --}}
                                <td>

                                    @if($doctor->estado === 'activo')

                                        <span class="status-badge status-active">
                                            <span class="status-dot"></span>
                                            Activo
                                        </span>

                                    @else

                                        <span class="status-badge status-inactive">
                                            <span class="status-dot"></span>
                                            Inactivo
                                        </span>

                                    @endif

                                </td>


                                {{-- Acciones --}}
                                <td>

                                    <div class="action-buttons">

                                        {{-- Ver --}}
                                        <button
                                            type="button"
                                            class="action-btn action-view"
                                            title="Ver médico"
                                            onclick="openModal('modalShowDoctor{{ $doctor->id }}')"
                                        >
                                            Ver
                                        </button>


                                        {{-- Editar --}}
                                        <button
                                            type="button"
                                            class="action-btn action-edit"
                                            title="Editar médico"
                                            onclick="openModal('modalEditDoctor{{ $doctor->id }}')"
                                        >
                                            Editar
                                        </button>


                                        {{-- Eliminar --}}
                                        <button
                                            type="button"
                                            class="action-btn action-delete"
                                            title="Eliminar médico"
                                            onclick="openModal('modalDeleteDoctor{{ $doctor->id }}')"
                                        >
                                            Eliminar
                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- Paginación --}}
            @if($doctors->hasPages())

                <div class="pagination-container">

                    {{ $doctors->links() }}

                </div>

            @endif

        @else

            <div class="empty-state">

                <div class="empty-icon">
                    +
                </div>

                <h3>
                    No hay médicos registrados
                </h3>

                <p>
                    @if(request('buscar') || request('especialidad'))
                        No encontramos médicos que coincidan con los filtros seleccionados.
                    @else
                        Comienza registrando el primer médico del sistema.
                    @endif
                </p>

                @if(request('buscar') || request('especialidad'))

                    <a
                        href="{{ route('doctors.index') }}"
                        class="btn btn-secondary"
                    >
                        Limpiar filtros
                    </a>

                @else

                    <button
                        type="button"
                        class="btn btn-primary"
                        onclick="openModal('modalCreateDoctor')"
                    >
                        Registrar primer médico
                    </button>

                @endif

            </div>

        @endif

    </div>

</div>


{{-- =============================================================
    MODAL CREAR MÉDICO
============================================================= --}}
<div
    id="modalCreateDoctor"
    class="modal-overlay"
    onclick="closeModalOnOverlay(event, 'modalCreateDoctor')"
>

    <div class="modal-container modal-large">

        <div class="modal-header">

            <div>
                <p class="modal-eyebrow">
                    Médicos
                </p>

                <h2 class="modal-title">
                    Registrar médico
                </h2>

                <p class="modal-description">
                    Completa los datos del profesional médico.
                </p>
            </div>

            <button
                type="button"
                class="modal-close"
                onclick="closeModal('modalCreateDoctor')"
            >
                ×
            </button>

        </div>


        <form
            action="{{ route('doctors.store') }}"
            method="POST"
            novalidate
        >

            @csrf

            <div class="modal-body">

                <section class="modal-section">

                    <div class="modal-section-header">

                        <h3>
                            Información profesional
                        </h3>

                        <p>
                            Datos utilizados para identificar al médico.
                        </p>

                    </div>


                    <div class="form-grid">

                        <div class="form-group">

                            <label for="create_nombres" class="form-label">
                                Nombres
                                <span class="form-required">*</span>
                            </label>

                            <input
                                type="text"
                                id="create_nombres"
                                name="nombres"
                                value="{{ old('nombres') }}"
                                class="form-control @error('nombres') is-invalid @enderror"
                                maxlength="100"
                                required
                            >

                            @error('nombres')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>


                        <div class="form-group">

                            <label for="create_apellidos" class="form-label">
                                Apellidos
                                <span class="form-required">*</span>
                            </label>

                            <input
                                type="text"
                                id="create_apellidos"
                                name="apellidos"
                                value="{{ old('apellidos') }}"
                                class="form-control @error('apellidos') is-invalid @enderror"
                                maxlength="100"
                                required
                            >

                            @error('apellidos')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>


                        <div class="form-group">

                            <label for="create_numero_identificacion" class="form-label">
                                Número de identificación
                                <span class="form-required">*</span>
                            </label>

                            <input
                                type="text"
                                id="create_numero_identificacion"
                                name="numero_identificacion"
                                value="{{ old('numero_identificacion') }}"
                                class="form-control @error('numero_identificacion') is-invalid @enderror"
                                maxlength="30"
                                required
                            >

                            @error('numero_identificacion')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>


                        <div class="form-group">

                            <label for="create_registro_profesional" class="form-label">
                                Registro profesional
                                <span class="form-required">*</span>
                            </label>

                            <input
                                type="text"
                                id="create_registro_profesional"
                                name="registro_profesional"
                                value="{{ old('registro_profesional') }}"
                                class="form-control @error('registro_profesional') is-invalid @enderror"
                                maxlength="50"
                                required
                            >

                            @error('registro_profesional')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>


                        <div class="form-group form-group-full">

                            <label for="create_specialty_id" class="form-label">
                                Especialidad
                                <span class="form-required">*</span>
                            </label>

                            <select
                                id="create_specialty_id"
                                name="specialty_id"
                                class="form-control @error('specialty_id') is-invalid @enderror"
                                required
                            >

                                <option value="">
                                    Selecciona una especialidad
                                </option>

                                @foreach($specialties as $specialty)

                                    <option
                                        value="{{ $specialty->id }}"
                                        @selected((string) old('specialty_id') === (string) $specialty->id)
                                    >
                                        {{ $specialty->nombre }}
                                    </option>

                                @endforeach

                            </select>

                            @error('specialty_id')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>

                </section>


                <section class="modal-section">

                    <div class="modal-section-header">

                        <h3>
                            Información de contacto
                        </h3>

                        <p>
                            Datos utilizados para comunicarnos con el profesional.
                        </p>

                    </div>


                    <div class="form-grid">

                        <div class="form-group">

                            <label for="create_telefono" class="form-label">
                                Teléfono
                                <span class="form-required">*</span>
                            </label>

                            <input
                                type="tel"
                                id="create_telefono"
                                name="telefono"
                                value="{{ old('telefono') }}"
                                class="form-control @error('telefono') is-invalid @enderror"
                                maxlength="20"
                                required
                            >

                            @error('telefono')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>


                        <div class="form-group">

                            <label for="create_correo" class="form-label">
                                Correo electrónico
                                <span class="form-required">*</span>
                            </label>

                            <input
                                type="email"
                                id="create_correo"
                                name="correo"
                                value="{{ old('correo') }}"
                                class="form-control @error('correo') is-invalid @enderror"
                                maxlength="150"
                                required
                            >

                            @error('correo')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>

                </section>


                <section class="modal-section">

                    <div class="modal-section-header">

                        <h3>
                            Estado del registro
                        </h3>

                        <p>
                            Los médicos nuevos se registran automáticamente como activos.
                        </p>

                    </div>


                    <div class="status-preview">

                        <div
                            class="status-preview-indicator"
                            aria-hidden="true"
                        ></div>

                        <div class="status-preview-text">

                            <strong>
                                Médico activo
                            </strong>

                            <span>
                                Podrá ser seleccionado posteriormente para programar una cita.
                            </span>

                        </div>

                    </div>

                </section>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    onclick="closeModal('modalCreateDoctor')"
                >
                    Cancelar
                </button>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Registrar médico
                </button>

            </div>

        </form>

    </div>

</div>


{{-- =============================================================
    MODALES VER / EDITAR / ELIMINAR
============================================================= --}}

@foreach($doctors as $doctor)

    {{-- =========================
         VER MÉDICO
    ========================== --}}
    <div
        id="modalShowDoctor{{ $doctor->id }}"
        class="modal-overlay"
        onclick="closeModalOnOverlay(event, 'modalShowDoctor{{ $doctor->id }}')"
    >

        <div class="modal-container">

            <div class="modal-header">

                <div>
                    <p class="modal-eyebrow">
                        Información del médico
                    </p>

                    <h2 class="modal-title">
                        Dr(a). {{ $doctor->nombres }} {{ $doctor->apellidos }}
                    </h2>

                    <p class="modal-description">
                        Información registrada del profesional.
                    </p>
                </div>

                <button
                    type="button"
                    class="modal-close"
                    onclick="closeModal('modalShowDoctor{{ $doctor->id }}')"
                >
                    ×
                </button>

            </div>


            <div class="modal-body">

                <div class="doctor-profile">

                    <div class="doctor-profile-avatar">
                        {{ strtoupper(substr($doctor->nombres, 0, 1)) }}
                    </div>

                    <div>

                        <h3>
                            Dr(a). {{ $doctor->nombres }} {{ $doctor->apellidos }}
                        </h3>

                        @if($doctor->specialty)
                            <p>
                                {{ $doctor->specialty->nombre }}
                            </p>
                        @endif

                    </div>

                </div>


                <div class="detail-grid">

                    <div class="detail-item">
                        <span class="detail-label">
                            Identificación
                        </span>

                        <strong>
                            {{ $doctor->numero_identificacion }}
                        </strong>
                    </div>


                    <div class="detail-item">
                        <span class="detail-label">
                            Registro profesional
                        </span>

                        <strong>
                            {{ $doctor->registro_profesional }}
                        </strong>
                    </div>


                    <div class="detail-item">
                        <span class="detail-label">
                            Especialidad
                        </span>

                        <strong>
                            {{ $doctor->specialty?->nombre ?? 'Sin especialidad' }}
                        </strong>
                    </div>


                    <div class="detail-item">
                        <span class="detail-label">
                            Estado
                        </span>

                        @if($doctor->estado === 'activo')

                            <span class="status-badge status-active">
                                <span class="status-dot"></span>
                                Activo
                            </span>

                        @else

                            <span class="status-badge status-inactive">
                                <span class="status-dot"></span>
                                Inactivo
                            </span>

                        @endif

                    </div>


                    <div class="detail-item">
                        <span class="detail-label">
                            Teléfono
                        </span>

                        <strong>
                            {{ $doctor->telefono }}
                        </strong>
                    </div>


                    <div class="detail-item">
                        <span class="detail-label">
                            Correo electrónico
                        </span>

                        <strong>
                            {{ $doctor->correo }}
                        </strong>
                    </div>


                    <div class="detail-item">
                        <span class="detail-label">
                            Citas registradas
                        </span>

                        <strong>
                            {{ $doctor->appointments->count() }}
                        </strong>
                    </div>

                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    onclick="closeModal('modalShowDoctor{{ $doctor->id }}')"
                >
                    Cerrar
                </button>

                <button
                    type="button"
                    class="btn btn-primary"
                    onclick="
                        closeModal('modalShowDoctor{{ $doctor->id }}');
                        openModal('modalEditDoctor{{ $doctor->id }}');
                    "
                >
                    Editar médico
                </button>

            </div>

        </div>

    </div>


    {{-- =========================
         EDITAR MÉDICO
    ========================== --}}
    <div
        id="modalEditDoctor{{ $doctor->id }}"
        class="modal-overlay"
        onclick="closeModalOnOverlay(event, 'modalEditDoctor{{ $doctor->id }}')"
    >

        <div class="modal-container modal-large">

            <div class="modal-header">

                <div>
                    <p class="modal-eyebrow">
                        Médicos
                    </p>

                    <h2 class="modal-title">
                        Editar médico
                    </h2>

                    <p class="modal-description">
                        Actualiza la información del profesional.
                    </p>
                </div>

                <button
                    type="button"
                    class="modal-close"
                    onclick="closeModal('modalEditDoctor{{ $doctor->id }}')"
                >
                    ×
                </button>

            </div>


            <form
                action="{{ route('doctors.update', $doctor) }}"
                method="POST"
                novalidate
            >

                @csrf
                @method('PUT')

                <div class="modal-body">

                    <section class="modal-section">

                        <div class="modal-section-header">

                            <h3>
                                Información profesional
                            </h3>

                            <p>
                                Datos utilizados para identificar al médico.
                            </p>

                        </div>


                        <div class="form-grid">

                            <div class="form-group">

                                <label
                                    for="edit_nombres_{{ $doctor->id }}"
                                    class="form-label"
                                >
                                    Nombres
                                    <span class="form-required">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="edit_nombres_{{ $doctor->id }}"
                                    name="nombres"
                                    value="{{ old('nombres', $doctor->nombres) }}"
                                    class="form-control"
                                    maxlength="100"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label
                                    for="edit_apellidos_{{ $doctor->id }}"
                                    class="form-label"
                                >
                                    Apellidos
                                    <span class="form-required">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="edit_apellidos_{{ $doctor->id }}"
                                    name="apellidos"
                                    value="{{ old('apellidos', $doctor->apellidos) }}"
                                    class="form-control"
                                    maxlength="100"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label
                                    for="edit_identificacion_{{ $doctor->id }}"
                                    class="form-label"
                                >
                                    Número de identificación
                                    <span class="form-required">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="edit_identificacion_{{ $doctor->id }}"
                                    name="numero_identificacion"
                                    value="{{ old('numero_identificacion', $doctor->numero_identificacion) }}"
                                    class="form-control"
                                    maxlength="30"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label
                                    for="edit_registro_{{ $doctor->id }}"
                                    class="form-label"
                                >
                                    Registro profesional
                                    <span class="form-required">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="edit_registro_{{ $doctor->id }}"
                                    name="registro_profesional"
                                    value="{{ old('registro_profesional', $doctor->registro_profesional) }}"
                                    class="form-control"
                                    maxlength="50"
                                    required
                                >

                            </div>


                            <div class="form-group form-group-full">

                                <label
                                    for="edit_specialty_{{ $doctor->id }}"
                                    class="form-label"
                                >
                                    Especialidad
                                    <span class="form-required">*</span>
                                </label>

                                <select
                                    id="edit_specialty_{{ $doctor->id }}"
                                    name="specialty_id"
                                    class="form-control"
                                    required
                                >

                                    @foreach($specialties as $specialty)

                                        <option
                                            value="{{ $specialty->id }}"
                                            @selected((string) old('specialty_id', $doctor->specialty_id) === (string) $specialty->id)
                                        >
                                            {{ $specialty->nombre }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </section>


                    <section class="modal-section">

                        <div class="modal-section-header">

                            <h3>
                                Información de contacto
                            </h3>

                            <p>
                                Datos de contacto del profesional.
                            </p>

                        </div>


                        <div class="form-grid">

                            <div class="form-group">

                                <label
                                    for="edit_telefono_{{ $doctor->id }}"
                                    class="form-label"
                                >
                                    Teléfono
                                    <span class="form-required">*</span>
                                </label>

                                <input
                                    type="tel"
                                    id="edit_telefono_{{ $doctor->id }}"
                                    name="telefono"
                                    value="{{ old('telefono', $doctor->telefono) }}"
                                    class="form-control"
                                    maxlength="20"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label
                                    for="edit_correo_{{ $doctor->id }}"
                                    class="form-label"
                                >
                                    Correo electrónico
                                    <span class="form-required">*</span>
                                </label>

                                <input
                                    type="email"
                                    id="edit_correo_{{ $doctor->id }}"
                                    name="correo"
                                    value="{{ old('correo', $doctor->correo) }}"
                                    class="form-control"
                                    maxlength="150"
                                    required
                                >

                            </div>

                        </div>

                    </section>


                    <section class="modal-section">

                        <div class="modal-section-header">

                            <h3>
                                Estado
                            </h3>

                            <p>
                                Controla la disponibilidad del médico en el sistema.
                            </p>

                        </div>


                        <div class="form-group">

                            <label
                                for="edit_estado_{{ $doctor->id }}"
                                class="form-label"
                            >
                                Estado del médico
                            </label>

                            <select
                                id="edit_estado_{{ $doctor->id }}"
                                name="estado"
                                class="form-control"
                            >

                                <option
                                    value="activo"
                                    @selected(old('estado', $doctor->estado) === 'activo')
                                >
                                    Activo
                                </option>

                                <option
                                    value="inactivo"
                                    @selected(old('estado', $doctor->estado) === 'inactivo')
                                >
                                    Inactivo
                                </option>

                            </select>

                        </div>

                    </section>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        onclick="closeModal('modalEditDoctor{{ $doctor->id }}')"
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


    {{-- =========================
         ELIMINAR MÉDICO
    ========================== --}}
    <div
        id="modalDeleteDoctor{{ $doctor->id }}"
        class="modal-overlay"
        onclick="closeModalOnOverlay(event, 'modalDeleteDoctor{{ $doctor->id }}')"
    >

        <div class="modal-container modal-small">

            <div class="confirm-modal">

                <div class="confirm-icon">
                    !
                </div>

                <h2>
                    ¿Eliminar médico?
                </h2>

                <p>
                    Estás a punto de eliminar a
                    <strong>
                        Dr(a). {{ $doctor->nombres }} {{ $doctor->apellidos }}
                    </strong>.
                </p>

                <p class="confirm-warning">
                    Si el médico tiene citas registradas, el sistema impedirá su eliminación.
                </p>

                <div class="modal-footer confirm-actions">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        onclick="closeModal('modalDeleteDoctor{{ $doctor->id }}')"
                    >
                        Cancelar
                    </button>

                    <form
                        action="{{ route('doctors.destroy', $doctor) }}"
                        method="POST"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger"
                        >
                            Eliminar médico
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

@endforeach


{{-- =============================================================
    ESTILOS
============================================================= --}}
@push('styles')

<style>

    .doctors-module {
        width: 100%;
    }

    .doctors-module .page-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 28px;
    }

    .doctors-module .page-header-eyebrow {
        margin: 0 0 6px;
        color: #2563eb;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .doctors-module .page-title {
        margin: 0;
        color: #111827;
        font-size: 30px;
        line-height: 1.2;
        font-weight: 700;
    }

    .doctors-module .page-description {
        margin: 8px 0 0;
        color: #6b7280;
        font-size: 14px;
    }

    .doctors-module .page-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }


    /* =========================================================
       BOTONES
    ========================================================== */

    .doctors-module .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: 0 17px;
        border-radius: 9px;
        border: 1px solid transparent;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: .18s ease;
        font-family: inherit;
    }

    .doctors-module .btn-primary {
        background: #2563eb;
        border-color: #2563eb;
        color: #fff;
    }

    .doctors-module .btn-primary:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
    }

    .doctors-module .btn-secondary {
        background: #fff;
        border-color: #d1d5db;
        color: #374151;
    }

    .doctors-module .btn-secondary:hover {
        background: #f9fafb;
        border-color: #9ca3af;
    }

    .doctors-module .btn-danger {
        background: #dc2626;
        border-color: #dc2626;
        color: #fff;
    }

    .doctors-module .btn-danger:hover {
        background: #b91c1c;
        border-color: #b91c1c;
    }


    /* =========================================================
       ALERTAS
    ========================================================== */

    .doctors-module .alert {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 16px;
        margin-bottom: 20px;
        border-radius: 10px;
        border: 1px solid;
    }

    .doctors-module .alert-success {
        background: #f0fdf4;
        border-color: #bbf7d0;
        color: #166534;
    }

    .doctors-module .alert-error {
        background: #fef2f2;
        border-color: #fecaca;
        color: #991b1b;
    }

    .doctors-module .alert-icon {
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 25px;
        border-radius: 50%;
        background: rgba(255,255,255,.7);
        font-weight: 700;
    }

    .doctors-module .alert strong {
        display: block;
        margin-bottom: 2px;
        font-size: 13px;
    }

    .doctors-module .alert p {
        margin: 0;
        font-size: 13px;
    }

    .doctors-module .alert-close {
        margin-left: auto;
        border: 0;
        background: transparent;
        color: inherit;
        font-size: 20px;
        cursor: pointer;
        line-height: 1;
    }


    /* =========================================================
       FILTROS
    ========================================================== */

    .doctors-module .filter-card {
        margin-bottom: 20px;
        padding: 18px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, .04);
    }

    .doctors-module .filter-form {
        display: grid;
        grid-template-columns: minmax(240px, 1.5fr) minmax(200px, 1fr) auto;
        align-items: end;
        gap: 14px;
    }

    .doctors-module .filter-label {
        display: block;
        margin-bottom: 7px;
        color: #374151;
        font-size: 13px;
        font-weight: 600;
    }

    .doctors-module .search-input-wrapper {
        position: relative;
    }

    .doctors-module .search-icon {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 19px;
        pointer-events: none;
    }

    .doctors-module .search-input-wrapper .form-control {
        padding-left: 38px;
    }


    /* =========================================================
       FORMULARIOS
    ========================================================== */

    .doctors-module .form-group {
        min-width: 0;
    }

    .doctors-module .form-label {
        display: block;
        margin-bottom: 7px;
        color: #374151;
        font-size: 13px;
        font-weight: 600;
    }

    .doctors-module .form-required {
        color: #dc2626;
    }

    .doctors-module .form-control {
        width: 100%;
        min-height: 42px;
        padding: 9px 12px;
        box-sizing: border-box;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        outline: none;
        background: #fff;
        color: #111827;
        font-family: inherit;
        font-size: 14px;
        transition: .18s ease;
    }

    .doctors-module .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
    }

    .doctors-module .form-control.is-invalid {
        border-color: #dc2626;
    }

    .doctors-module .form-error {
        display: block;
        margin-top: 5px;
        color: #dc2626;
        font-size: 12px;
    }


    /* =========================================================
       TABLA
    ========================================================== */

    .doctors-module .table-card {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, .04);
    }

    .doctors-module .table-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 19px 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .doctors-module .table-card-title {
        margin: 0;
        color: #111827;
        font-size: 16px;
        font-weight: 700;
    }

    .doctors-module .table-card-description {
        margin: 4px 0 0;
        color: #6b7280;
        font-size: 13px;
    }

    .doctors-module .table-counter {
        padding: 6px 10px;
        border-radius: 7px;
        background: #f3f4f6;
        color: #4b5563;
        font-size: 12px;
        font-weight: 600;
    }

    .doctors-module .table-wrapper {
        overflow-x: auto;
    }

    .doctors-module .data-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1050px;
    }

    .doctors-module .data-table th {
        padding: 12px 16px;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        color: #6b7280;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .04em;
        text-align: left;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .doctors-module .data-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #374151;
        font-size: 13px;
        vertical-align: middle;
    }

    .doctors-module .data-table tbody tr:hover {
        background: #fafcff;
    }

    .doctors-module .data-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .doctors-module .text-right {
        text-align: right !important;
    }


    /* =========================================================
       MÉDICO
    ========================================================== */

    .doctors-module .doctor-cell {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 220px;
    }

    .doctors-module .doctor-avatar,
    .doctor-show-module .doctor-profile-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 38px;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #eff6ff;
        color: #2563eb;
        font-size: 13px;
        font-weight: 700;
    }

    .doctors-module .doctor-info {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .doctors-module .doctor-info strong {
        color: #111827;
        font-size: 13px;
        font-weight: 650;
    }

    .doctors-module .doctor-info span {
        color: #9ca3af;
        font-size: 11px;
    }

    .doctors-module .table-main-text {
        color: #374151;
        font-weight: 500;
    }

    .doctors-module .table-muted {
        color: #9ca3af;
    }

    .doctors-module .contact-cell {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .doctors-module .contact-cell span {
        color: #374151;
        font-size: 12px;
    }

    .doctors-module .contact-cell small {
        color: #9ca3af;
        font-size: 11px;
    }

    .doctors-module .specialty-badge {
        display: inline-flex;
        padding: 5px 8px;
        border-radius: 6px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 11px;
        font-weight: 600;
    }


    /* =========================================================
       ESTADOS
    ========================================================== */

    .doctors-module .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 8px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
    }

    .doctors-module .status-active {
        background: #ecfdf5;
        color: #047857;
    }

    .doctors-module .status-inactive {
        background: #f3f4f6;
        color: #6b7280;
    }

    .doctors-module .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }


    /* =========================================================
       ACCIONES
    ========================================================== */

    .doctors-module .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 5px;
    }

    .doctors-module .action-btn {
        padding: 6px 8px;
        border: 0;
        border-radius: 6px;
        background: transparent;
        font-family: inherit;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        transition: .15s ease;
    }

    .doctors-module .action-view {
        color: #2563eb;
    }

    .doctors-module .action-view:hover {
        background: #eff6ff;
    }

    .doctors-module .action-edit {
        color: #d97706;
    }

    .doctors-module .action-edit:hover {
        background: #fffbeb;
    }

    .doctors-module .action-delete {
        color: #dc2626;
    }

    .doctors-module .action-delete:hover {
        background: #fef2f2;
    }


    /* =========================================================
       EMPTY
    ========================================================== */

    .doctors-module .empty-state {
        padding: 65px 25px;
        text-align: center;
    }

    .doctors-module .empty-icon {
        width: 52px;
        height: 52px;
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #eff6ff;
        color: #2563eb;
        font-size: 24px;
    }

    .doctors-module .empty-state h3 {
        margin: 0 0 7px;
        color: #111827;
        font-size: 16px;
    }

    .doctors-module .empty-state p {
        max-width: 450px;
        margin: 0 auto 18px;
        color: #6b7280;
        font-size: 13px;
    }


    /* =========================================================
       MODALES
    ========================================================== */

    .doctors-module ~ .modal-overlay,
    .modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(15, 23, 42, .48);
        backdrop-filter: blur(2px);
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-container {
        width: 100%;
        max-width: 650px;
        max-height: calc(100vh - 40px);
        overflow: hidden;
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 20px 60px rgba(15, 23, 42, .20);
        animation: doctorModalIn .18s ease;
    }

    .modal-large {
        max-width: 780px;
        overflow-y: auto;
    }

    .modal-small {
        max-width: 430px;
    }

    @keyframes doctorModalIn {
        from {
            opacity: 0;
            transform: translateY(8px) scale(.985);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .modal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        padding: 22px 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .modal-eyebrow {
        margin: 0 0 5px;
        color: #2563eb;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .07em;
        text-transform: uppercase;
    }

    .modal-title {
        margin: 0;
        color: #111827;
        font-size: 20px;
        font-weight: 700;
    }

    .modal-description {
        margin: 5px 0 0;
        color: #6b7280;
        font-size: 13px;
    }

    .modal-close {
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        border: 0;
        border-radius: 7px;
        background: #f3f4f6;
        color: #6b7280;
        font-size: 22px;
        line-height: 1;
        cursor: pointer;
    }

    .modal-close:hover {
        background: #e5e7eb;
        color: #111827;
    }

    .modal-body {
        padding: 24px;
    }

    .modal-section {
        padding-bottom: 23px;
        margin-bottom: 23px;
        border-bottom: 1px solid #eef2f7;
    }

    .modal-section:last-child {
        padding-bottom: 0;
        margin-bottom: 0;
        border-bottom: 0;
    }

    .modal-section-header {
        margin-bottom: 17px;
    }

    .modal-section-header h3 {
        margin: 0;
        color: #111827;
        font-size: 14px;
        font-weight: 700;
    }

    .modal-section-header p {
        margin: 4px 0 0;
        color: #6b7280;
        font-size: 12px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 17px;
    }

    .form-group-full {
        grid-column: 1 / -1;
    }

    .status-preview {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 14px;
        border: 1px solid #d1fae5;
        border-radius: 9px;
        background: #f0fdf4;
    }

    .status-preview-indicator {
        width: 9px;
        height: 9px;
        flex: 0 0 9px;
        border-radius: 50%;
        background: #10b981;
    }

    .status-preview-text {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .status-preview-text strong {
        color: #166534;
        font-size: 13px;
    }

    .status-preview-text span {
        color: #4b7c61;
        font-size: 11px;
    }

    .modal-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 9px;
        padding: 17px 24px;
        border-top: 1px solid #e5e7eb;
        background: #fafafa;
    }


    /* =========================================================
       PERFIL / DETALLE
    ========================================================== */

    .doctor-profile {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #fafcff;
    }

    .doctor-profile-avatar {
        width: 50px !important;
        height: 50px !important;
        flex-basis: 50px !important;
        font-size: 16px !important;
    }

    .doctor-profile h3 {
        margin: 0;
        color: #111827;
        font-size: 16px;
    }

    .doctor-profile p {
        margin: 4px 0 0;
        color: #2563eb;
        font-size: 12px;
        font-weight: 600;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 5px;
        padding: 13px;
        border: 1px solid #e5e7eb;
        border-radius: 9px;
    }

    .detail-label {
        color: #9ca3af;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .03em;
    }

    .detail-item strong {
        color: #374151;
        font-size: 13px;
        font-weight: 600;
        word-break: break-word;
    }


    /* =========================================================
       CONFIRMACIÓN
    ========================================================== */

    .confirm-modal {
        padding: 30px;
        text-align: center;
    }

    .confirm-icon {
        width: 48px;
        height: 48px;
        margin: 0 auto 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #fef2f2;
        color: #dc2626;
        font-size: 21px;
        font-weight: 700;
    }

    .confirm-modal h2 {
        margin: 0 0 9px;
        color: #111827;
        font-size: 18px;
    }

    .confirm-modal p {
        margin: 0 auto 8px;
        color: #6b7280;
        font-size: 13px;
        line-height: 1.6;
    }

    .confirm-modal .confirm-warning {
        color: #92400e;
        font-size: 12px;
    }

    .confirm-actions {
        margin: 22px -30px -30px;
        padding: 15px 30px;
    }


    /* =========================================================
       PAGINACIÓN
    ========================================================== */

    .doctors-module .pagination-container {
        padding: 16px 20px;
        border-top: 1px solid #e5e7eb;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================== */

    @media (max-width: 900px) {

        .doctors-module .filter-form {
            grid-template-columns: 1fr 1fr;
        }

        .doctors-module .filter-actions {
            grid-column: 1 / -1;
        }

    }

    @media (max-width: 700px) {

        .doctors-module .page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .doctors-module .page-actions,
        .doctors-module .page-actions .btn {
            width: 100%;
        }

        .doctors-module .filter-form {
            grid-template-columns: 1fr;
        }

        .doctors-module .filter-actions {
            grid-column: auto;
            display: flex;
        }

        .doctors-module .filter-actions .btn {
            flex: 1;
        }

        .form-grid,
        .detail-grid {
            grid-template-columns: 1fr;
        }

        .form-group-full {
            grid-column: auto;
        }

        .modal-overlay {
            padding: 10px;
        }

        .modal-container {
            max-height: calc(100vh - 20px);
        }

        .modal-header,
        .modal-body,
        .modal-footer {
            padding-left: 18px;
            padding-right: 18px;
        }

        .modal-footer {
            flex-wrap: wrap;
        }

    }

</style>

@endpush


{{-- =============================================================
    JAVASCRIPT DE MODALES
============================================================= --}}
@push('scripts')

<script>

    function openModal(id) {

        const modal = document.getElementById(id);

        if (!modal) {
            return;
        }

        modal.classList.add('active');

        document.body.style.overflow = 'hidden';
    }


    function closeModal(id) {

        const modal = document.getElementById(id);

        if (!modal) {
            return;
        }

        modal.classList.remove('active');

        const activeModals = document.querySelectorAll('.modal-overlay.active');

        if (activeModals.length === 0) {
            document.body.style.overflow = '';
        }
    }


    function closeModalOnOverlay(event, id) {

        if (event.target === event.currentTarget) {
            closeModal(id);
        }
    }


    document.addEventListener('keydown', function(event) {

        if (event.key !== 'Escape') {
            return;
        }

        const activeModal = document.querySelector('.modal-overlay.active');

        if (activeModal) {
            closeModal(activeModal.id);
        }

    });


    /*
     * Si Laravel devuelve errores de validación al registrar
     * un médico, abrimos automáticamente la modal de creación.
     */
    @if(
        $errors->has('nombres') ||
        $errors->has('apellidos') ||
        $errors->has('numero_identificacion') ||
        $errors->has('registro_profesional') ||
        $errors->has('specialty_id') ||
        $errors->has('telefono') ||
        $errors->has('correo')
    )

        document.addEventListener('DOMContentLoaded', function() {
            openModal('modalCreateDoctor');
        });

    @endif

</script>

@endpush

@endsection