
@extends('layouts.app')

@section('title', 'Pacientes')

@section('content')

<div class="patients-module">

    <div class="patients-page">

        {{-- ============================================================
             ENCABEZADO
        ============================================================ --}}

        <div class="patients-header">

            <div class="patients-header-content">

                <span class="patients-eyebrow">
                    Gestión clínica
                </span>

                <h1>
                    Pacientes
                </h1>

                <p>
                    Administra la información de los pacientes registrados.
                </p>

            </div>

            <button
                type="button"
                class="patients-primary-button"
                id="openCreatePatientModal"
            >
                <span class="patients-button-icon">+</span>
                Nuevo paciente
            </button>

        </div>


        {{-- ============================================================
             MENSAJES
        ============================================================ --}}

        @if(session('success'))

            <div class="patients-alert patients-alert-success">
                <div>
                    {{ session('success') }}
                </div>
            </div>

        @endif

        @if(session('error'))

            <div class="patients-alert patients-alert-error">
                <div>
                    {{ session('error') }}
                </div>
            </div>

        @endif


        {{-- ============================================================
             CONTENEDOR PRINCIPAL
        ============================================================ --}}

        <div class="patients-card">

            {{-- ========================================================
                 BARRA DE HERRAMIENTAS
            ========================================================= --}}

            <div class="patients-toolbar">

                <div class="patients-search-wrapper">

                    <span class="patients-search-icon">
                        <svg
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </span>

                    <input
                        type="text"
                        id="buscar"
                        name="buscar"
                        value="{{ request('buscar') }}"
                        class="patients-search"
                        placeholder="Buscar por nombre, apellido o documento..."
                        autocomplete="off"
                    >

                    <button
                        type="button"
                        id="clearPatientSearch"
                        class="patients-search-clear"
                        title="Limpiar búsqueda"
                        aria-label="Limpiar búsqueda"
                    >
                        ×
                    </button>

                </div>

                <div class="patients-counter">

                    <strong id="visiblePatientsCount">
                        {{ $patients->total() }}
                    </strong>

                    <span id="visiblePatientsLabel">
                        pacientes registrados
                    </span>

                </div>

            </div>


            {{-- ========================================================
                 TABLA
            ========================================================= --}}

            <div class="patients-table-wrapper">

                <table class="patients-table">

                    <thead>

                        <tr>

                            <th>
                                Paciente
                            </th>

                            <th>
                                Documento
                            </th>

                            <th>
                                Contacto
                            </th>

                            <th>
                                Estado
                            </th>

                            <th class="patients-actions-column">
                                Acciones
                            </th>

                        </tr>

                    </thead>

                    <tbody id="patientsTableBody">

                        @forelse($patients as $patient)

                            @php

                                $initials =
                                    strtoupper(
                                        substr($patient->nombres, 0, 1) .
                                        substr($patient->apellidos, 0, 1)
                                    );

                                $searchData = strtolower(
                                    $patient->nombres . ' ' .
                                    $patient->apellidos . ' ' .
                                    $patient->numero_documento
                                );

                                $edad = $patient->fecha_nacimiento
                                    ? \Carbon\Carbon::parse($patient->fecha_nacimiento)->age
                                    : null;

                            @endphp

                            <tr
                                class="patient-row"
                                data-search="{{ $searchData }}"
                            >

                                {{-- PACIENTE --}}

                                <td>

                                    <div class="patients-person">

                                        <div class="patients-avatar">
                                            {{ $initials }}
                                        </div>

                                        <div class="patients-person-info">

                                            <strong>
                                                {{ $patient->nombre_completo }}
                                            </strong>

                                            @if($edad !== null)

                                                <span>
                                                    {{ $edad }} años
                                                </span>

                                            @else

                                                <span>
                                                    Edad no disponible
                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- DOCUMENTO --}}

                                <td>

                                    <div class="patients-document">

                                        <span class="patients-document-type">
                                            {{ $patient->tipo_documento }}
                                        </span>

                                        <strong>
                                            {{ $patient->numero_documento }}
                                        </strong>

                                    </div>

                                </td>


                                {{-- CONTACTO --}}

                                <td>

                                    <div class="patients-contact">

                                        <span>
                                            {{ $patient->telefono }}
                                        </span>

                                        <span>
                                            {{ $patient->correo }}
                                        </span>

                                    </div>

                                </td>


                                {{-- ESTADO --}}

                                <td>

                                    @if($patient->estado === 'activo')

                                        <span class="patients-status patients-status-active">
                                            Activo
                                        </span>

                                    @else

                                        <span class="patients-status patients-status-inactive">
                                            Inactivo
                                        </span>

                                    @endif

                                </td>


                                {{-- ACCIONES --}}

                                <td>

                                    <div class="patients-actions">

                                        {{-- VER --}}

                                        <button
                                            type="button"
                                            class="patients-action-button patients-action-view"
                                            data-patient-view
                                            data-id="{{ $patient->id }}"
                                            data-tipo-documento="{{ $patient->tipo_documento }}"
                                            data-numero-documento="{{ $patient->numero_documento }}"
                                            data-nombres="{{ $patient->nombres }}"
                                            data-apellidos="{{ $patient->apellidos }}"
                                            data-fecha-nacimiento="{{ $patient->fecha_nacimiento ? \Carbon\Carbon::parse($patient->fecha_nacimiento)->format('Y-m-d') : '' }}"
                                            data-telefono="{{ $patient->telefono }}"
                                            data-correo="{{ $patient->correo }}"
                                            data-direccion="{{ $patient->direccion }}"
                                            data-estado="{{ $patient->estado }}"
                                            data-user-id="{{ $patient->user_id }}"
                                            data-user-name="{{ $patient->user?->name }}"
                                            data-user-email="{{ $patient->user?->email }}"
                                            title="Ver paciente"
                                            aria-label="Ver paciente"
                                        >
                                            <svg
                                                width="17"
                                                height="17"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                        </button>


                                        {{-- EDITAR --}}

                                        <button
                                            type="button"
                                            class="patients-action-button patients-action-edit"
                                            data-patient-edit
                                            data-id="{{ $patient->id }}"
                                            data-user-id="{{ $patient->user_id }}"
                                            data-tipo-documento="{{ $patient->tipo_documento }}"
                                            data-numero-documento="{{ $patient->numero_documento }}"
                                            data-nombres="{{ $patient->nombres }}"
                                            data-apellidos="{{ $patient->apellidos }}"
                                            data-fecha-nacimiento="{{ $patient->fecha_nacimiento ? \Carbon\Carbon::parse($patient->fecha_nacimiento)->format('Y-m-d') : '' }}"
                                            data-telefono="{{ $patient->telefono }}"
                                            data-correo="{{ $patient->correo }}"
                                            data-direccion="{{ $patient->direccion }}"
                                            data-estado="{{ $patient->estado }}"
                                            title="Editar paciente"
                                            aria-label="Editar paciente"
                                        >
                                            <svg
                                                width="17"
                                                height="17"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path d="M12 20h9"></path>
                                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                                            </svg>
                                        </button>


                                        {{-- ELIMINAR --}}

                                        @if($patient->appointments()->doesntExist())

                                            <form
                                                method="POST"
                                                action="{{ route('patients.destroy', $patient) }}"
                                                class="patients-delete-form"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="patients-action-button patients-action-delete"
                                                    title="Eliminar paciente"
                                                    aria-label="Eliminar paciente"
                                                >
                                                    <svg
                                                        width="17"
                                                        height="17"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    >
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6l-1 14H6L5 6"></path>
                                                        <path d="M10 11v6"></path>
                                                        <path d="M14 11v6"></path>
                                                        <path d="M9 6V4h6v2"></path>
                                                    </svg>
                                                </button>

                                            </form>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="patients-empty-cell"
                                >

                                    <div class="patients-empty">

                                        <div class="patients-empty-icon">
                                            +
                                        </div>

                                        <h3>
                                            No hay pacientes registrados
                                        </h3>

                                        <p>
                                            Registra el primer paciente para comenzar a gestionar su información.
                                        </p>

                                        <button
                                            type="button"
                                            class="patients-primary-button"
                                            id="openCreatePatientModalEmpty"
                                        >
                                            Nuevo paciente
                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- ========================================================
                 SIN RESULTADOS EN BÚSQUEDA
            ========================================================= --}}

            <div
                id="patientsSearchEmpty"
                class="patients-search-empty"
                style="display: none;"
            >

                <div class="patients-empty-icon">
                    ?
                </div>

                <h3>
                    No se encontraron pacientes
                </h3>

                <p>
                    Intenta realizar la búsqueda utilizando otro nombre, apellido o documento.
                </p>

            </div>


            {{-- ========================================================
                 PAGINACIÓN
            ========================================================= --}}

            @if($patients->hasPages())

                <div class="patients-pagination">

                    {{ $patients->links() }}

                </div>

            @endif

        </div>

    </div>

