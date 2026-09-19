@extends('layouts.app')

@section('title', 'Nuevo médico')

@section('content')

<div class="doctor-form-module">

    {{-- ENCABEZADO --}}
    <div class="doctor-form-header">

        <div>
            <div class="doctor-breadcrumb">
                <a href="{{ route('doctors.index') }}">Médicos</a>
                <span>/</span>
                <span>Nuevo médico</span>
            </div>

            <h1 class="doctor-form-title">
                Registrar médico
            </h1>

            <p class="doctor-form-subtitle">
                Registra la información profesional y de contacto del médico.
            </p>
        </div>

        <a href="{{ route('doctors.index') }}" class="doctor-secondary-btn">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                <path d="M19 12H5"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linecap="round"/>
                <path d="M12 19L5 12L12 5"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>

            Volver
        </a>

    </div>


    {{-- FORMULARIO --}}
    <form
        method="POST"
        action="{{ route('doctors.store') }}"
        class="doctor-form-card"
    >

        @csrf

        {{-- INFORMACIÓN PERSONAL --}}
        <div class="doctor-form-section">

            <div class="doctor-section-title">

                <div class="doctor-section-icon">
                    <svg width="19" height="19"
                         viewBox="0 0 24 24"
                         fill="none">

                        <circle cx="12" cy="8" r="4"
                                stroke="currentColor"
                                stroke-width="1.7"/>

                        <path d="M4 21C4 16.5817 7.58172 13 12 13C16.4183 13 20 16.5817 20 21"
                              stroke="currentColor"
                              stroke-width="1.7"
                              stroke-linecap="round"/>

                    </svg>
                </div>

                <div>
                    <h2>Información personal</h2>
                    <p>Datos básicos del médico.</p>
                </div>

            </div>


            <div class="doctor-fields-grid">

                {{-- NOMBRES --}}
                <div class="doctor-field">

                    <label for="nombres">
                        Nombres
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="nombres"
                        name="nombres"
                        value="{{ old('nombres') }}"
                        placeholder="Ej. Juan Carlos"
                        maxlength="100"
                        required
                    >

                    @error('nombres')
                        <span class="doctor-error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- APELLIDOS --}}
                <div class="doctor-field">

                    <label for="apellidos">
                        Apellidos
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="apellidos"
                        name="apellidos"
                        value="{{ old('apellidos') }}"
                        placeholder="Ej. Pérez Gómez"
                        maxlength="100"
                        required
                    >

                    @error('apellidos')
                        <span class="doctor-error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- IDENTIFICACIÓN --}}
                <div class="doctor-field">

                    <label for="numero_identificacion">
                        Número de identificación
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="numero_identificacion"
                        name="numero_identificacion"
                        value="{{ old('numero_identificacion') }}"
                        placeholder="Ej. 1234567890"
                        maxlength="20"
                        required
                    >

                    @error('numero_identificacion')
                        <span class="doctor-error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- ESPECIALIDAD --}}
                <div class="doctor-field">

                    <label for="specialty_id">
                        Especialidad
                        <span>*</span>
                    </label>

                    <select
                        id="specialty_id"
                        name="specialty_id"
                        required
                    >

                        <option value="">
                            Selecciona una especialidad
                        </option>

                        @foreach($specialties as $specialty)

                            <option
                                value="{{ $specialty->id }}"
                                @selected(old('specialty_id') == $specialty->id)
                            >
                                {{ $specialty->nombre }}
                            </option>

                        @endforeach

                    </select>

                    @error('specialty_id')
                        <span class="doctor-error">{{ $message }}</span>
                    @enderror

                </div>

            </div>

        </div>


        {{-- INFORMACIÓN PROFESIONAL --}}
        <div class="doctor-form-section">

            <div class="doctor-section-title">

                <div class="doctor-section-icon">
                    <svg width="19" height="19"
                         viewBox="0 0 24 24"
                         fill="none">

                        <path d="M4 19.5V5.5C4 4.67157 4.67157 4 5.5 4H18.5C19.3284 4 20 4.67157 20 5.5V19.5"
                              stroke="currentColor"
                              stroke-width="1.7"
                              stroke-linecap="round"/>

                        <path d="M4 19.5C4 18.6716 4.67157 18 5.5 18H20"
                              stroke="currentColor"
                              stroke-width="1.7"
                              stroke-linecap="round"/>

                        <path d="M8 8H16"
                              stroke="currentColor"
                              stroke-width="1.7"
                              stroke-linecap="round"/>

                        <path d="M8 12H16"
                              stroke="currentColor"
                              stroke-width="1.7"
                              stroke-linecap="round"/>

                    </svg>
                </div>

                <div>
                    <h2>Información profesional</h2>
                    <p>Información relacionada con el ejercicio profesional.</p>
                </div>

            </div>


            <div class="doctor-fields-grid">

                {{-- REGISTRO PROFESIONAL --}}
                <div class="doctor-field">

                    <label for="registro_profesional">
                        Registro profesional
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="registro_profesional"
                        name="registro_profesional"
                        value="{{ old('registro_profesional') }}"
                        placeholder="Ej. RM-123456"
                        maxlength="50"
                        required
                    >

                    @error('registro_profesional')
                        <span class="doctor-error">{{ $message }}</span>
                    @enderror

                </div>

            </div>

        </div>


        {{-- INFORMACIÓN DE CONTACTO --}}
        <div class="doctor-form-section">

            <div class="doctor-section-title">

                <div class="doctor-section-icon">
                    <svg width="19" height="19"
                         viewBox="0 0 24 24"
                         fill="none">

                        <path d="M4 5C4 3.89543 4.89543 3 6 3H8.5C9.32843 3 10 3.67157 10 4.5V7.5C10 8.32843 9.32843 9 8.5 9H7.5C8.5 12 11 14.5 14 15.5V14.5C14 13.6716 14.6716 13 15.5 13H18.5C19.3284 13 20 13.6716 20 14.5V18C20 19.1046 19.1046 20 18 20C10.268 20 4 13.732 4 6V5Z"
                              stroke="currentColor"
                              stroke-width="1.7"
                              stroke-linejoin="round"/>

                    </svg>
                </div>

                <div>
                    <h2>Información de contacto</h2>
                    <p>Datos para comunicarse con el médico.</p>
                </div>

            </div>


            <div class="doctor-fields-grid">

                {{-- TELÉFONO --}}
                <div class="doctor-field">

                    <label for="telefono">
                        Teléfono
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="telefono"
                        name="telefono"
                        value="{{ old('telefono') }}"
                        placeholder="Ej. 3001234567"
                        maxlength="20"
                        required
                    >

                    @error('telefono')
                        <span class="doctor-error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- CORREO --}}
                <div class="doctor-field">

                    <label for="correo">
                        Correo electrónico
                        <span>*</span>
                    </label>

                    <input
                        type="email"
                        id="correo"
                        name="correo"
                        value="{{ old('correo') }}"
                        placeholder="ejemplo@correo.com"
                        maxlength="150"
                        required
                    >

                    @error('correo')
                        <span class="doctor-error">{{ $message }}</span>
                    @enderror

                </div>

            </div>

        </div>


        {{-- ACCIONES --}}
        <div class="doctor-form-actions">

            <a
                href="{{ route('doctors.index') }}"
                class="doctor-cancel-btn"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="doctor-save-btn"
            >

                <svg width="17" height="17"
                     viewBox="0 0 24 24"
                     fill="none">

                    <path d="M5 3H17L20 6V21H5V3Z"
                          stroke="currentColor"
                          stroke-width="1.7"
                          stroke-linejoin="round"/>

                    <path d="M8 3V9H16V3"
                          stroke="currentColor"
                          stroke-width="1.7"/>

                    <path d="M8 21V14H16V21"
                          stroke="currentColor"
                          stroke-width="1.7"/>

                </svg>

                Guardar médico

            </button>

        </div>

    </form>

