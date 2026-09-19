
<aside class="sidebar" id="sidebar">

    {{-- =====================================================
         ENCABEZADO
    ====================================================== --}}

    <div class="sidebar-header">

        <a
            href="{{ route('dashboard') }}"
            class="sidebar-brand"
        >

            <div class="sidebar-brand-icon" aria-hidden="true">
                +
            </div>

            <div class="sidebar-brand-text">

                <span class="sidebar-brand-title">
                    Citas Médicas
                </span>

                <span class="sidebar-brand-subtitle">
                    Gestión de salud
                </span>

            </div>

        </a>

    </div>


    {{-- =====================================================
         NAVEGACIÓN
    ====================================================== --}}

    <nav
        class="sidebar-nav"
        aria-label="Navegación principal"
    >

        {{-- PRINCIPAL --}}

        <div class="sidebar-section">

            <p class="sidebar-section-title">
                Principal
            </p>


            <a
                href="{{ route('dashboard') }}"
                class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
            >

                <span
                    class="sidebar-link-icon"
                    aria-hidden="true"
                >
                    ⌂
                </span>

                <span class="sidebar-link-text">
                    Inicio
                </span>

            </a>

        </div>


        {{-- =================================================
             GESTIÓN
        ================================================== --}}

        <div class="sidebar-section">

            <p class="sidebar-section-title">
                Gestión
            </p>


            {{-- PACIENTES --}}

            @if(auth()->user()->isAdmin())

                <a
                    href="{{ route('patients.index') }}"
                    class="sidebar-link {{ request()->routeIs('patients.*') ? 'active' : '' }}"
                >

                    <span
                        class="sidebar-link-icon"
                        aria-hidden="true"
                    >
                        ♙
                    </span>

                    <span class="sidebar-link-text">
                        Pacientes
                    </span>

                </a>

            @endif


            {{-- MÉDICOS --}}

            @if(auth()->user()->isAdmin())

                <a
                    href="{{ route('doctors.index') }}"
                    class="sidebar-link {{ request()->routeIs('doctors.*') ? 'active' : '' }}"
                >

                    <span
                        class="sidebar-link-icon"
                        aria-hidden="true"
                    >
                        ⚕
                    </span>

                    <span class="sidebar-link-text">
                        Médicos
                    </span>

                </a>

            @endif


            {{-- ESPECIALIDADES --}}

            @if(auth()->user()->isAdmin())

                <a
                    href="{{ route('specialties.index') }}"
                    class="sidebar-link {{ request()->routeIs('specialties.*') ? 'active' : '' }}"
                >

                    <span
                        class="sidebar-link-icon"
                        aria-hidden="true"
                    >
                        ▤
                    </span>

                    <span class="sidebar-link-text">
                        Especialidades
                    </span>

                </a>

            @endif


            {{-- CITAS --}}

            @if(auth()->user()->isAdmin())

                <a
                    href="{{ route('appointments.index') }}"
                    class="sidebar-link {{ request()->routeIs('appointments.index') ? 'active' : '' }}"
                >

                    <span
                        class="sidebar-link-icon"
                        aria-hidden="true"
                    >
                        ◷
                    </span>

                    <span class="sidebar-link-text">
                        Citas
                    </span>

                </a>

            @elseif(auth()->user()->isMedico())

                <a
                    href="{{ route('appointments.index') }}"
                    class="sidebar-link {{ request()->routeIs('appointments.index') ? 'active' : '' }}"
                >

                    <span
                        class="sidebar-link-icon"
                        aria-hidden="true"
                    >
                        ◷
                    </span>

                    <span class="sidebar-link-text">
                        Mis citas
                    </span>

                </a>


                <a
                    href="{{ route('appointments.index', ['estado' => 'confirmada']) }}"
                    class="sidebar-link"
                >

                    <span
                        class="sidebar-link-icon"
                        aria-hidden="true"
                    >
                        ✓
                    </span>

                    <span class="sidebar-link-text">
                        Próximas citas
                    </span>

                </a>

            @elseif(auth()->user()->isPaciente())

                <a
                    href="{{ route('appointments.index') }}"
                    class="sidebar-link {{ request()->routeIs('appointments.index') ? 'active' : '' }}"
                >

                    <span
                        class="sidebar-link-icon"
                        aria-hidden="true"
                    >
                        ◷
                    </span>

                    <span class="sidebar-link-text">
                        Mis citas
                    </span>

                </a>


                <a
                    href="{{ route('appointments.create') }}"
                    class="sidebar-link {{ request()->routeIs('appointments.create') ? 'active' : '' }}"
                >

                    <span
                        class="sidebar-link-icon"
                        aria-hidden="true"
                    >
                        +
                    </span>

                    <span class="sidebar-link-text">
                        Nueva cita
                    </span>

                </a>

            @endif

        </div>

    </nav>


    {{-- =====================================================
         PARTE INFERIOR
    ====================================================== --}}

    <div class="sidebar-footer">


        {{-- PERFIL --}}

        <a
            href="{{ route('profile.edit') }}"
            class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"
        >

            <span
                class="sidebar-link-icon"
                aria-hidden="true"
            >
                ◉
            </span>

            <span class="sidebar-link-text">
                Mi perfil
            </span>

        </a>


        {{-- CERRAR SESIÓN --}}

        <form
            method="POST"
            action="{{ route('logout') }}"
        >

            @csrf

            <button
                type="submit"
                class="sidebar-link sidebar-logout"
            >

                <span
                    class="sidebar-link-icon"
                    aria-hidden="true"
                >
                    ↪
                </span>

                <span class="sidebar-link-text">
                    Cerrar sesión
                </span>

            </button>

        </form>

    </div>

</aside>