</div>


{{-- =====================================================================
     MODAL CREAR PACIENTE
===================================================================== --}}

<div
    id="createPatientModal"
    class="patients-modal-overlay"
    aria-hidden="true"
>

    <div
        class="patients-modal patients-modal-large"
        role="dialog"
        aria-modal="true"
        aria-labelledby="createPatientModalTitle"
    >

        <div class="patients-modal-header">

            <div>

                <span class="patients-modal-eyebrow">
                    Gestión clínica
                </span>

                <h2 id="createPatientModalTitle">
                    Nuevo paciente
                </h2>

                <p>
                    Registra la información del paciente y asocia su cuenta de acceso.
                </p>

            </div>

            <button
                type="button"
                class="patients-modal-close"
                data-close-create-patient
                aria-label="Cerrar"
            >
                ×
            </button>

        </div>


        <form
            method="POST"
            action="{{ route('patients.store') }}"
            id="createPatientForm"
        >

            @csrf


            {{-- SECCIÓN 01 --}}

            <div class="patients-form-section">

                <div class="patients-section-heading">

                    <div class="patients-section-number">
                        01
                    </div>

                    <div>

                        <h3>
                            Información personal
                        </h3>

                        <p>
                            Datos básicos de identificación del paciente.
                        </p>

                    </div>

                </div>


                <div class="patients-form-grid">

                    <div class="patients-form-group">

                        <label for="create_tipo_documento">
                            Tipo de documento
                        </label>

                        <select
                            name="tipo_documento"
                            id="create_tipo_documento"
                            required
                        >

                            <option value="">
                                Selecciona una opción
                            </option>

                            <option value="CC">
                                Cédula de ciudadanía
                            </option>

                            <option value="TI">
                                Tarjeta de identidad
                            </option>

                            <option value="CE">
                                Cédula de extranjería
                            </option>

                            <option value="PA">
                                Pasaporte
                            </option>

                        </select>

                        @error('tipo_documento')

                            <small class="patients-form-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    <div class="patients-form-group">

                        <label for="create_numero_documento">
                            Número de documento
                        </label>

                        <input
                            type="text"
                            name="numero_documento"
                            id="create_numero_documento"
                            value="{{ old('numero_documento') }}"
                            maxlength="20"
                            required
                        >

                        @error('numero_documento')

                            <small class="patients-form-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    <div class="patients-form-group">

                        <label for="create_nombres">
                            Nombres
                        </label>

                        <input
                            type="text"
                            name="nombres"
                            id="create_nombres"
                            value="{{ old('nombres') }}"
                            maxlength="100"
                            required
                        >

                        @error('nombres')

                            <small class="patients-form-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    <div class="patients-form-group">

                        <label for="create_apellidos">
                            Apellidos
                        </label>

                        <input
                            type="text"
                            name="apellidos"
                            id="create_apellidos"
                            value="{{ old('apellidos') }}"
                            maxlength="100"
                            required
                        >

                        @error('apellidos')

                            <small class="patients-form-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    <div class="patients-form-group">

                        <label for="create_fecha_nacimiento">
                            Fecha de nacimiento
                        </label>

                        <input
                            type="date"
                            name="fecha_nacimiento"
                            id="create_fecha_nacimiento"
                            value="{{ old('fecha_nacimiento') }}"
                            max="{{ now()->subDay()->format('Y-m-d') }}"
                            required
                        >

                        @error('fecha_nacimiento')

                            <small class="patients-form-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>

                </div>

            </div>


            {{-- SECCIÓN 02 --}}

            <div class="patients-form-section">

                <div class="patients-section-heading">

                    <div class="patients-section-number">
                        02
                    </div>

                    <div>

                        <h3>
                            Información de contacto
                        </h3>

                        <p>
                            Información para comunicación con el paciente.
                        </p>

                    </div>

                </div>


                <div class="patients-form-grid">

                    <div class="patients-form-group">

                        <label for="create_telefono">
                            Teléfono
                        </label>

                        <input
                            type="text"
                            name="telefono"
                            id="create_telefono"
                            value="{{ old('telefono') }}"
                            maxlength="20"
                            required
                        >

                        @error('telefono')

                            <small class="patients-form-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    <div class="patients-form-group">

                        <label for="create_correo">
                            Correo electrónico
                        </label>

                        <input
                            type="email"
                            name="correo"
                            id="create_correo"
                            value="{{ old('correo') }}"
                            maxlength="150"
                            required
                        >

                        @error('correo')

                            <small class="patients-form-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    <div class="patients-form-group patients-form-full">

                        <label for="create_direccion">
                            Dirección
                        </label>

                        <input
                            type="text"
                            name="direccion"
                            id="create_direccion"
                            value="{{ old('direccion') }}"
                            maxlength="255"
                        >

                        @error('direccion')

                            <small class="patients-form-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>

                </div>

            </div>


            {{-- SECCIÓN 03 CUENTA --}}

            <div class="patients-form-section">

                <div class="patients-section-heading">

                    <div class="patients-section-number">
                        03
                    </div>

                    <div>

                        <h3>
                            Cuenta de acceso
                        </h3>

                        <p>
                            Asocia este paciente con su usuario del sistema.
                        </p>

                    </div>

                </div>


                <div class="patients-form-grid">

                    <div class="patients-form-group patients-form-full">

                        <label for="create_user_id">
                            Usuario del paciente
                        </label>

                        <select
                            name="user_id"
                            id="create_user_id"
                            required
                        >

                            <option value="">
                                Selecciona un usuario
                            </option>

                            @foreach($users as $user)

                                <option
                                    value="{{ $user->id }}"
                                    @disabled($user->patient)
                                    @selected(old('user_id') == $user->id)
                                >
                                    {{ $user->name }} — {{ $user->email }}

                                    @if($user->patient)
                                        (Ya asociado)
                                    @endif

                                </option>

                            @endforeach

                        </select>

                        <small class="patients-form-help">
                            Solo puedes asociar usuarios que tengan el rol paciente.
                        </small>

                        @error('user_id')

                            <small class="patients-form-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>

                </div>

            </div>


            {{-- INFORMACIÓN --}}

            <div class="patients-info-box">

                <div class="patients-info-icon">
                    ✓
                </div>

                <div>

                    <strong>
                        Registro activo
                    </strong>

                    <p>
                        El paciente será registrado como activo y podrá utilizar su cuenta para consultar y gestionar sus citas.
                    </p>

                </div>

            </div>


            {{-- FOOTER --}}

            <div class="patients-modal-footer">

                <button
                    type="button"
                    class="patients-secondary-button"
                    data-close-create-patient
                >
                    Cancelar
                </button>

                <button
                    type="submit"
                    class="patients-primary-button"
                >
                    Registrar paciente
                </button>

            </div>

        </form>

    </div>

