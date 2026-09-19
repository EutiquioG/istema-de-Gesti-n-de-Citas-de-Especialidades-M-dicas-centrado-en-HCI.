@extends('layouts.app')

@section('title', 'Dashboard | Citas Médicas')

@push('styles')
<style>
    /* =========================================================
       DASHBOARD
       ========================================================= */

    .medical-dashboard {
        width: 100%;
        max-width: 1440px;
        margin: 0 auto;
        padding: 28px 32px 40px;
        box-sizing: border-box;
        color: #172033;
    }

    .medical-dashboard *,
    .medical-dashboard *::before,
    .medical-dashboard *::after {
        box-sizing: border-box;
    }

    /* =========================================================
       ENCABEZADO
       ========================================================= */

    .medical-dashboard .dashboard-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 30px;
        min-height: 180px;
        margin-bottom: 30px;
        padding: 34px 38px;
        background: #ffffff;
        border: 1px solid #e5e9f0;
        border-radius: 18px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, 0.04);
    }

    .medical-dashboard .hero-content {
        min-width: 0;
    }

    .medical-dashboard .hero-eyebrow {
        display: block;
        margin-bottom: 8px;
        color: #2563eb;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .medical-dashboard .hero-title {
        margin: 0;
        color: #111827;
        font-size: 30px;
        line-height: 1.2;
        font-weight: 700;
    }

    .medical-dashboard .hero-description {
        max-width: 650px;
        margin: 10px 0 0;
        color: #6b7280;
        font-size: 15px;
        line-height: 1.6;
    }

    .medical-dashboard .hero-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 72px;
        width: 72px;
        height: 72px;
        border-radius: 18px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 32px;
    }

    /* =========================================================
       TÍTULOS DE SECCIÓN
       ========================================================= */

    .medical-dashboard .dashboard-section {
        margin-bottom: 30px;
    }

    .medical-dashboard .section-heading {
        margin-bottom: 17px;
    }

    .medical-dashboard .section-eyebrow {
        display: block;
        margin-bottom: 5px;
        color: #2563eb;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .medical-dashboard .section-title {
        margin: 0;
        color: #111827;
        font-size: 20px;
        line-height: 1.3;
        font-weight: 700;
    }

    .medical-dashboard .section-description {
        margin: 5px 0 0;
        color: #6b7280;
        font-size: 13px;
    }

    /* =========================================================
       ESTADÍSTICAS
       ========================================================= */

    .medical-dashboard .stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    .medical-dashboard .stat {
        display: flex;
        align-items: center;
        gap: 16px;
        min-width: 0;
        padding: 22px;
        background: #ffffff;
        border: 1px solid #e5e9f0;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.035);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .medical-dashboard .stat:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.07);
    }

    .medical-dashboard .stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 48px;
        width: 48px;
        height: 48px;
        border-radius: 13px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 21px;
    }

    .medical-dashboard .stat-content {
        min-width: 0;
    }

    .medical-dashboard .stat-label {
        display: block;
        color: #6b7280;
        font-size: 12px;
        font-weight: 600;
    }

    .medical-dashboard .stat-value {
        display: block;
        margin-top: 2px;
        color: #111827;
        font-size: 28px;
        line-height: 1.15;
        font-weight: 750;
    }

    .medical-dashboard .stat-description {
        display: block;
        margin-top: 4px;
        color: #9ca3af;
        font-size: 11px;
    }

    /* =========================================================
       GRID PRINCIPAL
       ========================================================= */

    .medical-dashboard .main-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.75fr) minmax(300px, 0.75fr);
        gap: 22px;
        margin-bottom: 30px;
    }

    /* =========================================================
       PANELES
       ========================================================= */

    .medical-dashboard .panel {
        min-width: 0;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e5e9f0;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.035);
    }

    .medical-dashboard .panel-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        padding: 23px 24px 20px;
        border-bottom: 1px solid #edf0f4;
    }

    .medical-dashboard .panel-eyebrow {
        display: block;
        margin-bottom: 5px;
        color: #2563eb;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .medical-dashboard .panel-title {
        margin: 0;
        color: #111827;
        font-size: 19px;
        font-weight: 700;
    }

    .medical-dashboard .panel-description {
        margin: 5px 0 0;
        color: #6b7280;
        font-size: 13px;
    }

    /* =========================================================
       BOTÓN
       ========================================================= */

    .medical-dashboard .dashboard-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 38px;
        padding: 8px 15px;
        border: 1px solid #dbe2ea;
        border-radius: 9px;
        background: #ffffff;
        color: #374151;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.18s ease;
    }

    .medical-dashboard .dashboard-button:hover {
        border-color: #2563eb;
        background: #eff6ff;
        color: #2563eb;
    }

    .medical-dashboard .dashboard-button-primary {
        border-color: #2563eb;
        background: #2563eb;
        color: #ffffff;
    }

    .medical-dashboard .dashboard-button-primary:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
        color: #ffffff;
    }

    /* =========================================================
       TABLA
       ========================================================= */

    .medical-dashboard .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .medical-dashboard .appointments-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
    }

    .medical-dashboard .appointments-table th {
        padding: 13px 17px;
        background: #f8fafc;
        border-bottom: 1px solid #e5e9f0;
        color: #6b7280;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-align: left;
        white-space: nowrap;
        text-transform: uppercase;
    }

    .medical-dashboard .appointments-table td {
        padding: 14px 17px;
        border-bottom: 1px solid #edf0f4;
        color: #4b5563;
        font-size: 12px;
        vertical-align: middle;
    }

    .medical-dashboard .appointments-table tbody tr:last-child td {
        border-bottom: none;
    }

    .medical-dashboard .appointments-table tbody tr:hover {
        background: #f8fafc;
    }

    .medical-dashboard .patient-name {
        color: #111827;
        font-weight: 650;
    }

    .medical-dashboard .detail-link {
        color: #2563eb;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
    }

    .medical-dashboard .detail-link:hover {
        text-decoration: underline;
    }

    /* =========================================================
       ESTADOS
       ========================================================= */

    .medical-dashboard .status {
        display: inline-flex;
        align-items: center;
        min-height: 25px;
        padding: 4px 9px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .medical-dashboard .status-pending {
        background: #fff7ed;
        color: #c2410c;
    }

    .medical-dashboard .status-confirmed {
        background: #ecfdf5;
        color: #047857;
    }

    .medical-dashboard .status-attended {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .medical-dashboard .status-cancelled {
        background: #fef2f2;
        color: #b91c1c;
    }

    /* =========================================================
       ACCIONES
       ========================================================= */

    .medical-dashboard .actions {
        display: flex;
        flex-direction: column;
        padding: 9px;
    }

    .medical-dashboard .action {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 12px;
        border-radius: 11px;
        text-decoration: none;
        transition: background 0.18s ease;
    }

    .medical-dashboard .action:hover {
        background: #f8fafc;
    }

    .medical-dashboard .action-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 40px;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 18px;
    }

    .medical-dashboard .action-content {
        display: flex;
        flex: 1;
        flex-direction: column;
        min-width: 0;
    }

    .medical-dashboard .action-content strong {
        color: #111827;
        font-size: 13px;
        font-weight: 650;
    }

    .medical-dashboard .action-content small {
        margin-top: 2px;
        color: #9ca3af;
        font-size: 11px;
    }

    .medical-dashboard .action-arrow {
        color: #9ca3af;
        font-size: 16px;
    }

    .medical-dashboard .action:hover .action-arrow {
        color: #2563eb;
    }

    /* =========================================================
       ESTADO VACÍO
       ========================================================= */

    .medical-dashboard .empty {
        padding: 55px 25px;
        text-align: center;
    }

    .medical-dashboard .empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        margin: 0 auto 14px;
        border-radius: 50%;
        background: #eff6ff;
        color: #2563eb;
        font-size: 21px;
    }

    .medical-dashboard .empty h3 {
        margin: 0;
        color: #111827;
        font-size: 16px;
    }

    .medical-dashboard .empty p {
        margin: 6px 0 18px;
        color: #6b7280;
        font-size: 13px;
    }

    /* =========================================================
       PIE
       ========================================================= */

    .medical-dashboard .dashboard-footer {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 20px 23px;
        background: #ffffff;
        border: 1px solid #e5e9f0;
        border-radius: 16px;
    }

    .medical-dashboard .footer-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 40px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #ecfdf5;
        color: #047857;
        font-size: 16px;
    }

    .medical-dashboard .footer-title {
        display: block;
        color: #111827;
        font-size: 13px;
        font-weight: 650;
    }

    .medical-dashboard .footer-text {
        margin: 3px 0 0;
        color: #9ca3af;
        font-size: 11px;
    }

    /* =========================================================
       RESPONSIVE
       ========================================================= */

    @media (max-width: 1200px) {

        .medical-dashboard .stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .medical-dashboard .main-grid {
            grid-template-columns: 1fr;
        }

    }

    @media (max-width: 768px) {

        .medical-dashboard {
            padding: 20px 16px 30px;
        }

        .medical-dashboard .dashboard-hero {
            min-height: auto;
            padding: 25px;
        }

        .medical-dashboard .hero-title {
            font-size: 25px;
        }

        .medical-dashboard .hero-icon {
            display: none;
        }

        .medical-dashboard .panel-header {
            flex-direction: column;
            align-items: stretch;
        }

        .medical-dashboard .dashboard-button {
            align-self: flex-start;
        }

    }

    @media (max-width: 560px) {

        .medical-dashboard {
            padding: 16px 12px 25px;
        }

        .medical-dashboard .stats {
            grid-template-columns: 1fr;
        }

        .medical-dashboard .dashboard-hero {
            padding: 21px;
            border-radius: 14px;
        }

        .medical-dashboard .hero-title {
            font-size: 22px;
        }

        .medical-dashboard .hero-description {
            font-size: 13px;
        }

        .medical-dashboard .stat {
            padding: 18px;
        }

        .medical-dashboard .panel-header {
            padding: 19px;
        }

        .medical-dashboard .dashboard-footer {
            align-items: flex-start;
        }

    }
