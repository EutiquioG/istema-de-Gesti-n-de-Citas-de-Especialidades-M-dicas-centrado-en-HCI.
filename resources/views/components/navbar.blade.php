
@auth

<header class="topbar">

    {{-- Botón para menú móvil --}}
    <button
        type="button"
        class="sidebar-toggle"
        id="sidebarToggle"
        aria-label="Abrir menú principal"
        aria-controls="sidebar"
        aria-expanded="false"
    >
        <span></span>
        <span></span>
        <span></span>
    </button>


    {{-- Información de la sección --}}
    <div class="topbar-content">

        <div class="topbar-title">
            <span class="topbar-title-main">
                Sistema de Citas Médicas
            </span>

            <span class="topbar-title-subtitle">
                Gestión de citas de especialidades médicas
            </span>
        </div>

    </div>


    {{-- Usuario autenticado --}}
    <div class="user-menu">

        <div
            class="user-avatar"
            aria-hidden="true"
        >
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>

        <div class="user-info">

            <span class="user-name">
                {{ auth()->user()->name }}
            </span>

            <span class="user-role">

                @switch(auth()->user()->role)

                    @case('admin')
                        Administrador
                        @break

                    @case('medico')
                        Médico
                        @break

                    @case('paciente')
                        Paciente
                        @break

                    @default
                        Usuario

                @endswitch

            </span>

        </div>

    </div>

</header>

@endauth

