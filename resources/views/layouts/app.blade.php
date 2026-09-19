
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'Sistema de Citas Médicas')
    </title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')
</head>

<body class="app-body">

    <div class="app-container">

        {{-- Barra lateral --}}
        @include('components.sidebar')

        <div class="main-container">

            {{-- Barra superior --}}
            @include('components.navbar')

            <main class="main-content">

                {{-- Mensaje de éxito --}}
                @if(session('success'))
                    <div
                        class="alert alert-success"
                        role="alert"
                        aria-live="polite"
                    >
                        <span
                            class="alert-icon"
                            aria-hidden="true"
                        >
                            ✓
                        </span>

                        <div>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                {{-- Mensaje de error --}}
                @if(session('error'))
                    <div
                        class="alert alert-error"
                        role="alert"
                        aria-live="assertive"
                    >
                        <span
                            class="alert-icon"
                            aria-hidden="true"
                        >
                            !
                        </span>

                        <div>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                {{-- Errores de validación --}}
                @if($errors->any())
                    <div
                        class="alert alert-error"
                        role="alert"
                        aria-live="assertive"
                    >
                        <span
                            class="alert-icon"
                            aria-hidden="true"
                        >
                            !
                        </span>

                        <div>
                            <strong>
                                Revisa la información ingresada.
                            </strong>

                            <ul class="alert-list">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- Contenido principal --}}
                @yield('content')

            </main>

        </div>

    </div>

    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')

</body>
</html>

