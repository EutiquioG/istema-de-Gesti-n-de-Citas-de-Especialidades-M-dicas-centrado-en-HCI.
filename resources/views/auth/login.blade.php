<x-guest-layout>

    <div class="auth-container">

        {{-- ==========================================
             PANEL INFORMATIVO
        =========================================== --}}
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
                    Gestión de citas médicas
                </h1>

                <p class="auth-info-description">
                    Administra tus citas de especialidades médicas
                    de manera sencilla, rápida y segura.
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
                                Atención organizada
                            </strong>

                            <span>
                                Gestiona tus citas en un solo lugar.
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
                                Consulta tus horarios
                            </strong>

                            <span>
                                Visualiza fácilmente tus próximas citas.
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


        {{-- ==========================================
             PANEL DE LOGIN
        =========================================== --}}
        <main class="auth-form-panel">

            <div class="auth-form-wrapper">


                {{-- Marca para móvil --}}
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
                        BIENVENIDO
                    </span>

                    <h2>
                        Iniciar sesión
                    </h2>

                    <p>
                        Ingresa tus datos para acceder al sistema.
                    </p>

                </div>


                {{-- Estado de sesión --}}
                <x-auth-session-status
                    class="auth-status"
                    :status="session('status')"
                />


                {{-- Formulario --}}
                <form
                    method="POST"
                    action="{{ route('login') }}"
                    class="auth-form"
                >

                    @csrf


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
                                autofocus
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

                        <div class="auth-label-row">

                            <label
                                for="password"
                                class="auth-label"
                            >
                                Contraseña
                            </label>


                            @if (Route::has('password.request'))

                                <a
                                    href="{{ route('password.request') }}"
                                    class="auth-forgot"
                                >
                                    ¿Olvidaste tu contraseña?
                                </a>

                            @endif

                        </div>


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
                                placeholder="Ingresa tu contraseña"
                                required
                                autocomplete="current-password"
                            >

                        </div>

                        @error('password')

                            <p class="auth-error">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Recordarme --}}
                    <label class="auth-checkbox">

                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                        >

                        <span>
                            Recordarme en este dispositivo
                        </span>

                    </label>


                    {{-- Botón --}}
                    <button
                        type="submit"
                        class="auth-submit"
                    >

                        <span>
                            Iniciar sesión
                        </span>

                        <span
                            class="auth-submit-arrow"
                            aria-hidden="true"
                        >
                            →
                        </span>

                    </button>


                    {{-- Registro --}}
                    @if (Route::has('register'))

                        <div class="auth-register">

                            <span>
                                ¿No tienes una cuenta?
                            </span>

                            <a href="{{ route('register') }}">
                                Crear cuenta
                            </a>

                        </div>

                    @endif

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