</div>


{{-- =====================================================================
     MODAL EDITAR PACIENTE
===================================================================== --}}

<div
    id="editPatientModal"
    class="patients-modal-overlay"
    aria-hidden="true"
>

    <div
        class="patients-modal patients-modal-large"
        role="dialog"
        aria-modal="true"
        aria-labelledby="editPatientModalTitle"
    >

        <div class="patients-modal-header">

            <div>

                <span class="patients-modal-eyebrow">
                    Gestión clínica
                </span>

                <h2 id="editPatientModalTitle">
                    Editar paciente
                </h2>

                <p>
                    Actualiza la información registrada del paciente.
                </p>

            </div>

            <button
                type="button"
                class="patients-modal-close"
                data-close-edit-patient
                aria-label="Cerrar"
            >
                ×
            </button>

        </div>


        <form
            method="POST"
            action=""
            id="editPatientForm"
        >

            @csrf
            @method('PUT')


            {{-- SECCIÓN 01 --}}

            <div class="patients-form-section">

                <div class="patients-section-heading">

                    <div class="patients-section-number">
                        01
                    </div>

                    <div>

                        <h3>
                            Información personal
                        </h3>

                        <p>
                            Datos básicos de identificación del paciente.
                        </p>

                    </div>

                </div>


                <div class="patients-form-grid">

                    <div class="patients-form-group">

                        <label for="edit_tipo_documento">
                            Tipo de documento
                        </label>

                        <select
                            name="tipo_documento"
                            id="edit_tipo_documento"
                            required
                        >

                            <option value="CC">
                                Cédula de ciudadanía
                            </option>

                            <option value="TI">
                                Tarjeta de identidad
                            </option>

                            <option value="CE">
                                Cédula de extranjería
                            </option>

                            <option value="PA">
                                Pasaporte
                            </option>

                        </select>

                    </div>


                    <div class="patients-form-group">

                        <label for="edit_numero_documento">
                            Número de documento
                        </label>

                        <input
                            type="text"
                            name="numero_documento"
                            id="edit_numero_documento"
                            maxlength="20"
                            required
                        >

                    </div>


                    <div class="patients-form-group">

                        <label for="edit_nombres">
                            Nombres
                        </label>

                        <input
                            type="text"
                            name="nombres"
                            id="edit_nombres"
                            maxlength="100"
                            required
                        >

                    </div>


                    <div class="patients-form-group">

                        <label for="edit_apellidos">
                            Apellidos
                        </label>

                        <input
                            type="text"
                            name="apellidos"
                            id="edit_apellidos"
                            maxlength="100"
                            required
                        >

                    </div>


                    <div class="patients-form-group">

                        <label for="edit_fecha_nacimiento">
                            Fecha de nacimiento
                        </label>

                        <input
                            type="date"
                            name="fecha_nacimiento"
                            id="edit_fecha_nacimiento"
                            required
                        >

                    </div>

                </div>

            </div>


            {{-- SECCIÓN 02 --}}

            <div class="patients-form-section">

                <div class="patients-section-heading">

                    <div class="patients-section-number">
                        02
                    </div>

                    <div>

                        <h3>
                            Información de contacto
                        </h3>

                        <p>
                            Información para comunicación con el paciente.
                        </p>

                    </div>

                </div>


                <div class="patients-form-grid">

                    <div class="patients-form-group">

                        <label for="edit_telefono">
                            Teléfono
                        </label>

                        <input
                            type="text"
                            name="telefono"
                            id="edit_telefono"
                            maxlength="20"
                            required
                        >

                    </div>


                    <div class="patients-form-group">

                        <label for="edit_correo">
                            Correo electrónico
                        </label>

                        <input
                            type="email"
                            name="correo"
                            id="edit_correo"
                            maxlength="150"
                            required
                        >

                    </div>


                    <div class="patients-form-group patients-form-full">

                        <label for="edit_direccion">
                            Dirección
                        </label>

                        <input
                            type="text"
                            name="direccion"
                            id="edit_direccion"
                            maxlength="255"
                        >

                    </div>

                </div>

            </div>


            {{-- SECCIÓN 03 CUENTA --}}

            <div class="patients-form-section">

                <div class="patients-section-heading">

                    <div class="patients-section-number">
                        03
                    </div>

                    <div>

                        <h3>
                            Cuenta de acceso
                        </h3>

                        <p>
                            Usuario asociado al paciente.
                        </p>

                    </div>

                </div>


                <div class="patients-form-grid">

                    <div class="patients-form-group patients-form-full">

                        <label for="edit_user_id">
                            Usuario del paciente
                        </label>

                        <select
                            name="user_id"
                            id="edit_user_id"
                            required
                        >

                            <option value="">
                                Selecciona un usuario
                            </option>

                            @foreach($users as $user)

                                <option
                                    value="{{ $user->id }}"
                                    data-assigned="{{ $user->patient ? '1' : '0' }}"
                                >
                                    {{ $user->name }} — {{ $user->email }}

                                    @if($user->patient)
                                        (Ya asociado)
                                    @endif

                                </option>

                            @endforeach

                        </select>

                        <small class="patients-form-help">
                            La cuenta debe tener el rol paciente.
                        </small>

                    </div>

                </div>

            </div>


            {{-- SECCIÓN 04 ESTADO --}}

            <div class="patients-form-section">

                <div class="patients-section-heading">

                    <div class="patients-section-number">
                        04
                    </div>

                    <div>

                        <h3>
                            Estado
                        </h3>

                        <p>
                            Define si el paciente puede continuar activo en el sistema.
                        </p>

                    </div>

                </div>


                <div class="patients-form-grid">

                    <div class="patients-form-group patients-form-full">

                        <label for="edit_estado">
                            Estado del paciente
                        </label>

                        <select
                            name="estado"
                            id="edit_estado"
                            required
                        >

                            <option value="activo">
                                Activo
                            </option>

                            <option value="inactivo">
                                Inactivo
                            </option>

                        </select>

                    </div>

                </div>

            </div>


            {{-- FOOTER --}}

            <div class="patients-modal-footer">

                <button
                    type="button"
                    class="patients-secondary-button"
                    data-close-edit-patient
                >
                    Cancelar
                </button>

                <button
                    type="submit"
                    class="patients-primary-button"
                >
                    Guardar cambios
                </button>

            </div>

        </form>

    </div>

