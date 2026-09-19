<x-guest-layout>

    <div class="auth-container">

        {{-- Panel informativo --}}
        <section class="auth-info">

            <div class="auth-brand">

                <div class="auth-brand-icon" aria-hidden="true">
                    +
                </div>

                <div class="auth-brand-text">

                    <span class="auth-brand-title">
                        Citas Médicas
                    </span>

                    <span class="auth-brand-subtitle">
                        Gestión de salud
                    </span>

                </div>

            </div>

            <div class="auth-info-content">

                <div class="auth-medical-icon" aria-hidden="true">
                    ⚕
                </div>

                <h1 class="auth-info-title">
                    Crea tu cuenta
                </h1>

                <p class="auth-info-description">
                    Regístrate para acceder al sistema y gestionar
                    tus citas de especialidades médicas.
                </p>

                <div class="auth-features">

                    <div class="auth-feature">

                        <span
                            class="auth-feature-icon"
                            aria-hidden="true"
                        >
                            ✓
                        </span>

                        <div>

                            <strong>
                                Gestión sencilla
                            </strong>

                            <span>
                                Administra tu información desde un solo lugar.
                            </span>

                        </div>

                    </div>

                    <div class="auth-feature">

                        <span
                            class="auth-feature-icon"
                            aria-hidden="true"
                        >
                            ◷
                        </span>

                        <div>

                            <strong>
                                Consulta tus citas
                            </strong>

                            <span>
                                Revisa tus próximas citas y horarios.
                            </span>

                        </div>

                    </div>

                    <div class="auth-feature">

                        <span
                            class="auth-feature-icon"
                            aria-hidden="true"
                        >
                            ♡
                        </span>

                        <div>

                            <strong>
                                Información segura
                            </strong>

                            <span>
                                Tus datos son tratados de forma responsable.
                            </span>

                        </div>

                    </div>

                </div>

            </div>

            <div class="auth-info-footer">
                Sistema de Gestión de Citas de Especialidades Médicas
            </div>

        </section>


        {{-- Formulario de registro --}}
        <main class="auth-form-panel">

            <div class="auth-form-wrapper">

                {{-- Marca para dispositivos móviles --}}
                <div class="auth-mobile-brand">

                    <div class="auth-brand-icon">
                        +
                    </div>

                    <div class="auth-brand-text">

                        <span class="auth-brand-title">
                            Citas Médicas
                        </span>

                        <span class="auth-brand-subtitle">
                            Gestión de salud
                        </span>

                    </div>

                </div>


                {{-- Encabezado --}}
                <div class="auth-heading">

                    <span class="auth-welcome">
                        REGISTRO
                    </span>

                    <h2>
                        Crear cuenta
                    </h2>

                    <p>
                        Completa tus datos para registrarte en el sistema.
                    </p>

                </div>


                {{-- Formulario --}}
                <form
                    method="POST"
                    action="{{ route('register') }}"
                    class="auth-form"
                >

                    @csrf


                    {{-- Nombre --}}
                    <div class="auth-field">

                        <label
                            for="name"
                            class="auth-label"
                        >
                            Nombre completo
                        </label>

                        <div class="auth-input-wrapper">

                            <span
                                class="auth-input-icon"
                                aria-hidden="true"
                            >
                                ◉
                            </span>

                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                class="auth-input"
                                placeholder="Ingresa tu nombre completo"
                                required
                                autofocus
                                autocomplete="name"
                            >

                        </div>

                        @error('name')

                            <p class="auth-error">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Correo --}}
                    <div class="auth-field">

                        <label
                            for="email"
                            class="auth-label"
                        >
                            Correo electrónico
                        </label>

                        <div class="auth-input-wrapper">

                            <span
                                class="auth-input-icon"
                                aria-hidden="true"
                            >
                                ✉
                            </span>

                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                class="auth-input"
                                placeholder="correo@ejemplo.com"
                                required
                                autocomplete="username"
                            >

                        </div>

                        @error('email')

                            <p class="auth-error">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Contraseña --}}
                    <div class="auth-field">

                        <label
                            for="password"
                            class="auth-label"
                        >
                            Contraseña
                        </label>

                        <div class="auth-input-wrapper">

                            <span
                                class="auth-input-icon"
                                aria-hidden="true"
                            >
                                🔒
                            </span>

                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="auth-input"
                                placeholder="Crea una contraseña"
                                required
                                autocomplete="new-password"
                            >

                        </div>

                        @error('password')

                            <p class="auth-error">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Confirmación --}}
                    <div class="auth-field">

                        <label
                            for="password_confirmation"
                            class="auth-label"
                        >
                            Confirmar contraseña
                        </label>

                        <div class="auth-input-wrapper">

                            <span
                                class="auth-input-icon"
                                aria-hidden="true"
                            >
                                🔒
                            </span>

                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                class="auth-input"
                                placeholder="Repite tu contraseña"
                                required
                                autocomplete="new-password"
                            >

                        </div>

                        @error('password_confirmation')

                            <p class="auth-error">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Botón --}}
                    <button
                        type="submit"
                        class="auth-submit"
                    >

                        <span>
                            Crear cuenta
                        </span>

                        <span
                            class="auth-submit-arrow"
                            aria-hidden="true"
                        >
                            →
                        </span>

                    </button>


                    {{-- Ir al login --}}
                    <div class="auth-register">

                        <span>
                            ¿Ya tienes una cuenta?
                        </span>

                        <a href="{{ route('login') }}">
                            Iniciar sesión
                        </a>

                    </div>

                </form>


                {{-- Seguridad --}}
                <div class="auth-security">

                    <span aria-hidden="true">
                        🔐
                    </span>

                    <span>
                        Tu información está protegida
                    </span>

                </div>

            </div>

        </main>

    </div>

</x-guest-layout>