</style>
@endpush


@section('content')

<div class="medical-dashboard">

    {{-- =====================================================
         BIENVENIDA
         ===================================================== --}}

    <section class="dashboard-hero">

        <div class="hero-content">

            <span class="hero-eyebrow">
                Sistema de gestión
            </span>

            <h1 class="hero-title">
                Buenos días, {{ auth()->user()->name }}
            </h1>

            <p class="hero-description">
                Consulta rápidamente la información del sistema
                y gestiona las citas médicas.
            </p>

        </div>

        <div class="hero-icon" aria-hidden="true">
            ⚕
        </div>

    </section>


    {{-- =====================================================
         RESUMEN
         ===================================================== --}}

    <section class="dashboard-section">

        <div class="section-heading">

            <span class="section-eyebrow">
                Resumen
            </span>

            <h2 class="section-title">
                Información general
            </h2>

            <p class="section-description">
                Estado actual de los registros del sistema.
            </p>

        </div>


        <div class="stats">

            <article class="stat">

                <div class="stat-icon" aria-hidden="true">
                    ♙
                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        Pacientes
                    </span>

                    <strong class="stat-value">
                        {{ $totalPacientes }}
                    </strong>

                    <span class="stat-description">
                        Pacientes registrados
                    </span>

                </div>

            </article>


            <article class="stat">

                <div class="stat-icon" aria-hidden="true">
                    ⚕
                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        Médicos
                    </span>

                    <strong class="stat-value">
                        {{ $totalMedicos }}
                    </strong>

                    <span class="stat-description">
                        Profesionales registrados
                    </span>

                </div>

            </article>


            <article class="stat">

                <div class="stat-icon" aria-hidden="true">
                    ▤
                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        Especialidades
                    </span>

                    <strong class="stat-value">
                        {{ $totalEspecialidades }}
                    </strong>

                    <span class="stat-description">
                        Especialidades disponibles
                    </span>

                </div>

            </article>


            <article class="stat">

                <div class="stat-icon" aria-hidden="true">
                    ◷
                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        Citas pendientes
                    </span>

                    <strong class="stat-value">
                        {{ $citasPendientes }}
                    </strong>

                    <span class="stat-description">
                        Pendientes de atención
                    </span>

                </div>

            </article>

        </div>

    </section>


    {{-- =====================================================
         AGENDA + ACCIONES
         ===================================================== --}}

    <div class="main-grid">

        {{-- PRÓXIMAS CITAS --}}

        <section class="panel">

            <div class="panel-header">

                <div>

                    <span class="panel-eyebrow">
                        Agenda
                    </span>

                    <h2 class="panel-title">
                        Próximas citas
                    </h2>

                    <p class="panel-description">
                        Citas programadas próximamente.
                    </p>

                </div>

                <a
                    href="{{ route('appointments.index') }}"
                    class="dashboard-button"
                >
                    Ver todas
                </a>

            </div>


            @if($proximasCitas->count())

                <div class="table-wrapper">

                    <table class="appointments-table">

                        <caption class="sr-only">
                            Próximas citas médicas
                        </caption>

                        <thead>

                            <tr>
                                <th>Paciente</th>
                                <th>Médico</th>
                                <th>Especialidad</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($proximasCitas as $cita)

                                <tr>

                                    <td>
                                        <span class="patient-name">
                                            {{ $cita->patient->nombre_completo }}
                                        </span>
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

                                            <span class="status status-pending">
                                                Pendiente
                                            </span>

                                        @elseif($cita->estado === 'confirmada')

                                            <span class="status status-confirmed">
                                                Confirmada
                                            </span>

                                        @elseif($cita->estado === 'atendida')

                                            <span class="status status-attended">
                                                Atendida
                                            </span>

                                        @elseif($cita->estado === 'cancelada')

                                            <span class="status status-cancelled">
                                                Cancelada
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        <a
                                            href="{{ route('appointments.show', $cita) }}"
                                            class="detail-link"
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

                <div class="empty">

                    <div class="empty-icon" aria-hidden="true">
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
                        class="dashboard-button dashboard-button-primary"
                    >
                        + Crear primera cita
                    </a>

                </div>

            @endif

        </section>


        {{-- ACCIONES RÁPIDAS --}}

        <section class="panel">

            <div class="panel-header">

                <div>

                    <span class="panel-eyebrow">
                        Acciones
                    </span>

                    <h2 class="panel-title">
                        Accesos rápidos
                    </h2>

                    <p class="panel-description">
                        Accede a las funciones principales.
                    </p>

                </div>

            </div>


            <div class="actions">

                @if(auth()->user()->isAdmin())

                    <a
                        href="{{ route('patients.index') }}"
                        class="action"
                    >
                        <span class="action-icon" aria-hidden="true">
                            ♙
                        </span>

                        <span class="action-content">
                            <strong>Pacientes</strong>
                            <small>Gestionar pacientes</small>
                        </span>

                        <span class="action-arrow" aria-hidden="true">
                            →
                        </span>
                    </a>


                    <a
                        href="{{ route('doctors.index') }}"
                        class="action"
                    >
                        <span class="action-icon" aria-hidden="true">
                            ⚕
                        </span>

                        <span class="action-content">
                            <strong>Médicos</strong>
                            <small>Gestionar profesionales</small>
                        </span>

                        <span class="action-arrow" aria-hidden="true">
                            →
                        </span>
                    </a>


                    <a
                        href="{{ route('specialties.index') }}"
                        class="action"
                    >
                        <span class="action-icon" aria-hidden="true">
                            ▤
                        </span>

                        <span class="action-content">
                            <strong>Especialidades</strong>
                            <small>Gestionar especialidades</small>
                        </span>

                        <span class="action-arrow" aria-hidden="true">
                            →
                        </span>
                    </a>


                    <a
                        href="{{ route('appointments.index') }}"
                        class="action"
                    >
                        <span class="action-icon" aria-hidden="true">
                            ◷
                        </span>

                        <span class="action-content">
                            <strong>Citas</strong>
                            <small>Gestionar citas médicas</small>
                        </span>

                        <span class="action-arrow" aria-hidden="true">
                            →
                        </span>
                    </a>


                @elseif(auth()->user()->isMedico())

                    <a
                        href="{{ route('appointments.index') }}"
                        class="action"
                    >
                        <span class="action-icon" aria-hidden="true">
                            ◷
                        </span>

                        <span class="action-content">
                            <strong>Mis citas</strong>
                            <small>Consultar mis citas</small>
                        </span>

                        <span class="action-arrow" aria-hidden="true">
                            →
                        </span>
                    </a>


                    <a
                        href="{{ route('appointments.index', ['estado' => 'confirmada']) }}"
                        class="action"
                    >
                        <span class="action-icon" aria-hidden="true">
                            ✓
                        </span>

                        <span class="action-content">
                            <strong>Próximas citas</strong>
                            <small>Ver citas confirmadas</small>
                        </span>

                        <span class="action-arrow" aria-hidden="true">
                            →
                        </span>
                    </a>


                @elseif(auth()->user()->isPaciente())

                    <a
                        href="{{ route('appointments.index') }}"
                        class="action"
                    >
                        <span class="action-icon" aria-hidden="true">
                            ◷
                        </span>

                        <span class="action-content">
                            <strong>Mis citas</strong>
                            <small>Consultar mis citas</small>
                        </span>

                        <span class="action-arrow" aria-hidden="true">
                            →
                        </span>
                    </a>


                    <a
                        href="{{ route('appointments.create') }}"
                        class="action"
                    >
                        <span class="action-icon" aria-hidden="true">
                            +
                        </span>

                        <span class="action-content">
                            <strong>Nueva cita</strong>
                            <small>Solicitar una cita médica</small>
                        </span>

                        <span class="action-arrow" aria-hidden="true">
                            →
                        </span>
                    </a>

                @endif

            </div>

        </section>

    </div>


    {{-- =====================================================
         ESTADO DE CITAS
         ===================================================== --}}

    <section class="dashboard-section">

        <div class="section-heading">

            <span class="section-eyebrow">
                Estado de citas
            </span>

            <h2 class="section-title">
                Resumen de atención
            </h2>

            <p class="section-description">
                Estado general de las citas registradas.
            </p>

        </div>


        <div class="stats">

            <article class="stat">

                <div class="stat-icon" aria-hidden="true">
                    ✓
                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        Citas confirmadas
                    </span>

                    <strong class="stat-value">
                        {{ $citasConfirmadas }}
                    </strong>

                    <span class="stat-description">
                        Citas listas para atención
                    </span>

                </div>

            </article>


            <article class="stat">

                <div class="stat-icon" aria-hidden="true">
                    ✓
                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        Citas atendidas
                    </span>

                    <strong class="stat-value">
                        {{ $citasAtendidas }}
                    </strong>

                    <span class="stat-description">
                        Consultas finalizadas
                    </span>

                </div>

            </article>


            <article class="stat">

                <div class="stat-icon" aria-hidden="true">
                    !
                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        Citas canceladas
                    </span>

                    <strong class="stat-value">
                        {{ $citasCanceladas }}
                    </strong>

                    <span class="stat-description">
                        Citas que no se realizarán
                    </span>

                </div>

            </article>


            <article class="stat">

                <div class="stat-icon" aria-hidden="true">
                    ◷
                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        Total de citas
                    </span>

                    <strong class="stat-value">
                        {{ $totalCitas }}
                    </strong>

                    <span class="stat-description">
                        Registros en el sistema
                    </span>

                </div>

            </article>

        </div>

    </section>


    {{-- =====================================================
         INFORMACIÓN
         ===================================================== --}}

    <section class="dashboard-footer">

        <div class="footer-icon" aria-hidden="true">
            ✓
        </div>

        <div>

            <strong class="footer-title">
                Sistema de Gestión de Citas de Especialidades Médicas
            </strong>

            <p class="footer-text">
                Información centralizada para facilitar la gestión
                y consulta de las citas médicas.
            </p>

        </div>

    </section>

</div>

@endsection