</div>


{{-- =====================================================================
     MODAL VER PACIENTE
===================================================================== --}}

<div
    id="viewPatientModal"
    class="patients-modal-overlay"
    aria-hidden="true"
>

    <div
        class="patients-modal patients-modal-large"
        role="dialog"
        aria-modal="true"
        aria-labelledby="viewPatientModalTitle"
    >

        <div class="patients-modal-header">

            <div>

                <span class="patients-modal-eyebrow">
                    Información del paciente
                </span>

                <h2 id="viewPatientModalTitle">
                    Detalle del paciente
                </h2>

                <p>
                    Consulta la información registrada.
                </p>

            </div>

            <button
                type="button"
                class="patients-modal-close"
                data-close-view-patient
                aria-label="Cerrar"
            >
                ×
            </button>

        </div>


        <div class="patients-view-content">


            {{-- PERFIL --}}

            <div class="patients-profile">

                <div
                    class="patients-profile-avatar"
                    id="viewPatientAvatar"
                >
                    --
                </div>

                <div class="patients-profile-info">

                    <h3 id="viewPatientName">
                        --
                    </h3>

                    <span id="viewPatientDocument">
                        --
                    </span>

                </div>

                <div
                    class="patients-profile-status"
                    id="viewPatientStatus"
                >
                    --
                </div>

            </div>


            {{-- DETALLES --}}

            <div class="patients-detail-grid">

                <div class="patients-detail-item">

                    <span>
                        Fecha de nacimiento
                    </span>

                    <strong id="viewPatientBirth">
                        --
                    </strong>

                </div>


                <div class="patients-detail-item">

                    <span>
                        Edad
                    </span>

                    <strong id="viewPatientAge">
                        --
                    </strong>

                </div>


                <div class="patients-detail-item">

                    <span>
                        Teléfono
                    </span>

                    <strong id="viewPatientPhone">
                        --
                    </strong>

                </div>


                <div class="patients-detail-item">

                    <span>
                        Correo electrónico
                    </span>

                    <strong id="viewPatientEmail">
                        --
                    </strong>

                </div>


                <div class="patients-detail-item patients-detail-full">

                    <span>
                        Dirección
                    </span>

                    <strong id="viewPatientAddress">
                        --
                    </strong>

                </div>


                <div class="patients-detail-item patients-detail-full">

                    <span>
                        Cuenta de acceso
                    </span>

                    <strong id="viewPatientUser">
                        Sin usuario asociado
                    </strong>

                    <small id="viewPatientUserEmail">
                    </small>

                </div>

            </div>

        </div>


        {{-- FOOTER --}}

        <div class="patients-modal-footer">

            <button
                type="button"
                class="patients-secondary-button"
                data-close-view-patient
            >
                Cerrar
            </button>

        </div>

    </div>

</div>


{{-- =====================================================================
     ESTILOS
===================================================================== --}}

