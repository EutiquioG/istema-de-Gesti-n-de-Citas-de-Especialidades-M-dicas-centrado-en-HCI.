@extends('layouts.app')

@section('title', 'Dashboard | Citas Médicas')

@section('content')

<div class="dashboard-page">

    {{-- =====================================================
         BIENVENIDA
         ===================================================== --}}

    <section class="dashboard-welcome">

        <div class="dashboard-welcome-content">

            <span class="dashboard-eyebrow">
                SISTEMA DE GESTIÓN
            </span>

            <h1 class="dashboard-welcome-title">
                Buenos días, {{ auth()->user()->name }}
            </h1>

            <p class="dashboard-welcome-text">
                Consulta rápidamente la información del sistema
                y gestiona las citas médicas.
            </p>

        </div>

        <div class="dashboard-welcome-icon" aria-hidden="true">
            ⚕
        </div>

    </section>


    {{-- =====================================================
         RESUMEN PRINCIPAL
         ===================================================== --}}

    <section class="dashboard-section">

        <div class="dashboard-section-heading">

            <div>
                <span class="dashboard-section-eyebrow">
                    RESUMEN
                </span>

                <h2>
                    Información general
                </h2>

                <p>
                    Estado actual de los registros del sistema.
                </p>
            </div>

        </div>


        <div class="dashboard-stats">

            {{-- PACIENTES --}}

            <article class="dashboard-stat">

                <div class="dashboard-stat-icon" aria-hidden="true">
                    ♙
                </div>

                <div class="dashboard-stat-info">

                    <span class="dashboard-stat-label">
                        Pacientes
                    </span>

                    <strong class="dashboard-stat-value">
                        {{ $totalPacientes }}
                    </strong>

                    <span class="dashboard-stat-description">
                        Pacientes registrados
                    </span>

                </div>

            </article>


            {{-- MÉDICOS --}}

            <article class="dashboard-stat">

                <div class="dashboard-stat-icon" aria-hidden="true">
                    ⚕
                </div>

                <div class="dashboard-stat-info">

                    <span class="dashboard-stat-label">
                        Médicos
                    </span>

                    <strong class="dashboard-stat-value">
                        {{ $totalMedicos }}
                    </strong>

                    <span class="dashboard-stat-description">
                        Profesionales registrados
                    </span>

                </div>

            </article>


            {{-- ESPECIALIDADES --}}

            <article class="dashboard-stat">

                <div class="dashboard-stat-icon" aria-hidden="true">
                    ▤
                </div>

                <div class="dashboard-stat-info">

                    <span class="dashboard-stat-label">
                        Especialidades
                    </span>

                    <strong class="dashboard-stat-value">
                        {{ $totalEspecialidades }}
                    </strong>

                    <span class="dashboard-stat-description">
                        Especialidades disponibles
                    </span>

                </div>

            </article>


            {{-- CITAS PENDIENTES --}}

            <article class="dashboard-stat">

                <div class="dashboard-stat-icon" aria-hidden="true">
                    ◷
                </div>

                <div class="dashboard-stat-info">

                    <span class="dashboard-stat-label">
                        Citas pendientes
                    </span>

                    <strong class="dashboard-stat-value">
                        {{ $citasPendientes }}
                    </strong>

                    <span class="dashboard-stat-description">
                        Pendientes de atención
                    </span>

                </div>

            </article>

        </div>

    </section>


    {{-- =====================================================
         CONTENIDO PRINCIPAL
         ===================================================== --}}

    <div class="dashboard-main-grid">

        {{-- =================================================
             PRÓXIMAS CITAS
             ================================================= --}}

        <section class="dashboard-panel">

            <div class="dashboard-panel-header">

                <div>

                    <span class="dashboard-section-eyebrow">
                        AGENDA
                    </span>

                    <h2 class="dashboard-panel-title">
                        Próximas citas
                    </h2>

                    <p class="dashboard-panel-description">
                        Citas programadas próximamente.
                    </p>

                </div>

                <a
                    href="{{ route('appointments.index') }}"
                    class="btn btn-secondary"
                >
                    Ver todas
                </a>

            </div>


            @if($proximasCitas->count())

                <div class="dashboard-table-wrapper">

                    <table class="dashboard-table">

                        <caption class="sr-only">
                            Próximas citas médicas
                        </caption>

                        <thead>

                            <tr>

                                <th scope="col">
                                    Paciente
                                </th>

                                <th scope="col">
                                    Médico
                                </th>

                                <th scope="col">
                                    Especialidad
                                </th>

                                <th scope="col">
                                    Fecha
                                </th>

                                <th scope="col">
                                    Hora
                                </th>

                                <th scope="col">
                                    Estado
                                </th>

                                <th scope="col">
                                    Acción
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($proximasCitas as $cita)

                                <tr>

                                    <td>
                                        <strong>
                                            {{ $cita->patient->nombre_completo }}
                                        </strong>
                                    </td>

                                    <td>
                                        {{ $cita->doctor->nombre_completo }}
                                    </td>

                                    <td>
                                        {{ $cita->specialty->nombre }}
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                                    </td>

                                    <td>
                                        {{ substr($cita->hora, 0, 5) }}
                                    </td>

                                    <td>

                                        @if($cita->estado === 'pendiente')

                                            <span class="badge badge-pendiente">
                                                Pendiente
                                            </span>

                                        @elseif($cita->estado === 'confirmada')

                                            <span class="badge badge-confirmada">
                                                Confirmada
                                            </span>

                                        @elseif($cita->estado === 'atendida')

                                            <span class="badge badge-atendida">
                                                Atendida
                                            </span>

                                        @elseif($cita->estado === 'cancelada')

                                            <span class="badge badge-cancelada">
                                                Cancelada
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        <a
                                            href="{{ route('appointments.show', $cita) }}"
                                            class="table-link"
                                        >
                                            Ver detalle
                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="empty-state">

                    <div
                        class="empty-icon"
                        aria-hidden="true"
                    >
                        ◷
                    </div>

                    <h3>
                        No hay citas programadas
                    </h3>

                    <p>
                        Cuando existan próximas citas,
                        aparecerán aquí.
                    </p>

                    <a
                        href="{{ route('appointments.create') }}"
                        class="btn btn-primary"
                    >
                        <span aria-hidden="true">+</span>
                        Crear primera cita
                    </a>

                </div>

            @endif

        </section>


        {{-- =================================================
             ACCIONES RÁPIDAS
             ================================================= --}}

        <section class="dashboard-panel dashboard-actions-panel">

            <div class="dashboard-panel-header">

                <div>

                    <span class="dashboard-section-eyebrow">
                        ACCIONES
                    </span>

                    <h2 class="dashboard-panel-title">
                        Accesos rápidos
                    </h2>

                    <p class="dashboard-panel-description">
                        Accede a las funciones principales.
                    </p>

                </div>

            </div>


            <div class="dashboard-actions">

                @if(auth()->user()->isAdmin())

                    <a
                        href="{{ route('patients.index') }}"
                        class="dashboard-action"
                    >
                        <span
                            class="dashboard-action-icon"
                            aria-hidden="true"
                        >
                            ♙
                        </span>

                        <span class="dashboard-action-content">
                            <strong>Pacientes</strong>
                            <small>Gestionar pacientes</small>
                        </span>

                        <span
                            class="dashboard-action-arrow"
                            aria-hidden="true"
                        >
                            →
                        </span>
                    </a>


                    <a
                        href="{{ route('doctors.index') }}"
                        class="dashboard-action"
                    >
                        <span
                            class="dashboard-action-icon"
                            aria-hidden="true"
                        >
                            ⚕
                        </span>

                        <span class="dashboard-action-content">
                            <strong>Médicos</strong>
                            <small>Gestionar profesionales</small>
                        </span>

                        <span
                            class="dashboard-action-arrow"
                            aria-hidden="true"
                        >
                            →
                        </span>
                    </a>


                    <a
                        href="{{ route('specialties.index') }}"
                        class="dashboard-action"
                    >
                        <span
                            class="dashboard-action-icon"
                            aria-hidden="true"
                        >
                            ▤
                        </span>

                        <span class="dashboard-action-content">
                            <strong>Especialidades</strong>
                            <small>Gestionar especialidades</small>
                        </span>

                        <span
                            class="dashboard-action-arrow"
                            aria-hidden="true"
                        >
                            →
                        </span>
                    </a>


                    <a
                        href="{{ route('appointments.index') }}"
                        class="dashboard-action"
                    >
                        <span
                            class="dashboard-action-icon"
                            aria-hidden="true"
                        >
                            ◷
                        </span>

                        <span class="dashboard-action-content">
                            <strong>Citas</strong>
                            <small>Gestionar citas médicas</small>
                        </span>

                        <span
                            class="dashboard-action-arrow"
                            aria-hidden="true"
                        >
                            →
                        </span>
                    </a>


                @elseif(auth()->user()->isMedico())

                    <a
                        href="{{ route('appointments.index') }}"
                        class="dashboard-action"
                    >
                        <span
                            class="dashboard-action-icon"
                            aria-hidden="true"
                        >
                            ◷
                        </span>

                        <span class="dashboard-action-content">
                            <strong>Mis citas</strong>
                            <small>Consultar mis citas</small>
                        </span>

                        <span
                            class="dashboard-action-arrow"
                            aria-hidden="true"
                        >
                            →
                        </span>
                    </a>


                    <a
                        href="{{ route('appointments.index', ['estado' => 'confirmada']) }}"
                        class="dashboard-action"
                    >
                        <span
                            class="dashboard-action-icon"
                            aria-hidden="true"
                        >
                            ✓
                        </span>

                        <span class="dashboard-action-content">
                            <strong>Próximas citas</strong>
                            <small>Ver citas confirmadas</small>
                        </span>

                        <span
                            class="dashboard-action-arrow"
                            aria-hidden="true"
                        >
                            →
                        </span>
                    </a>


                @elseif(auth()->user()->isPaciente())

                    <a
                        href="{{ route('appointments.index') }}"
                        class="dashboard-action"
                    >
                        <span
                            class="dashboard-action-icon"
                            aria-hidden="true"
                        >
                            ◷
                        </span>

                        <span class="dashboard-action-content">
                            <strong>Mis citas</strong>
                            <small>Consultar mis citas</small>
                        </span>

                        <span
                            class="dashboard-action-arrow"
                            aria-hidden="true"
                        >
                            →
                        </span>
                    </a>


                    <a
                        href="{{ route('appointments.create') }}"
                        class="dashboard-action"
                    >
                        <span
                            class="dashboard-action-icon"
                            aria-hidden="true"
                        >
                            +
                        </span>

                        <span class="dashboard-action-content">
                            <strong>Nueva cita</strong>
                            <small>Solicitar una cita médica</small>
                        </span>

                        <span
                            class="dashboard-action-arrow"
                            aria-hidden="true"
                        >
                            →
                        </span>
                    </a>

                @endif

            </div>

        </section>

    </div>


    {{-- =====================================================
         ESTADÍSTICAS DE CITAS
         ===================================================== --}}

    <section class="dashboard-section">

        <div class="dashboard-section-heading">

            <div>

                <span class="dashboard-section-eyebrow">
                    ESTADO DE CITAS
                </span>

                <h2>
                    Resumen de atención
                </h2>

                <p>
                    Estado general de las citas registradas.
                </p>

            </div>

        </div>


        <div class="dashboard-stats">

            {{-- CONFIRMADAS --}}

            <article class="dashboard-stat">

                <div class="dashboard-stat-icon" aria-hidden="true">
                    ✓
                </div>

                <div class="dashboard-stat-info">

                    <span class="dashboard-stat-label">
                        Citas confirmadas
                    </span>

                    <strong class="dashboard-stat-value">
                        {{ $citasConfirmadas }}
                    </strong>

                    <span class="dashboard-stat-description">
                        Citas listas para atención
                    </span>

                </div>

            </article>


            {{-- ATENDIDAS --}}

            <article class="dashboard-stat">

                <div class="dashboard-stat-icon" aria-hidden="true">
                    ✓
                </div>

                <div class="dashboard-stat-info">

                    <span class="dashboard-stat-label">
                        Citas atendidas
                    </span>

                    <strong class="dashboard-stat-value">
                        {{ $citasAtendidas }}
                    </strong>

                    <span class="dashboard-stat-description">
                        Consultas finalizadas
                    </span>

                </div>

            </article>


            {{-- CANCELADAS --}}

            <article class="dashboard-stat">

                <div class="dashboard-stat-icon" aria-hidden="true">
                    !
                </div>

                <div class="dashboard-stat-info">

                    <span class="dashboard-stat-label">
                        Citas canceladas
                    </span>

                    <strong class="dashboard-stat-value">
                        {{ $citasCanceladas }}
                    </strong>

                    <span class="dashboard-stat-description">
                        Citas que no se realizarán
                    </span>

                </div>

            </article>


            {{-- TOTAL --}}

            <article class="dashboard-stat">

                <div class="dashboard-stat-icon" aria-hidden="true">
                    ◷
                </div>

                <div class="dashboard-stat-info">

                    <span class="dashboard-stat-label">
                        Total de citas
                    </span>

                    <strong class="dashboard-stat-value">
                        {{ $totalCitas }}
                    </strong>

                    <span class="dashboard-stat-description">
                        Registros en el sistema
                    </span>

                </div>

            </article>

        </div>

    </section>


    {{-- =====================================================
         PIE INFORMATIVO
         ===================================================== --}}

    <section class="dashboard-footer-card">

        <div
            class="dashboard-footer-icon"
            aria-hidden="true"
        >
            ✓
        </div>

        <div>

            <strong>
                Sistema de Gestión de Citas de Especialidades Médicas
            </strong>

            <p>
                Información centralizada para facilitar la gestión
                y consulta de las citas médicas.
            </p>

        </div>

    </section>

</div>

@endsection