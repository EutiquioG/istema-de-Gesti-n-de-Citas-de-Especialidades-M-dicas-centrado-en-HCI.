```blade
@extends('layouts.app')

@section('title', 'Especialidades')

@section('content')

<div class="specialties-module">

    <div class="specialties-page">

        {{-- ============================================================
             ENCABEZADO
        ============================================================ --}}

        <div class="specialties-header">

            <div class="specialties-header-content">

                <span class="specialties-eyebrow">
                    Gestión clínica
                </span>

                <h1>
                    Especialidades
                </h1>

                <p>
                    Administra las especialidades médicas disponibles en el sistema.
                </p>

            </div>

            <button
                type="button"
                class="specialties-primary-button"
                id="openCreateSpecialtyModal"
            >
                <span class="specialties-button-icon">+</span>
                Nueva especialidad
            </button>

        </div>


        {{-- ============================================================
             MENSAJES
        ============================================================ --}}

        @if(session('success'))

            <div class="specialties-alert specialties-alert-success">
                {{ session('success') }}
            </div>

        @endif


        @if(session('error'))

            <div class="specialties-alert specialties-alert-error">
                {{ session('error') }}
            </div>

        @endif


        {{-- ============================================================
             CONTENEDOR PRINCIPAL
        ============================================================ --}}

        <div class="specialties-card">

            {{-- ========================================================
                 TOOLBAR
            ========================================================= --}}

            <div class="specialties-toolbar">

                <div class="specialties-search-wrapper">

                    <span class="specialties-search-icon">

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
                            <line
                                x1="21"
                                y1="21"
                                x2="16.65"
                                y2="16.65"
                            ></line>
                        </svg>

                    </span>

                    <input
                        type="text"
                        id="buscar"
                        name="buscar"
                        value="{{ request('buscar') }}"
                        class="specialties-search"
                        placeholder="Buscar por nombre o descripción..."
                        autocomplete="off"
                    >

                    <button
                        type="button"
                        id="clearSpecialtySearch"
                        class="specialties-search-clear"
                        title="Limpiar búsqueda"
                        aria-label="Limpiar búsqueda"
                    >
                        ×
                    </button>

                </div>


                <div class="specialties-counter">

                    <strong id="visibleSpecialtiesCount">
                        {{ $specialties->total() }}
                    </strong>

                    <span id="visibleSpecialtiesLabel">
                        especialidades registradas
                    </span>

                </div>

            </div>


            {{-- ========================================================
                 TABLA
            ========================================================= --}}

            <div class="specialties-table-wrapper">

                <table class="specialties-table">

                    <thead>

                        <tr>

                            <th>
                                Especialidad
                            </th>

                            <th>
                                Descripción
                            </th>

                            <th>
                                Estado
                            </th>

                            <th class="specialties-actions-column">
                                Acciones
                            </th>

                        </tr>

                    </thead>


                    <tbody id="specialtiesTableBody">

                        @forelse($specialties as $specialty)

                            @php

                                $initial =
                                    strtoupper(
                                        substr($specialty->nombre, 0, 1)
                                    );

                                $searchData = strtolower(
                                    $specialty->nombre . ' ' .
                                    ($specialty->descripcion ?? '')
                                );

                            @endphp

                            <tr
                                class="specialty-row"
                                data-search="{{ $searchData }}"
                            >

                                {{-- ESPECIALIDAD --}}

                                <td>

                                    <div class="specialties-person">

                                        <div class="specialties-avatar">
                                            {{ $initial }}
                                        </div>

                                        <div class="specialties-person-info">

                                            <strong>
                                                {{ $specialty->nombre }}
                                            </strong>

                                            <span>
                                                Especialidad médica
                                            </span>

                                        </div>

                                    </div>

                                </td>


                                {{-- DESCRIPCIÓN --}}

                                <td>

                                    <div class="specialties-description">

                                        @if($specialty->descripcion)

                                            {{ $specialty->descripcion }}

                                        @else

                                            <span>
                                                Sin descripción registrada
                                            </span>

                                        @endif

                                    </div>

                                </td>


                                {{-- ESTADO --}}

                                <td>

                                    @if($specialty->estado === 'activo')

                                        <span class="specialties-status specialties-status-active">
                                            Activa
                                        </span>

                                    @else

                                        <span class="specialties-status specialties-status-inactive">
                                            Inactiva
                                        </span>

                                    @endif

                                </td>


                                {{-- ACCIONES --}}

                                <td>

                                    <div class="specialties-actions">

                                        {{-- VER --}}

                                        <button
                                            type="button"
                                            class="specialties-action-button specialties-action-view"
                                            data-specialty-view
                                            data-id="{{ $specialty->id }}"
                                            data-nombre="{{ $specialty->nombre }}"
                                            data-descripcion="{{ $specialty->descripcion }}"
                                            data-estado="{{ $specialty->estado }}"
                                            title="Ver especialidad"
                                            aria-label="Ver especialidad"
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
                                                <circle
                                                    cx="12"
                                                    cy="12"
                                                    r="3"
                                                ></circle>
                                            </svg>

                                        </button>


                                        {{-- EDITAR --}}

                                        <button
                                            type="button"
                                            class="specialties-action-button specialties-action-edit"
                                            data-specialty-edit
                                            data-id="{{ $specialty->id }}"
                                            data-nombre="{{ $specialty->nombre }}"
                                            data-descripcion="{{ $specialty->descripcion }}"
                                            data-estado="{{ $specialty->estado }}"
                                            title="Editar especialidad"
                                            aria-label="Editar especialidad"
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

                                        <form
                                            method="POST"
                                            action="{{ route('specialties.destroy', $specialty) }}"
                                            class="specialties-delete-form"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="specialties-action-button specialties-action-delete"
                                                title="Eliminar especialidad"
                                                aria-label="Eliminar especialidad"
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

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="4"
                                    class="specialties-empty-cell"
                                >

                                    <div class="specialties-empty">

                                        <div class="specialties-empty-icon">
                                            +
                                        </div>

                                        <h3>
                                            No hay especialidades registradas
                                        </h3>

                                        <p>
                                            Registra la primera especialidad médica para comenzar a organizar la atención.
                                        </p>

                                        <button
                                            type="button"
                                            class="specialties-primary-button"
                                            id="openCreateSpecialtyModalEmpty"
                                        >
                                            Nueva especialidad
                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- ========================================================
                 SIN RESULTADOS
            ========================================================= --}}

            <div
                id="specialtiesSearchEmpty"
                class="specialties-search-empty"
                style="display: none;"
            >

                <div class="specialties-empty-icon">
                    ?
                </div>

                <h3>
                    No se encontraron especialidades
                </h3>

                <p>
                    Intenta realizar la búsqueda utilizando otro término.
                </p>

            </div>


            {{-- ========================================================
                 PAGINACIÓN
            ========================================================= --}}

            @if($specialties->hasPages())

                <div class="specialties-pagination">

                    {{ $specialties->links() }}

                </div>

            @endif

        </div>

    </div>

</div>


{{-- =====================================================================
     MODAL CREAR
===================================================================== --}}

<div
    id="createSpecialtyModal"
    class="specialties-modal-overlay"
    aria-hidden="true"
>

    <div
        class="specialties-modal specialties-modal-large"
        role="dialog"
        aria-modal="true"
        aria-labelledby="createSpecialtyModalTitle"
    >

        <div class="specialties-modal-header">

            <div>

                <span class="specialties-modal-eyebrow">
                    Gestión clínica
                </span>

                <h2 id="createSpecialtyModalTitle">
                    Nueva especialidad
                </h2>

                <p>
                    Registra una nueva especialidad médica en el sistema.
                </p>

            </div>

            <button
                type="button"
                class="specialties-modal-close"
                data-close-create-specialty
                aria-label="Cerrar"
            >
                ×
            </button>

        </div>


        <form
            method="POST"
            action="{{ route('specialties.store') }}"
            id="createSpecialtyForm"
        >

            @csrf


            {{-- SECCIÓN 01 --}}

            <div class="specialties-form-section">

                <div class="specialties-section-heading">

                    <div class="specialties-section-number">
                        01
                    </div>

                    <div>

                        <h3>
                            Información de la especialidad
                        </h3>

                        <p>
                            Define los datos principales de la especialidad médica.
                        </p>

                    </div>

                </div>


                <div class="specialties-form-grid">

                    <div class="specialties-form-group specialties-form-full">

                        <label for="create_nombre">
                            Nombre de la especialidad
                        </label>

                        <input
                            type="text"
                            name="nombre"
                            id="create_nombre"
                            value="{{ old('nombre') }}"
                            maxlength="150"
                            placeholder="Ej. Cardiología"
                            required
                        >

                        @error('nombre')

                            <small class="specialties-form-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    <div class="specialties-form-group specialties-form-full">

                        <label for="create_descripcion">
                            Descripción
                        </label>

                        <textarea
                            name="descripcion"
                            id="create_descripcion"
                            maxlength="500"
                            rows="4"
                            placeholder="Describe brevemente el área médica de la especialidad..."
                        >{{ old('descripcion') }}</textarea>

                        @error('descripcion')

                            <small class="specialties-form-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>

                </div>

            </div>


            {{-- INFORMACIÓN --}}

            <div class="specialties-info-box">

                <div class="specialties-info-icon">
                    ✓
                </div>

                <div>

                    <strong>
                        Registro activo
                    </strong>

                    <p>
                        La especialidad será registrada como activa y estará disponible para la programación de citas.
                    </p>

                </div>

            </div>


            {{-- FOOTER --}}

            <div class="specialties-modal-footer">

                <button
                    type="button"
                    class="specialties-secondary-button"
                    data-close-create-specialty
                >
                    Cancelar
                </button>

                <button
                    type="submit"
                    class="specialties-primary-button"
                >
                    Registrar especialidad
                </button>

            </div>

        </form>

    </div>

</div>


{{-- =====================================================================
     MODAL EDITAR
===================================================================== --}}

<div
    id="editSpecialtyModal"
    class="specialties-modal-overlay"
    aria-hidden="true"
>

    <div
        class="specialties-modal specialties-modal-large"
        role="dialog"
        aria-modal="true"
        aria-labelledby="editSpecialtyModalTitle"
    >

        <div class="specialties-modal-header">

            <div>

                <span class="specialties-modal-eyebrow">
                    Gestión clínica
                </span>

                <h2 id="editSpecialtyModalTitle">
                    Editar especialidad
                </h2>

                <p>
                    Actualiza la información registrada de la especialidad.
                </p>

            </div>

            <button
                type="button"
                class="specialties-modal-close"
                data-close-edit-specialty
                aria-label="Cerrar"
            >
                ×
            </button>

        </div>


        <form
            method="POST"
            action=""
            id="editSpecialtyForm"
        >

            @csrf
            @method('PUT')


            {{-- SECCIÓN 01 --}}

            <div class="specialties-form-section">

                <div class="specialties-section-heading">

                    <div class="specialties-section-number">
                        01
                    </div>

                    <div>

                        <h3>
                            Información de la especialidad
                        </h3>

                        <p>
                            Actualiza los datos principales de la especialidad.
                        </p>

                    </div>

                </div>


                <div class="specialties-form-grid">

                    <div class="specialties-form-group specialties-form-full">

                        <label for="edit_nombre">
                            Nombre de la especialidad
                        </label>

                        <input
                            type="text"
                            name="nombre"
                            id="edit_nombre"
                            maxlength="150"
                            required
                        >

                    </div>


                    <div class="specialties-form-group specialties-form-full">

                        <label for="edit_descripcion">
                            Descripción
                        </label>

                        <textarea
                            name="descripcion"
                            id="edit_descripcion"
                            maxlength="500"
                            rows="4"
                        ></textarea>

                    </div>

                </div>

            </div>


            {{-- SECCIÓN 02 --}}

            <div class="specialties-form-section">

                <div class="specialties-section-heading">

                    <div class="specialties-section-number">
                        02
                    </div>

                    <div>

                        <h3>
                            Estado
                        </h3>

                        <p>
                            Define si la especialidad puede utilizarse para nuevas citas.
                        </p>

                    </div>

                </div>


                <div class="specialties-form-grid">

                    <div class="specialties-form-group specialties-form-full">

                        <label for="edit_estado">
                            Estado de la especialidad
                        </label>

                        <select
                            name="estado"
                            id="edit_estado"
                            required
                        >

                            <option value="activo">
                                Activa
                            </option>

                            <option value="inactivo">
                                Inactiva
                            </option>

                        </select>

                    </div>

                </div>

            </div>


            {{-- FOOTER --}}

            <div class="specialties-modal-footer">

                <button
                    type="button"
                    class="specialties-secondary-button"
                    data-close-edit-specialty
                >
                    Cancelar
                </button>

                <button
                    type="submit"
                    class="specialties-primary-button"
                >
                    Guardar cambios
                </button>

            </div>

        </form>

    </div>

</div>


{{-- =====================================================================
     MODAL VER
===================================================================== --}}

<div
    id="viewSpecialtyModal"
    class="specialties-modal-overlay"
    aria-hidden="true"
>

    <div
        class="specialties-modal specialties-modal-large"
        role="dialog"
        aria-modal="true"
        aria-labelledby="viewSpecialtyModalTitle"
    >

        <div class="specialties-modal-header">

            <div>

                <span class="specialties-modal-eyebrow">
                    Información de especialidad
                </span>

                <h2 id="viewSpecialtyModalTitle">
                    Detalle de la especialidad
                </h2>

                <p>
                    Consulta la información registrada.
                </p>

            </div>

            <button
                type="button"
                class="specialties-modal-close"
                data-close-view-specialty
                aria-label="Cerrar"
            >
                ×
            </button>

        </div>


        <div class="specialties-view-content">

            {{-- PERFIL --}}

            <div class="specialties-profile">

                <div
                    class="specialties-profile-avatar"
                    id="viewSpecialtyAvatar"
                >
                    --
                </div>

                <div class="specialties-profile-info">

                    <h3 id="viewSpecialtyName">
                        --
                    </h3>

                    <span>
                        Especialidad médica
                    </span>

                </div>

                <div
                    class="specialties-profile-status"
                    id="viewSpecialtyStatus"
                >
                    --
                </div>

            </div>


            {{-- DETALLES --}}

            <div class="specialties-detail-grid">

                <div class="specialties-detail-item specialties-detail-full">

                    <span>
                        Nombre
                    </span>

                    <strong id="viewSpecialtyNameDetail">
                        --
                    </strong>

                </div>


                <div class="specialties-detail-item specialties-detail-full">

                    <span>
                        Descripción
                    </span>

                    <strong id="viewSpecialtyDescription">
                        --
                    </strong>

                </div>

            </div>

        </div>


        {{-- FOOTER --}}

        <div class="specialties-modal-footer">

            <button
                type="button"
                class="specialties-secondary-button"
                data-close-view-specialty
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

        --specialties-primary: #2563eb;
        --specialties-primary-dark: #1d4ed8;
        --specialties-primary-soft: #eff6ff;

        --specialties-bg: #f8fafc;
        --specialties-surface: #ffffff;

        --specialties-text: #111827;
        --specialties-muted: #6b7280;

        --specialties-border: #e5e7eb;

        --specialties-success: #15803d;
        --specialties-success-bg: #f0fdf4;

        --specialties-danger: #dc2626;
        --specialties-danger-bg: #fef2f2;

    }


    /* ================================================================
       BASE
    ================================================================ */

    .specialties-module {

        width: 100%;
        min-height: calc(100vh - 80px);

        background: var(--specialties-bg);

    }


    .specialties-page {

        max-width: 1400px;

        margin: 0 auto;

        padding: 32px;

    }


    /* ================================================================
       HEADER
    ================================================================ */

    .specialties-header {

        display: flex;
        align-items: flex-end;
        justify-content: space-between;

        gap: 24px;

        margin-bottom: 28px;

    }


    .specialties-eyebrow,
    .specialties-modal-eyebrow {

        display: block;

        margin-bottom: 7px;

        color: var(--specialties-primary);

        font-size: 12px;

        font-weight: 700;

        letter-spacing: .08em;

        text-transform: uppercase;

    }


    .specialties-header h1 {

        margin: 0;

        color: var(--specialties-text);

        font-size: 30px;

        line-height: 1.2;

        font-weight: 700;

    }


    .specialties-header p {

        margin: 8px 0 0;

        color: var(--specialties-muted);

        font-size: 14px;

    }


    /* ================================================================
       BOTONES
    ================================================================ */

    .specialties-primary-button,
    .specialties-secondary-button {

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


    .specialties-primary-button {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        gap: 8px;

        border: 1px solid var(--specialties-primary);

        background: var(--specialties-primary);

        color: #fff;

        box-shadow:
            0 2px 5px rgba(37, 99, 235, .15);

    }


    .specialties-primary-button:hover {

        background: var(--specialties-primary-dark);

        border-color: var(--specialties-primary-dark);

        transform: translateY(-1px);

    }


    .specialties-button-icon {

        font-size: 19px;

        line-height: 1;

        font-weight: 400;

    }


    .specialties-secondary-button {

        border: 1px solid var(--specialties-border);

        background: #fff;

        color: var(--specialties-text);

    }


    .specialties-secondary-button:hover {

        background: var(--specialties-bg);

        border-color: #d1d5db;

    }


    /* ================================================================
       ALERTAS
    ================================================================ */

    .specialties-alert {

        margin-bottom: 20px;

        padding: 13px 16px;

        border-radius: 10px;

        font-size: 14px;

        font-weight: 500;

    }


    .specialties-alert-success {

        border: 1px solid #bbf7d0;

        background: var(--specialties-success-bg);

        color: var(--specialties-success);

    }


    .specialties-alert-error {

        border: 1px solid #fecaca;

        background: var(--specialties-danger-bg);

        color: var(--specialties-danger);

    }


    /* ================================================================
       CARD
    ================================================================ */

    .specialties-card {

        overflow: hidden;

        border: 1px solid var(--specialties-border);

        border-radius: 15px;

        background: var(--specialties-surface);

        box-shadow:
            0 2px 5px rgba(15, 23, 42, .03);

    }


    /* ================================================================
       TOOLBAR
    ================================================================ */

    .specialties-toolbar {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 20px;

        padding: 18px 20px;

        border-bottom: 1px solid var(--specialties-border);

    }


    .specialties-search-wrapper {

        position: relative;

        width: min(500px, 100%);

    }


    .specialties-search-icon {

        position: absolute;

        top: 50%;

        left: 13px;

        display: flex;

        color: var(--specialties-muted);

        transform: translateY(-50%);

        pointer-events: none;

    }


    .specialties-search {

        width: 100%;

        height: 42px;

        padding: 0 42px 0 40px;

        border: 1px solid var(--specialties-border);

        border-radius: 9px;

        background: #fff;

        color: var(--specialties-text);

        font-size: 14px;

        outline: none;

        transition:
            border-color .18s ease,
            box-shadow .18s ease;

    }


    .specialties-search:focus {

        border-color: var(--specialties-primary);

        box-shadow:
            0 0 0 3px rgba(37, 99, 235, .10);

    }


    .specialties-search-clear {

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

        color: var(--specialties-muted);

        font-size: 20px;

        cursor: pointer;

        transform: translateY(-50%);

    }


    .specialties-search-clear:hover {

        background: var(--specialties-bg);

        color: var(--specialties-text);

    }


    .specialties-counter {

        display: flex;

        align-items: baseline;

        gap: 6px;

        white-space: nowrap;

        color: var(--specialties-muted);

        font-size: 13px;

    }


    .specialties-counter strong {

        color: var(--specialties-text);

        font-size: 15px;

    }


    /* ================================================================
       TABLA
    ================================================================ */

    .specialties-table-wrapper {

        width: 100%;

        overflow-x: auto;

    }


    .specialties-table {

        width: 100%;

        border-collapse: collapse;

    }


    .specialties-table thead th {

        padding: 14px 20px;

        border-bottom: 1px solid var(--specialties-border);

        background: #fafafa;

        color: var(--specialties-muted);

        font-size: 11px;

        font-weight: 700;

        letter-spacing: .06em;

        text-align: left;

        text-transform: uppercase;

    }


    .specialties-table tbody tr {

        transition: background .15s ease;

    }


    .specialties-table tbody tr:hover {

        background: #fafcff;

    }


    .specialties-table tbody td {

        padding: 16px 20px;

        border-bottom: 1px solid #f0f1f3;

        vertical-align: middle;

    }


    .specialties-person {

        display: flex;

        align-items: center;

        gap: 12px;

    }


    .specialties-avatar,
    .specialties-profile-avatar {

        display: flex;

        align-items: center;

        justify-content: center;

        flex-shrink: 0;

        border-radius: 50%;

        background: var(--specialties-primary-soft);

        color: var(--specialties-primary);

        font-weight: 700;

    }


    .specialties-avatar {

        width: 40px;

        height: 40px;

        font-size: 13px;

    }


    .specialties-person-info {

        display: flex;

        flex-direction: column;

        gap: 3px;

    }


    .specialties-person-info strong {

        color: var(--specialties-text);

        font-size: 14px;

    }


    .specialties-person-info span {

        color: var(--specialties-muted);

        font-size: 12px;

    }


    .specialties-description {

        max-width: 500px;

        color: var(--specialties-muted);

        font-size: 13px;

        line-height: 1.5;

    }


    .specialties-description span {

        color: #9ca3af;

        font-style: italic;

    }


    .specialties-status {

        display: inline-flex;

        align-items: center;

        padding: 5px 9px;

        border-radius: 999px;

        font-size: 11px;

        font-weight: 700;

    }


    .specialties-status-active {

        background: var(--specialties-success-bg);

        color: var(--specialties-success);

    }


    .specialties-status-inactive {

        background: var(--specialties-danger-bg);

        color: var(--specialties-danger);

    }


    .specialties-actions-column {

        width: 130px;

        text-align: right !important;

    }


    .specialties-actions {

        display: flex;

        align-items: center;

        justify-content: flex-end;

        gap: 6px;

    }


    .specialties-action-button {

        width: 34px;

        height: 34px;

        display: inline-flex;

        align-items: center;

        justify-content: center;

        padding: 0;

        border: 1px solid var(--specialties-border);

        border-radius: 8px;

        background: #fff;

        cursor: pointer;

        transition:
            background .18s ease,
            border-color .18s ease,
            color .18s ease;

    }


    .specialties-action-view {

        color: var(--specialties-primary);

    }


    .specialties-action-view:hover {

        border-color: #bfdbfe;

        background: var(--specialties-primary-soft);

    }


    .specialties-action-edit {

        color: #4b5563;

    }


    .specialties-action-edit:hover {

        border-color: #d1d5db;

        background: #f9fafb;

    }


    .specialties-action-delete {

        color: var(--specialties-danger);

    }


    .specialties-action-delete:hover {

        border-color: #fecaca;

        background: var(--specialties-danger-bg);

    }


    .specialties-delete-form {

        display: inline-flex;

        margin: 0;

    }


    /* ================================================================
       EMPTY
    ================================================================ */

    .specialties-empty-cell {

        padding: 0 !important;

    }


    .specialties-empty {

        display: flex;

        flex-direction: column;

        align-items: center;

        justify-content: center;

        padding: 70px 30px;

        text-align: center;

    }


    .specialties-empty-icon {

        width: 46px;

        height: 46px;

        display: flex;

        align-items: center;

        justify-content: center;

        margin-bottom: 15px;

        border-radius: 12px;

        background: var(--specialties-primary-soft);

        color: var(--specialties-primary);

        font-size: 24px;

    }


    .specialties-empty h3 {

        margin: 0;

        color: var(--specialties-text);

        font-size: 16px;

    }


    .specialties-empty p {

        max-width: 420px;

        margin: 8px 0 20px;

        color: var(--specialties-muted);

        font-size: 13px;

        line-height: 1.6;

    }


    .specialties-search-empty {

        padding: 55px 25px;

        border-top: 1px solid var(--specialties-border);

        text-align: center;

    }


    .specialties-search-empty .specialties-empty-icon {

        margin-left: auto;

        margin-right: auto;

    }


    .specialties-search-empty h3 {

        margin: 0;

        color: var(--specialties-text);

        font-size: 16px;

    }


    .specialties-search-empty p {

        margin: 8px 0 0;

        color: var(--specialties-muted);

        font-size: 13px;

    }


    /* ================================================================
       PAGINACIÓN
    ================================================================ */

    .specialties-pagination {

        padding: 17px 20px;

        border-top: 1px solid var(--specialties-border);

    }


    .specialties-pagination nav {

        display: flex;

        justify-content: center;

    }


    .specialties-pagination svg {

        width: 18px;

        height: 18px;

    }


    /* ================================================================
       MODALES
    ================================================================ */

    .specialties-modal-overlay {

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


    .specialties-modal-overlay.is-open {

        display: flex;

    }


    .specialties-modal {

        width: 100%;

        max-height: calc(100vh - 50px);

        overflow-y: auto;

        border: 1px solid rgba(255,255,255,.5);

        border-radius: 15px;

        background: #fff;

        box-shadow:
            0 25px 60px rgba(15, 23, 42, .20);

        animation: specialtiesModalIn .18s ease;

    }


    .specialties-modal-large {

        max-width: 760px;

    }


    @keyframes specialtiesModalIn {

        from {

            opacity: 0;

            transform: translateY(8px) scale(.99);

        }

        to {

            opacity: 1;

            transform: translateY(0) scale(1);

        }

    }


    .specialties-modal-header {

        display: flex;

        align-items: flex-start;

        justify-content: space-between;

        gap: 20px;

        padding: 24px 26px;

        border-bottom: 1px solid var(--specialties-border);

    }


    .specialties-modal-header h2 {

        margin: 0;

        color: var(--specialties-text);

        font-size: 21px;

    }


    .specialties-modal-header p {

        margin: 7px 0 0;

        color: var(--specialties-muted);

        font-size: 13px;

        line-height: 1.5;

    }


    .specialties-modal-close {

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

        color: var(--specialties-muted);

        font-size: 25px;

        line-height: 1;

        cursor: pointer;

    }


    .specialties-modal-close:hover {

        background: var(--specialties-bg);

        color: var(--specialties-text);

    }


    /* ================================================================
       FORMULARIOS
    ================================================================ */

    .specialties-form-section {

        padding: 24px 26px;

        border-bottom: 1px solid #f0f1f3;

    }


    .specialties-section-heading {

        display: flex;

        align-items: flex-start;

        gap: 12px;

        margin-bottom: 20px;

    }


    .specialties-section-number {

        width: 30px;

        height: 30px;

        display: flex;

        align-items: center;

        justify-content: center;

        flex-shrink: 0;

        border-radius: 8px;

        background: var(--specialties-primary-soft);

        color: var(--specialties-primary);

        font-size: 11px;

        font-weight: 700;

    }


    .specialties-section-heading h3 {

        margin: 1px 0 4px;

        color: var(--specialties-text);

        font-size: 14px;

    }


    .specialties-section-heading p {

        margin: 0;

        color: var(--specialties-muted);

        font-size: 12px;

        line-height: 1.5;

    }


    .specialties-form-grid {

        display: grid;

        grid-template-columns: repeat(2, minmax(0, 1fr));

        gap: 17px;

    }


    .specialties-form-group {

        display: flex;

        flex-direction: column;

        gap: 7px;

    }


    .specialties-form-full {

        grid-column: 1 / -1;

    }


    .specialties-form-group label {

        color: #374151;

        font-size: 12px;

        font-weight: 600;

    }


    .specialties-form-group input,
    .specialties-form-group select,
    .specialties-form-group textarea {

        width: 100%;

        padding: 10px 12px;

        border: 1px solid var(--specialties-border);

        border-radius: 8px;

        background: #fff;

        color: var(--specialties-text);

        font-family: inherit;

        font-size: 13px;

        outline: none;

        transition:
            border-color .18s ease,
            box-shadow .18s ease;

    }


    .specialties-form-group input,
    .specialties-form-group select {

        min-height: 42px;

    }


    .specialties-form-group textarea {

        resize: vertical;

        min-height: 105px;

        line-height: 1.5;

    }


    .specialties-form-group input:focus,
    .specialties-form-group select:focus,
    .specialties-form-group textarea:focus {

        border-color: var(--specialties-primary);

        box-shadow:
            0 0 0 3px rgba(37, 99, 235, .10);

    }


    .specialties-form-error {

        color: var(--specialties-danger);

        font-size: 11px;

    }


    .specialties-info-box {

        display: flex;

        align-items: flex-start;

        gap: 12px;

        margin: 20px 26px;

        padding: 13px 15px;

        border: 1px solid #bbf7d0;

        border-radius: 9px;

        background: var(--specialties-success-bg);

    }


    .specialties-info-icon {

        width: 24px;

        height: 24px;

        display: flex;

        align-items: center;

        justify-content: center;

        flex-shrink: 0;

        border-radius: 50%;

        background: #dcfce7;

        color: var(--specialties-success);

        font-size: 12px;

        font-weight: 700;

    }


    .specialties-info-box strong {

        display: block;

        margin-bottom: 3px;

        color: var(--specialties-success);

        font-size: 12px;

    }


    .specialties-info-box p {

        margin: 0;

        color: #166534;

        font-size: 11px;

        line-height: 1.5;

    }


    .specialties-modal-footer {

        display: flex;

        align-items: center;

        justify-content: flex-end;

        gap: 10px;

        padding: 17px 26px;

        border-top: 1px solid var(--specialties-border);

        background: #fafafa;

    }


    /* ================================================================
       MODAL VER
    ================================================================ */

    .specialties-view-content {

        padding: 26px;

    }


    .specialties-profile {

        display: flex;

        align-items: center;

        gap: 15px;

        padding: 17px;

        border: 1px solid var(--specialties-border);

        border-radius: 11px;

        background: #fafcff;

    }


    .specialties-profile-avatar {

        width: 54px;

        height: 54px;

        font-size: 18px;

    }


    .specialties-profile-info {

        flex: 1;

        min-width: 0;

    }


    .specialties-profile-info h3 {

        margin: 0 0 5px;

        color: var(--specialties-text);

        font-size: 17px;

    }


    .specialties-profile-info span {

        color: var(--specialties-muted);

        font-size: 12px;

    }


    .specialties-profile-status {

        padding: 5px 10px;

        border-radius: 999px;

        font-size: 11px;

        font-weight: 700;

    }


    .specialties-detail-grid {

        display: grid;

        grid-template-columns: repeat(2, minmax(0, 1fr));

        gap: 1px;

        margin-top: 20px;

        overflow: hidden;

        border: 1px solid var(--specialties-border);

        border-radius: 11px;

        background: var(--specialties-border);

    }


    .specialties-detail-item {

        display: flex;

        flex-direction: column;

        gap: 6px;

        min-width: 0;

        padding: 15px;

        background: #fff;

    }


    .specialties-detail-full {

        grid-column: 1 / -1;

    }


    .specialties-detail-item span {

        color: var(--specialties-muted);

        font-size: 11px;

        font-weight: 600;

    }


    .specialties-detail-item strong {

        overflow-wrap: anywhere;

        color: var(--specialties-text);

        font-size: 13px;

        line-height: 1.6;

    }


    /* ================================================================
       RESPONSIVE
    ================================================================ */

    @media (max-width: 800px) {

        .specialties-page {

            padding: 20px;

        }


        .specialties-header {

            align-items: flex-start;

            flex-direction: column;

        }


        .specialties-primary-button {

            width: 100%;

        }


        .specialties-toolbar {

            align-items: stretch;

            flex-direction: column;

        }


        .specialties-search-wrapper {

            width: 100%;

        }


        .specialties-counter {

            justify-content: flex-end;

        }


        .specialties-form-grid {

            grid-template-columns: 1fr;

        }


        .specialties-form-full {

            grid-column: auto;

        }


        .specialties-detail-grid {

            grid-template-columns: 1fr;

        }


        .specialties-detail-full {

            grid-column: auto;

        }

    }


    @media (max-width: 560px) {

        .specialties-page {

            padding: 14px;

        }


        .specialties-modal-overlay {

            padding: 10px;

        }


        .specialties-modal {

            max-height: calc(100vh - 20px);

        }


        .specialties-modal-header,
        .specialties-form-section,
        .specialties-view-content {

            padding: 20px;

        }


        .specialties-info-box {

            margin: 16px 20px;

        }


        .specialties-modal-footer {

            padding: 15px 20px;

        }


        .specialties-profile {

            align-items: flex-start;

            flex-wrap: wrap;

        }


        .specialties-profile-status {

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
        document.getElementById(
            'createSpecialtyModal'
        );

    const editModal =
        document.getElementById(
            'editSpecialtyModal'
        );

    const viewModal =
        document.getElementById(
            'viewSpecialtyModal'
        );

    const createForm =
        document.getElementById(
            'createSpecialtyForm'
        );

    const editForm =
        document.getElementById(
            'editSpecialtyForm'
        );

    const searchInput =
        document.getElementById(
            'buscar'
        );

    const clearSearchButton =
        document.getElementById(
            'clearSpecialtySearch'
        );

    const tableBody =
        document.getElementById(
            'specialtiesTableBody'
        );

    const searchEmpty =
        document.getElementById(
            'specialtiesSearchEmpty'
        );

    const visibleCount =
        document.getElementById(
            'visibleSpecialtiesCount'
        );

    const visibleLabel =
        document.getElementById(
            'visibleSpecialtiesLabel'
        );


    /*
    |--------------------------------------------------------------------------
    | MODALES
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

        const anotherModal =
            document.querySelector(
                '.specialties-modal-overlay.is-open'
            );

        if (!anotherModal) {

            document.body.style.overflow = '';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | CREAR
    |--------------------------------------------------------------------------
    */

    function openCreateSpecialty() {

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
                    'create_nombre'
                );

            if (firstField) {

                firstField.focus();

            }

        }, 100);

    }


    const openCreateButton =
        document.getElementById(
            'openCreateSpecialtyModal'
        );

    const openCreateEmptyButton =
        document.getElementById(
            'openCreateSpecialtyModalEmpty'
        );


    if (openCreateButton) {

        openCreateButton.addEventListener(
            'click',
            openCreateSpecialty
        );

    }


    if (openCreateEmptyButton) {

        openCreateEmptyButton.addEventListener(
            'click',
            openCreateSpecialty
        );

    }


    /*
    |--------------------------------------------------------------------------
    | EDITAR
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '[data-specialty-edit]'
    ).forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                if (!editModal || !editForm) {
                    return;
                }


                const id =
                    button.dataset.id;


                document.getElementById(
                    'edit_nombre'
                ).value =
                    button.dataset.nombre || '';


                document.getElementById(
                    'edit_descripcion'
                ).value =
                    button.dataset.descripcion || '';


                document.getElementById(
                    'edit_estado'
                ).value =
                    button.dataset.estado || 'activo';


                editForm.action =
                    "{{ url('/specialties') }}/" + id;


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
        '[data-specialty-view]'
    ).forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                if (!viewModal) {
                    return;
                }


                const nombre =
                    button.dataset.nombre || '';

                const descripcion =
                    button.dataset.descripcion || '';

                const estado =
                    button.dataset.estado || '';


                /*
                ------------------------------------------------------------
                AVATAR
                ------------------------------------------------------------
                */

                document.getElementById(
                    'viewSpecialtyAvatar'
                ).textContent =
                    nombre.charAt(0).toUpperCase() || '--';


                /*
                ------------------------------------------------------------
                NOMBRE
                ------------------------------------------------------------
                */

                document.getElementById(
                    'viewSpecialtyName'
                ).textContent =
                    nombre || '--';


                document.getElementById(
                    'viewSpecialtyNameDetail'
                ).textContent =
                    nombre || '--';


                /*
                ------------------------------------------------------------
                DESCRIPCIÓN
                ------------------------------------------------------------
                */

                document.getElementById(
                    'viewSpecialtyDescription'
                ).textContent =
                    descripcion ||
                    'Sin descripción registrada';


                /*
                ------------------------------------------------------------
                ESTADO
                ------------------------------------------------------------
                */

                const statusElement =
                    document.getElementById(
                        'viewSpecialtyStatus'
                    );


                statusElement.textContent =
                    estado === 'activo'
                        ? 'Activa'
                        : 'Inactiva';


                statusElement.style.background =
                    estado === 'activo'
                        ? '#f0fdf4'
                        : '#fef2f2';


                statusElement.style.color =
                    estado === 'activo'
                        ? '#15803d'
                        : '#dc2626';


                openModal(viewModal);

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | CERRAR
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '[data-close-create-specialty]'
    ).forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                closeModal(createModal);

            }
        );

    });


    document.querySelectorAll(
        '[data-close-edit-specialty]'
    ).forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                closeModal(editModal);

            }
        );

    });


    document.querySelectorAll(
        '[data-close-view-specialty]'
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
    | CLICK FUERA
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '.specialties-modal-overlay'
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
    | BÚSQUEDA
    |--------------------------------------------------------------------------
    */

    function filterSpecialties() {

        if (!searchInput || !tableBody) {
            return;
        }


        const value =
            searchInput.value
                .trim()
                .toLowerCase();


        const rows =
            tableBody.querySelectorAll(
                '.specialty-row'
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


        if (visibleCount) {

            visibleCount.textContent =
                visibleRows;

        }


        if (visibleLabel) {

            visibleLabel.textContent =
                visibleRows === 1
                    ? 'especialidad encontrada'
                    : 'especialidades encontradas';

        }


        if (searchEmpty) {

            searchEmpty.style.display =
                value && visibleRows === 0
                    ? 'block'
                    : 'none';

        }


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
            filterSpecialties
        );

    }


    if (clearSearchButton) {

        clearSearchButton.addEventListener(
            'click',
            function () {

                searchInput.value = '';

                filterSpecialties();

                searchInput.focus();

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | ELIMINAR
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '.specialties-delete-form'
    ).forEach(function (form) {

        form.addEventListener(
            'submit',
            function (event) {

                const confirmed =
                    window.confirm(
                        '¿Estás seguro de que deseas eliminar esta especialidad? Esta acción no se puede deshacer.'
                    );


                if (!confirmed) {

                    event.preventDefault();

                }

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | BÚSQUEDA INICIAL
    |--------------------------------------------------------------------------
    */

    filterSpecialties();


    /*
    |--------------------------------------------------------------------------
    | ERRORES DE VALIDACIÓN
    |--------------------------------------------------------------------------
    */

    @if($errors->any())

        openModal(createModal);

    @endif

});

</script>

@endsection
```