<style>

    :root {

        --patients-primary: #2563eb;
        --patients-primary-dark: #1d4ed8;
        --patients-primary-soft: #eff6ff;

        --patients-bg: #f8fafc;
        --patients-surface: #ffffff;

        --patients-text: #111827;
        --patients-muted: #6b7280;

        --patients-border: #e5e7eb;

        --patients-success: #15803d;
        --patients-success-bg: #f0fdf4;

        --patients-danger: #dc2626;
        --patients-danger-bg: #fef2f2;

    }


    .patients-module {

        width: 100%;
        min-height: calc(100vh - 80px);
        background: var(--patients-bg);

    }


    .patients-page {

        max-width: 1400px;
        margin: 0 auto;
        padding: 32px;

    }


    /* ================================================================
       HEADER
    ================================================================ */

    .patients-header {

        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 28px;

    }


    .patients-header-content {

        min-width: 0;

    }


    .patients-eyebrow,
    .patients-modal-eyebrow {

        display: block;
        margin-bottom: 7px;

        color: var(--patients-primary);

        font-size: 12px;
        font-weight: 700;

        letter-spacing: .08em;
        text-transform: uppercase;

    }


    .patients-header h1 {

        margin: 0;

        color: var(--patients-text);

        font-size: 30px;
        line-height: 1.2;
        font-weight: 700;

    }


    .patients-header p {

        margin: 8px 0 0;

        color: var(--patients-muted);

        font-size: 14px;

    }


    /* ================================================================
       BOTONES
    ================================================================ */

    .patients-primary-button,
    .patients-secondary-button {

        min-height: 42px;

        padding: 0 17px;

        border-radius: 9px;

        font-size: 14px;
        font-weight: 600;

        cursor: pointer;

        transition:
            background .18s ease,
            border-color .18s ease,
            transform .18s ease,
            box-shadow .18s ease;

    }


    .patients-primary-button {

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;

        border: 1px solid var(--patients-primary);

        background: var(--patients-primary);

        color: #fff;

        box-shadow: 0 2px 5px rgba(37, 99, 235, .15);

    }


    .patients-primary-button:hover {

        background: var(--patients-primary-dark);
        border-color: var(--patients-primary-dark);

        transform: translateY(-1px);

    }


    .patients-button-icon {

        font-size: 19px;
        line-height: 1;
        font-weight: 400;

    }


    .patients-secondary-button {

        border: 1px solid var(--patients-border);

        background: #fff;

        color: var(--patients-text);

    }


    .patients-secondary-button:hover {

        background: var(--patients-bg);
        border-color: #d1d5db;

    }


    /* ================================================================
       ALERTAS
    ================================================================ */

    .patients-alert {

        margin-bottom: 20px;

        padding: 13px 16px;

        border-radius: 10px;

        font-size: 14px;
        font-weight: 500;

    }


    .patients-alert-success {

        border: 1px solid #bbf7d0;
        background: var(--patients-success-bg);
        color: var(--patients-success);

    }


    .patients-alert-error {

        border: 1px solid #fecaca;
        background: var(--patients-danger-bg);
        color: var(--patients-danger);

    }


    /* ================================================================
       CARD
    ================================================================ */

    .patients-card {

        overflow: hidden;

        border: 1px solid var(--patients-border);

        border-radius: 15px;

        background: var(--patients-surface);

        box-shadow:
            0 2px 5px rgba(15, 23, 42, .03);

    }


    /* ================================================================
       TOOLBAR
    ================================================================ */

    .patients-toolbar {

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;

        padding: 18px 20px;

        border-bottom: 1px solid var(--patients-border);

    }


    .patients-search-wrapper {

        position: relative;

        width: min(500px, 100%);

    }


    .patients-search-icon {

        position: absolute;

        top: 50%;
        left: 13px;

        display: flex;

        color: var(--patients-muted);

        transform: translateY(-50%);

        pointer-events: none;

    }


    .patients-search {

        width: 100%;
        height: 42px;

        padding: 0 42px 0 40px;

        border: 1px solid var(--patients-border);

        border-radius: 9px;

        background: #fff;

        color: var(--patients-text);

        font-size: 14px;

        outline: none;

        transition:
            border-color .18s ease,
            box-shadow .18s ease;

    }


    .patients-search:focus {

        border-color: var(--patients-primary);

        box-shadow:
            0 0 0 3px rgba(37, 99, 235, .10);

    }


    .patients-search-clear {

        position: absolute;

        top: 50%;
        right: 11px;

        width: 24px;
        height: 24px;

        display: none;
        align-items: center;
        justify-content: center;

        padding: 0;

        border: 0;

        border-radius: 50%;

        background: transparent;

        color: var(--patients-muted);

        font-size: 20px;

        cursor: pointer;

        transform: translateY(-50%);

    }


    .patients-search-clear:hover {

        background: var(--patients-bg);
        color: var(--patients-text);

    }


    .patients-counter {

        display: flex;
        align-items: baseline;
        gap: 6px;

        white-space: nowrap;

        color: var(--patients-muted);

        font-size: 13px;

    }


    .patients-counter strong {

        color: var(--patients-text);

        font-size: 15px;

    }


    /* ================================================================
       TABLA
    ================================================================ */

    .patients-table-wrapper {

        width: 100%;

        overflow-x: auto;

    }


    .patients-table {

        width: 100%;

        border-collapse: collapse;

    }


    .patients-table thead th {

        padding: 14px 20px;

        border-bottom: 1px solid var(--patients-border);

        background: #fafafa;

        color: var(--patients-muted);

        font-size: 11px;

        font-weight: 700;

        letter-spacing: .06em;

        text-align: left;

        text-transform: uppercase;

    }


    .patients-table tbody tr {

        transition: background .15s ease;

    }


    .patients-table tbody tr:hover {

        background: #fafcff;

    }


    .patients-table tbody td {

        padding: 16px 20px;

        border-bottom: 1px solid #f0f1f3;

        vertical-align: middle;

    }


    .patients-person {

        display: flex;
        align-items: center;
        gap: 12px;

    }


    .patients-avatar,
    .patients-profile-avatar {

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        border-radius: 50%;

        background: var(--patients-primary-soft);

        color: var(--patients-primary);

        font-weight: 700;

    }


    .patients-avatar {

        width: 40px;
        height: 40px;

        font-size: 12px;

    }


    .patients-person-info {

        display: flex;
        flex-direction: column;
        gap: 3px;

    }


    .patients-person-info strong {

        color: var(--patients-text);

        font-size: 14px;

    }


    .patients-person-info span {

        color: var(--patients-muted);

        font-size: 12px;

    }


    .patients-document {

        display: flex;
        flex-direction: column;
        gap: 3px;

    }


    .patients-document-type {

        color: var(--patients-muted);

        font-size: 11px;

        font-weight: 600;

        text-transform: uppercase;

    }


    .patients-document strong {

        color: var(--patients-text);

        font-size: 13px;

    }


    .patients-contact {

        display: flex;
        flex-direction: column;
        gap: 4px;

        max-width: 240px;

    }


    .patients-contact span {

        overflow: hidden;

        color: var(--patients-muted);

        font-size: 12px;

        text-overflow: ellipsis;
        white-space: nowrap;

    }


    .patients-status {

        display: inline-flex;
        align-items: center;

        padding: 5px 9px;

        border-radius: 999px;

        font-size: 11px;
        font-weight: 700;

    }


    .patients-status-active {

        background: var(--patients-success-bg);
        color: var(--patients-success);

    }


    .patients-status-inactive {

        background: var(--patients-danger-bg);
        color: var(--patients-danger);

    }


    .patients-actions-column {

        width: 130px;

        text-align: right !important;

    }


    .patients-actions {

        display: flex;
        align-items: center;
        justify-content: flex-end;

        gap: 6px;

    }


    .patients-action-button {

        width: 34px;
        height: 34px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 0;

        border: 1px solid var(--patients-border);

        border-radius: 8px;

        background: #fff;

        cursor: pointer;

        transition:
            background .18s ease,
            border-color .18s ease,
            color .18s ease;

    }


    .patients-action-view {

        color: var(--patients-primary);

    }


    .patients-action-view:hover {

        border-color: #bfdbfe;
        background: var(--patients-primary-soft);

    }


    .patients-action-edit {

        color: #4b5563;

    }


    .patients-action-edit:hover {

        border-color: #d1d5db;
        background: #f9fafb;

    }


    .patients-action-delete {

        color: var(--patients-danger);

    }


    .patients-action-delete:hover {

        border-color: #fecaca;
        background: var(--patients-danger-bg);

    }


    .patients-delete-form {

        display: inline-flex;
        margin: 0;

    }


    /* ================================================================
       EMPTY
    ================================================================ */

    .patients-empty-cell {

        padding: 0 !important;

    }


    .patients-empty {

        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;

        padding: 70px 30px;

        text-align: center;

    }


    .patients-empty-icon {

        width: 46px;
        height: 46px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-bottom: 15px;

        border-radius: 12px;

        background: var(--patients-primary-soft);

        color: var(--patients-primary);

        font-size: 24px;

    }


    .patients-empty h3 {

        margin: 0;

        color: var(--patients-text);

        font-size: 16px;

    }


    .patients-empty p {

        max-width: 420px;

        margin: 8px 0 20px;

        color: var(--patients-muted);

        font-size: 13px;

        line-height: 1.6;

    }


    .patients-search-empty {

        padding: 55px 25px;

        border-top: 1px solid var(--patients-border);

        text-align: center;

    }


    .patients-search-empty .patients-empty-icon {

        margin-left: auto;
        margin-right: auto;

    }


    .patients-search-empty h3 {

        margin: 0;

        color: var(--patients-text);

        font-size: 16px;

    }


    .patients-search-empty p {

        margin: 8px 0 0;

        color: var(--patients-muted);

        font-size: 13px;

    }


    /* ================================================================
       PAGINACIÓN
    ================================================================ */

    .patients-pagination {

        padding: 17px 20px;

        border-top: 1px solid var(--patients-border);

    }


    .patients-pagination nav {

        display: flex;
        justify-content: center;

    }


    .patients-pagination svg {

        width: 18px;
        height: 18px;

    }


    /* ================================================================
       MODALES
    ================================================================ */

    .patients-modal-overlay {

        position: fixed;

        inset: 0;

        z-index: 9999;

        display: none;
        align-items: center;
        justify-content: center;

        padding: 25px;

        background: rgba(15, 23, 42, .48);

        backdrop-filter: blur(4px);

    }


    .patients-modal-overlay.is-open {

        display: flex;

    }


    .patients-modal {

        width: 100%;

        max-height: calc(100vh - 50px);

        overflow-y: auto;

        border: 1px solid rgba(255,255,255,.5);

        border-radius: 15px;

        background: #fff;

        box-shadow:
            0 25px 60px rgba(15, 23, 42, .20);

        animation: patientsModalIn .18s ease;

    }


    .patients-modal-large {

        max-width: 760px;

    }


    @keyframes patientsModalIn {

        from {

            opacity: 0;
            transform: translateY(8px) scale(.99);

        }

        to {

            opacity: 1;
            transform: translateY(0) scale(1);

        }

    }


    .patients-modal-header {

        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 20px;

        padding: 24px 26px;

        border-bottom: 1px solid var(--patients-border);

    }


    .patients-modal-header h2 {

        margin: 0;

        color: var(--patients-text);

        font-size: 21px;

    }


    .patients-modal-header p {

        margin: 7px 0 0;

        color: var(--patients-muted);

        font-size: 13px;

        line-height: 1.5;

    }


    .patients-modal-close {

        width: 34px;
        height: 34px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        padding: 0;

        border: 0;

        border-radius: 8px;

        background: transparent;

        color: var(--patients-muted);

        font-size: 25px;
        line-height: 1;

        cursor: pointer;

    }


    .patients-modal-close:hover {

        background: var(--patients-bg);
        color: var(--patients-text);

    }


    /* ================================================================
       FORMULARIOS
    ================================================================ */

    .patients-form-section {

        padding: 24px 26px;

        border-bottom: 1px solid #f0f1f3;

    }


    .patients-section-heading {

        display: flex;
        align-items: flex-start;

        gap: 12px;

        margin-bottom: 20px;

    }


    .patients-section-number {

        width: 30px;
        height: 30px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        border-radius: 8px;

        background: var(--patients-primary-soft);

        color: var(--patients-primary);

        font-size: 11px;
        font-weight: 700;

    }


    .patients-section-heading h3 {

        margin: 1px 0 4px;

        color: var(--patients-text);

        font-size: 14px;

    }


    .patients-section-heading p {

        margin: 0;

        color: var(--patients-muted);

        font-size: 12px;

        line-height: 1.5;

    }


    .patients-form-grid {

        display: grid;

        grid-template-columns: repeat(2, minmax(0, 1fr));

        gap: 17px;

    }


    .patients-form-group {

        display: flex;
        flex-direction: column;

        gap: 7px;

    }


    .patients-form-full {

        grid-column: 1 / -1;

    }


    .patients-form-group label {

        color: #374151;

        font-size: 12px;
        font-weight: 600;

    }


    .patients-form-group input,
    .patients-form-group select {

        width: 100%;
        min-height: 42px;

        padding: 0 12px;

        border: 1px solid var(--patients-border);

        border-radius: 8px;

        background: #fff;

        color: var(--patients-text);

        font-family: inherit;

        font-size: 13px;

        outline: none;

        transition:
            border-color .18s ease,
            box-shadow .18s ease;

    }


    .patients-form-group input:focus,
    .patients-form-group select:focus {

        border-color: var(--patients-primary);

        box-shadow:
            0 0 0 3px rgba(37, 99, 235, .10);

    }


    .patients-form-group select:disabled {

        background: #f9fafb;

        color: #9ca3af;

    }


    .patients-form-help {

        color: var(--patients-muted);

        font-size: 11px;

        line-height: 1.4;

    }


    .patients-form-error {

        color: var(--patients-danger);

        font-size: 11px;

    }


    .patients-info-box {

        display: flex;
        align-items: flex-start;

        gap: 12px;

        margin: 20px 26px;

        padding: 13px 15px;

        border: 1px solid #bbf7d0;

        border-radius: 9px;

        background: var(--patients-success-bg);

    }


    .patients-info-icon {

        width: 24px;
        height: 24px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        border-radius: 50%;

        background: #dcfce7;

        color: var(--patients-success);

        font-size: 12px;
        font-weight: 700;

    }


    .patients-info-box strong {

        display: block;

        margin-bottom: 3px;

        color: var(--patients-success);

        font-size: 12px;

    }


    .patients-info-box p {

        margin: 0;

        color: #166534;

        font-size: 11px;

        line-height: 1.5;

    }


    .patients-modal-footer {

        display: flex;
        align-items: center;
        justify-content: flex-end;

        gap: 10px;

        padding: 17px 26px;

        border-top: 1px solid var(--patients-border);

        background: #fafafa;

    }


    /* ================================================================
       MODAL VER
    ================================================================ */

    .patients-view-content {

        padding: 26px;

    }


    .patients-profile {

        display: flex;
        align-items: center;

        gap: 15px;

        padding: 17px;

        border: 1px solid var(--patients-border);

        border-radius: 11px;

        background: #fafcff;

    }


    .patients-profile-avatar {

        width: 54px;
        height: 54px;

        font-size: 15px;

    }


    .patients-profile-info {

        flex: 1;

        min-width: 0;

    }


    .patients-profile-info h3 {

        margin: 0 0 5px;

        color: var(--patients-text);

        font-size: 17px;

    }


    .patients-profile-info span {

        color: var(--patients-muted);

        font-size: 12px;

    }


    .patients-profile-status {

        padding: 5px 10px;

        border-radius: 999px;

        font-size: 11px;
        font-weight: 700;

    }


    .patients-detail-grid {

        display: grid;

        grid-template-columns: repeat(2, minmax(0, 1fr));

        gap: 1px;

        margin-top: 20px;

        overflow: hidden;

        border: 1px solid var(--patients-border);

        border-radius: 11px;

        background: var(--patients-border);

    }


    .patients-detail-item {

        display: flex;
        flex-direction: column;

        gap: 6px;

        min-width: 0;

        padding: 15px;

        background: #fff;

    }


    .patients-detail-full {

        grid-column: 1 / -1;

    }


    .patients-detail-item span {

        color: var(--patients-muted);

        font-size: 11px;
        font-weight: 600;

    }


    .patients-detail-item strong {

        overflow-wrap: anywhere;

        color: var(--patients-text);

        font-size: 13px;

    }


    .patients-detail-item small {

        color: var(--patients-muted);

        font-size: 11px;

    }


    /* ================================================================
       RESPONSIVE
    ================================================================ */

    @media (max-width: 800px) {

        .patients-page {

            padding: 20px;

        }


        .patients-header {

            align-items: flex-start;
            flex-direction: column;

        }


        .patients-primary-button {

            width: 100%;

        }


        .patients-toolbar {

            align-items: stretch;
            flex-direction: column;

        }


        .patients-search-wrapper {

            width: 100%;

        }


        .patients-counter {

            justify-content: flex-end;

        }


        .patients-form-grid {

            grid-template-columns: 1fr;

        }


        .patients-form-full {

            grid-column: auto;

        }


        .patients-detail-grid {

            grid-template-columns: 1fr;

        }


        .patients-detail-full {

            grid-column: auto;

        }

    }


    @media (max-width: 560px) {

        .patients-page {

            padding: 14px;

        }


        .patients-modal-overlay {

            padding: 10px;

        }


        .patients-modal {

            max-height: calc(100vh - 20px);

        }


        .patients-modal-header,
        .patients-form-section,
        .patients-view-content {

            padding: 20px;

        }


        .patients-info-box {

            margin: 16px 20px;

        }


        .patients-modal-footer {

            padding: 15px 20px;

        }


        .patients-profile {

            align-items: flex-start;
            flex-wrap: wrap;

        }


        .patients-profile-status {

            width: 100%;
            text-align: center;

        }

    }