</div>


<style>

.doctor-form-module {
    width: 100%;
}

.doctor-form-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 24px;
}

.doctor-breadcrumb {
    display: flex;
    gap: 7px;
    margin-bottom: 9px;
    font-size: 12px;
    color: #9ca3af;
}

.doctor-breadcrumb a {
    color: #2563eb;
    text-decoration: none;
}

.doctor-form-title {
    margin: 0;
    color: #111827;
    font-size: 25px;
    font-weight: 700;
}

.doctor-form-subtitle {
    margin: 7px 0 0;
    color: #6b7280;
    font-size: 14px;
}

.doctor-secondary-btn,
.doctor-cancel-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    height: 40px;
    padding: 0 15px;
    border: 1px solid #e5e7eb;
    border-radius: 9px;
    background: #fff;
    color: #4b5563;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
}

.doctor-secondary-btn:hover,
.doctor-cancel-btn:hover {
    background: #f9fafb;
}

.doctor-form-card {
    overflow: hidden;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    box-shadow: 0 2px 8px rgba(15,23,42,.035);
}

.doctor-form-section {
    padding: 25px;
    border-bottom: 1px solid #eef0f3;
}

.doctor-section-title {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 23px;
}

.doctor-section-icon {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border-radius: 10px;
    background: #eff6ff;
    color: #2563eb;
}

.doctor-section-title h2 {
    margin: 0;
    color: #111827;
    font-size: 15px;
    font-weight: 650;
}

.doctor-section-title p {
    margin: 4px 0 0;
    color: #9ca3af;
    font-size: 12px;
}

.doctor-fields-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 20px;
}

.doctor-field {
    display: flex;
    flex-direction: column;
}

.doctor-field label {
    margin-bottom: 7px;
    color: #374151;
    font-size: 12px;
    font-weight: 650;
}

.doctor-field label span {
    color: #dc2626;
}

.doctor-field input,
.doctor-field select {
    width: 100%;
    height: 42px;
    box-sizing: border-box;
    padding: 0 12px;
    border: 1px solid #dfe3e8;
    border-radius: 9px;
    outline: none;
    background: #f9fafb;
    color: #111827;
    font-size: 13px;
    transition: .2s ease;
}

.doctor-field input:focus,
.doctor-field select:focus {
    background: #fff;
    border-color: #93c5fd;
    box-shadow: 0 0 0 3px rgba(59,130,246,.10);
}

.doctor-field input::placeholder {
    color: #9ca3af;
}

.doctor-error {
    margin-top: 6px;
    color: #dc2626;
    font-size: 11px;
}

.doctor-form-actions {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 10px;
    padding: 18px 25px;
    background: #fafbfc;
}

.doctor-save-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    height: 40px;
    padding: 0 17px;
    border: 0;
    border-radius: 9px;
    background: #2563eb;
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
}

.doctor-save-btn:hover {
    background: #1d4ed8;
}

@media (max-width: 750px) {

    .doctor-form-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .doctor-secondary-btn {
        width: 100%;
    }

    .doctor-fields-grid {
        grid-template-columns: 1fr;
    }

    .doctor-form-section {
        padding: 20px;
    }

    .doctor-form-actions {
        flex-direction: column-reverse;
    }

    .doctor-save-btn,
    .doctor-cancel-btn {
        width: 100%;
    }
}

</style>

@endsection