</style>


{{-- =====================================================================
     JAVASCRIPT
===================================================================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | ELEMENTOS
    |--------------------------------------------------------------------------
    */

    const createModal =
        document.getElementById('createPatientModal');

    const editModal =
        document.getElementById('editPatientModal');

    const viewModal =
        document.getElementById('viewPatientModal');

    const createForm =
        document.getElementById('createPatientForm');

    const editForm =
        document.getElementById('editPatientForm');

    const searchInput =
        document.getElementById('buscar');

    const clearSearchButton =
        document.getElementById('clearPatientSearch');

    const tableBody =
        document.getElementById('patientsTableBody');

    const searchEmpty =
        document.getElementById('patientsSearchEmpty');

    const visibleCount =
        document.getElementById('visiblePatientsCount');

    const visibleLabel =
        document.getElementById('visiblePatientsLabel');


    /*
    |--------------------------------------------------------------------------
    | FUNCIONES DE MODAL
    |--------------------------------------------------------------------------
    */

    function openModal(modal) {

        if (!modal) {
            return;
        }

        modal.classList.add('is-open');

        modal.setAttribute(
            'aria-hidden',
            'false'
        );

        document.body.style.overflow = 'hidden';

    }


    function closeModal(modal) {

        if (!modal) {
            return;
        }

        modal.classList.remove('is-open');

        modal.setAttribute(
            'aria-hidden',
            'true'
        );

        const anyModalOpen =
            document.querySelector(
                '.patients-modal-overlay.is-open'
            );

        if (!anyModalOpen) {

            document.body.style.overflow = '';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | CREAR
    |--------------------------------------------------------------------------
    */

    function openCreatePatient() {

        if (!createModal) {
            return;
        }

        if (createForm) {

            createForm.reset();

        }

        openModal(createModal);

        setTimeout(function () {

            const firstField =
                document.getElementById(
                    'create_tipo_documento'
                );

            if (firstField) {
                firstField.focus();
            }

        }, 100);

    }


    const openCreateButton =
        document.getElementById(
            'openCreatePatientModal'
        );

    const openCreateEmptyButton =
        document.getElementById(
            'openCreatePatientModalEmpty'
        );


    if (openCreateButton) {

        openCreateButton.addEventListener(
            'click',
            openCreatePatient
        );

    }


    if (openCreateEmptyButton) {

        openCreateEmptyButton.addEventListener(
            'click',
            openCreatePatient
        );

    }


    /*
    |--------------------------------------------------------------------------
    | EDITAR
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '[data-patient-edit]'
    ).forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                if (!editModal || !editForm) {
                    return;
                }


                const id =
                    button.dataset.id;

                const userId =
                    button.dataset.userId || '';


                /*
                ------------------------------------------------------------
                CAMPOS
                ------------------------------------------------------------
                */

                document.getElementById(
                    'edit_tipo_documento'
                ).value =
                    button.dataset.tipoDocumento || '';


                document.getElementById(
                    'edit_numero_documento'
                ).value =
                    button.dataset.numeroDocumento || '';


                document.getElementById(
                    'edit_nombres'
                ).value =
                    button.dataset.nombres || '';


                document.getElementById(
                    'edit_apellidos'
                ).value =
                    button.dataset.apellidos || '';


                document.getElementById(
                    'edit_fecha_nacimiento'
                ).value =
                    button.dataset.fechaNacimiento || '';


                document.getElementById(
                    'edit_telefono'
                ).value =
                    button.dataset.telefono || '';


                document.getElementById(
                    'edit_correo'
                ).value =
                    button.dataset.correo || '';


                document.getElementById(
                    'edit_direccion'
                ).value =
                    button.dataset.direccion || '';


                document.getElementById(
                    'edit_estado'
                ).value =
                    button.dataset.estado || 'activo';


                /*
                ------------------------------------------------------------
                USUARIO
                ------------------------------------------------------------
                */

                const userSelect =
                    document.getElementById(
                        'edit_user_id'
                    );


                if (userSelect) {

                    Array.from(
                        userSelect.options
                    ).forEach(function (option) {

                        if (!option.value) {
                            return;
                        }

                        const assigned =
                            option.dataset.assigned === '1';

                        /*
                        El usuario asociado al paciente actual
                        permanece habilitado.
                        Los usuarios asociados a otros pacientes
                        quedan deshabilitados.
                        */

                        option.disabled =
                            assigned &&
                            option.value !== userId;

                    });


                    userSelect.value =
                        userId;

                }


                /*
                ------------------------------------------------------------
                ACTION
                ------------------------------------------------------------
                */

                editForm.action =
                    "{{ url('/patients') }}/" + id;


                openModal(editModal);

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | VER
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '[data-patient-view]'
    ).forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                if (!viewModal) {
                    return;
                }


                const nombres =
                    button.dataset.nombres || '';

                const apellidos =
                    button.dataset.apellidos || '';

                const fullName =
                    (
                        nombres + ' ' + apellidos
                    ).trim();


                /*
                ------------------------------------------------------------
                AVATAR
                ------------------------------------------------------------
                */

                const initials =
                    (
                        (nombres.charAt(0) || '') +
                        (apellidos.charAt(0) || '')
                    ).toUpperCase();


                document.getElementById(
                    'viewPatientAvatar'
                ).textContent =
                    initials || '--';


                /*
                ------------------------------------------------------------
                NOMBRE
                ------------------------------------------------------------
                */

                document.getElementById(
                    'viewPatientName'
                ).textContent =
                    fullName || '--';


                /*
                ------------------------------------------------------------
                DOCUMENTO
                ------------------------------------------------------------
                */

                document.getElementById(
                    'viewPatientDocument'
                ).textContent =
                    (
                        button.dataset.tipoDocumento || ''
                    ) +
                    ' ' +
                    (
                        button.dataset.numeroDocumento || ''
                    );


                /*
                ------------------------------------------------------------
                FECHA Y EDAD
                ------------------------------------------------------------
                */

                const birth =
                    button.dataset.fechaNacimiento || '';

                if (birth) {

                    const birthDate =
                        new Date(
                            birth + 'T00:00:00'
                        );

                    const formatted =
                        birthDate.toLocaleDateString(
                            'es-CO',
                            {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric'
                            }
                        );

                    document.getElementById(
                        'viewPatientBirth'
                    ).textContent =
                        formatted;


                    const today =
                        new Date();

                    let age =
                        today.getFullYear() -
                        birthDate.getFullYear();

                    const monthDifference =
                        today.getMonth() -
                        birthDate.getMonth();

                    if (
                        monthDifference < 0 ||
                        (
                            monthDifference === 0 &&
                            today.getDate() < birthDate.getDate()
                        )
                    ) {

                        age--;

                    }


                    document.getElementById(
                        'viewPatientAge'
                    ).textContent =
                        age + ' años';

                } else {

                    document.getElementById(
                        'viewPatientBirth'
                    ).textContent =
                        'No disponible';

                    document.getElementById(
                        'viewPatientAge'
                    ).textContent =
                        'No disponible';

                }


                /*
                ------------------------------------------------------------
                CONTACTO
                ------------------------------------------------------------
                */

                document.getElementById(
                    'viewPatientPhone'
                ).textContent =
                    button.dataset.telefono || 'No disponible';


                document.getElementById(
                    'viewPatientEmail'
                ).textContent =
                    button.dataset.correo || 'No disponible';


                document.getElementById(
                    'viewPatientAddress'
                ).textContent =
                    button.dataset.direccion || 'No registrada';


                /*
                ------------------------------------------------------------
                ESTADO
                ------------------------------------------------------------
                */

                const statusElement =
                    document.getElementById(
                        'viewPatientStatus'
                    );

                const estado =
                    button.dataset.estado || '';


                statusElement.textContent =
                    estado === 'activo'
                        ? 'Activo'
                        : 'Inactivo';


                statusElement.style.background =
                    estado === 'activo'
                        ? '#f0fdf4'
                        : '#fef2f2';


                statusElement.style.color =
                    estado === 'activo'
                        ? '#15803d'
                        : '#dc2626';


                /*
                ------------------------------------------------------------
                CUENTA DE ACCESO
                ------------------------------------------------------------
                */

                const userName =
                    button.dataset.userName || '';

                const userEmail =
                    button.dataset.userEmail || '';


                const userElement =
                    document.getElementById(
                        'viewPatientUser'
                    );

                const userEmailElement =
                    document.getElementById(
                        'viewPatientUserEmail'
                    );


                if (userName) {

                    userElement.textContent =
                        userName;

                    userEmailElement.textContent =
                        userEmail;

                } else {

                    userElement.textContent =
                        'Sin usuario asociado';

                    userEmailElement.textContent =
                        '';

                }


                openModal(viewModal);

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | CERRAR MODALES
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '[data-close-create-patient]'
    ).forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                closeModal(createModal);

            }
        );

    });


    document.querySelectorAll(
        '[data-close-edit-patient]'
    ).forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                closeModal(editModal);

            }
        );

    });


    document.querySelectorAll(
        '[data-close-view-patient]'
    ).forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                closeModal(viewModal);

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | CERRAR AL HACER CLICK FUERA
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '.patients-modal-overlay'
    ).forEach(function (overlay) {

        overlay.addEventListener(
            'click',
            function (event) {

                if (event.target === overlay) {

                    closeModal(overlay);

                }

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | ESCAPE
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key !== 'Escape') {
                return;
            }

            closeModal(createModal);
            closeModal(editModal);
            closeModal(viewModal);

        }
    );


    /*
    |--------------------------------------------------------------------------
    | BÚSQUEDA EN TIEMPO REAL
    |--------------------------------------------------------------------------
    */

    function filterPatients() {

        if (!searchInput || !tableBody) {
            return;
        }


        const value =
            searchInput.value
                .trim()
                .toLowerCase();


        const rows =
            tableBody.querySelectorAll(
                '.patient-row'
            );


        let visibleRows = 0;


        rows.forEach(function (row) {

            const searchData =
                row.dataset.search || '';


            const matches =
                !value ||
                searchData.includes(value);


            row.style.display =
                matches
                    ? ''
                    : 'none';


            if (matches) {

                visibleRows++;

            }

        });


        /*
        ------------------------------------------------------------
        CONTADOR
        ------------------------------------------------------------
        */

        if (visibleCount) {

            visibleCount.textContent =
                visibleRows;

        }


        if (visibleLabel) {

            visibleLabel.textContent =
                visibleRows === 1
                    ? 'paciente encontrado'
                    : 'pacientes encontrados';

        }


        /*
        ------------------------------------------------------------
        MENSAJE SIN RESULTADOS
        ------------------------------------------------------------
        */

        if (searchEmpty) {

            searchEmpty.style.display =
                value && visibleRows === 0
                    ? 'block'
                    : 'none';

        }


        /*
        ------------------------------------------------------------
        BOTÓN LIMPIAR
        ------------------------------------------------------------
        */

        if (clearSearchButton) {

            clearSearchButton.style.display =
                value
                    ? 'flex'
                    : 'none';

        }

    }


    if (searchInput) {

        searchInput.addEventListener(
            'input',
            filterPatients
        );

    }


    if (clearSearchButton) {

        clearSearchButton.addEventListener(
            'click',
            function () {

                searchInput.value = '';

                filterPatients();

                searchInput.focus();

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CONFIRMACIÓN ELIMINAR
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '.patients-delete-form'
    ).forEach(function (form) {

        form.addEventListener(
            'submit',
            function (event) {

                const confirmed =
                    window.confirm(
                        '¿Estás seguro de que deseas eliminar este paciente? Esta acción no se puede deshacer.'
                    );


                if (!confirmed) {

                    event.preventDefault();

                }

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | MOSTRAR BÚSQUEDA INICIAL
    |--------------------------------------------------------------------------
    */

    filterPatients();


    /*
    |--------------------------------------------------------------------------
    | ERRORES DE VALIDACIÓN
    |--------------------------------------------------------------------------
    |
    | Si Laravel devuelve errores después de intentar crear un paciente,
    | abrimos nuevamente la modal de creación.
    |
    */

    @if($errors->any())

        openModal(createModal);

    @endif

});

</script>

@endsection

