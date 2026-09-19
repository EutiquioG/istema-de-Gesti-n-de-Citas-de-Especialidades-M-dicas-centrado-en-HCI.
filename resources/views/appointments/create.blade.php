{{-- =========================================================
     MODAL NUEVA CITA
     resources/views/appointments/create.blade.php
     ========================================================= --}}

<div
    id="modalCreateAppointment"
    class="modal-overlay"
    aria-hidden="true"
>

    <div
        class="modal-container"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modalCreateAppointmentTitle"
    >

        {{-- =====================================================
             HEADER
             ===================================================== --}}

        <div class="modal-header">

            <div>
                <span class="modal-eyebrow">
                    Gestión de citas
                </span>

                <h2
                    id="modalCreateAppointmentTitle"
                    class="modal-title"
                >
                    Nueva cita
                </h2>

                <p class="modal-description">
                    Completa los datos para solicitar una nueva cita médica.
                </p>
            </div>

            <button
                type="button"
                class="modal-close"
                onclick="closeModal('modalCreateAppointment')"
                aria-label="Cerrar"
            >
                &times;
            </button>

        </div>


        {{-- =====================================================
             BODY
             ===================================================== --}}

        <div class="modal-body">

            {{-- Errores de validación --}}

            @if ($errors->any())

                <div class="alert alert-danger">

                    <strong>
                        Revisa la información ingresada.
                    </strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>

                </div>

            @endif


            <form
                action="{{ route('appointments.store') }}"
                method="POST"
                id="createAppointmentForm"
            >

                @csrf


                {{-- =================================================
                     ESPECIALIDAD
                     ================================================= --}}

                <div class="form-group">

                    <label
                        for="create_specialty_id"
                        class="form-label"
                    >
                        Especialidad
                        <span class="required">*</span>
                    </label>

                    <select
                        name="specialty_id"
                        id="create_specialty_id"
                        class="form-control"
                        required
                    >

                        <option value="">
                            Selecciona una especialidad
                        </option>

                        @foreach ($specialties as $specialty)

                            <option
                                value="{{ $specialty->id }}"
                                {{ old('specialty_id') == $specialty->id ? 'selected' : '' }}
                            >
                                {{ $specialty->nombre }}
                            </option>

                        @endforeach

                    </select>

                    @error('specialty_id')

                        <span class="field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                {{-- =================================================
                     MÉDICO
                     ================================================= --}}

                <div class="form-group">

                    <label
                        for="create_doctor_id"
                        class="form-label"
                    >
                        Médico
                        <span class="required">*</span>
                    </label>

                    <select
                        name="doctor_id"
                        id="create_doctor_id"
                        class="form-control"
                        required
                        disabled
                    >

                        <option value="">
                            Primero selecciona una especialidad
                        </option>

                    </select>

                    <small class="form-help">
                        Los médicos disponibles aparecerán después
                        de seleccionar una especialidad.
                    </small>

                    @error('doctor_id')

                        <span class="field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                {{-- =================================================
                     FECHA Y HORA
                     ================================================= --}}

                <div class="form-row">

                    {{-- Fecha --}}

                    <div class="form-group">

                        <label
                            for="create_fecha"
                            class="form-label"
                        >
                            Fecha
                            <span class="required">*</span>
                        </label>

                        <input
                            type="date"
                            name="fecha"
                            id="create_fecha"
                            class="form-control"
                            min="{{ date('Y-m-d') }}"
                            value="{{ old('fecha') }}"
                            required
                        >

                        @error('fecha')

                            <span class="field-error">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>


                    {{-- Hora --}}

                    <div class="form-group">

                        <label
                            for="create_hora"
                            class="form-label"
                        >
                            Hora
                            <span class="required">*</span>
                        </label>

                        <input
                            type="time"
                            name="hora"
                            id="create_hora"
                            class="form-control"
                            value="{{ old('hora') }}"
                            required
                        >

                        @error('hora')

                            <span class="field-error">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>

                </div>


                {{-- =================================================
                     MOTIVO
                     ================================================= --}}

                <div class="form-group">

                    <label
                        for="create_motivo_consulta"
                        class="form-label"
                    >
                        Motivo de consulta
                        <span class="required">*</span>
                    </label>

                    <textarea
                        name="motivo_consulta"
                        id="create_motivo_consulta"
                        class="form-control"
                        rows="4"
                        maxlength="1000"
                        placeholder="Describe brevemente el motivo de la consulta..."
                        required
                    >{{ old('motivo_consulta') }}</textarea>

                    <div class="textarea-counter">
                        <span id="motivoCounter">0</span>/1000
                    </div>

                    @error('motivo_consulta')

                        <span class="field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                {{-- =================================================
                     FOOTER
                     ================================================= --}}

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        onclick="closeModal('modalCreateAppointment')"
                    >
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Registrar cita
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- =========================================================
     ESTILOS DEL MODAL
     ========================================================= --}}

<style>

    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.55);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        z-index: 9999;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .modal-overlay.active {
        display: flex;
        opacity: 1;
    }

    .modal-container {
        width: 100%;
        max-width: 650px;
        max-height: 90vh;
        overflow-y: auto;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.18);
        transform: translateY(-10px);
        transition: transform 0.2s ease;
    }

    .modal-overlay.active .modal-container {
        transform: translateY(0);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        padding: 24px 28px;
        border-bottom: 1px solid #e5e7eb;
    }

    .modal-eyebrow {
        display: block;
        margin-bottom: 5px;
        font-size: 12px;
        font-weight: 600;
        color: #2563eb;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .modal-title {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        color: #111827;
    }

    .modal-description {
        margin: 6px 0 0;
        color: #6b7280;
        font-size: 14px;
        line-height: 1.5;
    }

    .modal-close {
        width: 36px;
        height: 36px;
        border: none;
        border-radius: 8px;
        background: transparent;
        color: #6b7280;
        font-size: 25px;
        line-height: 1;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .modal-close:hover {
        background: #f3f4f6;
        color: #111827;
    }

    .modal-body {
        padding: 28px;
    }

    .form-group {
        margin-bottom: 20px;
        position: relative;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .form-label {
        display: block;
        margin-bottom: 7px;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
    }

    .required {
        color: #dc2626;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
        padding: 11px 13px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #ffffff;
        color: #111827;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s ease,
                    box-shadow 0.2s ease;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
    }

    .form-control:disabled {
        background: #f3f4f6;
        color: #9ca3af;
        cursor: not-allowed;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .form-help {
        display: block;
        margin-top: 6px;
        color: #6b7280;
        font-size: 12px;
        line-height: 1.4;
    }

    .field-error {
        display: block;
        margin-top: 5px;
        color: #dc2626;
        font-size: 12px;
    }

    .textarea-counter {
        margin-top: 5px;
        text-align: right;
        color: #6b7280;
        font-size: 12px;
    }

    .alert {
        padding: 14px 16px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-size: 14px;
    }

    .alert-danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    .alert-danger ul {
        margin: 8px 0 0 18px;
        padding: 0;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding-top: 8px;
        margin-top: 10px;
        border-top: 1px solid #e5e7eb;
    }

    .btn {
        border: none;
        border-radius: 8px;
        padding: 10px 18px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: #2563eb;
        color: #ffffff;
    }

    .btn-primary:hover {
        background: #1d4ed8;
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
    }


    /* =====================================================
       RESPONSIVE
       ===================================================== */

    @media (max-width: 640px) {

        .modal-overlay {
            padding: 10px;
        }

        .modal-container {
            max-height: 95vh;
            border-radius: 12px;
        }

        .modal-header {
            padding: 20px;
        }

        .modal-body {
            padding: 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .modal-footer {
            flex-direction: column-reverse;
        }

        .modal-footer .btn {
            width: 100%;
        }
    }

</style>


{{-- =========================================================
     JAVASCRIPT
     ========================================================= --}}

<script>

    /*
    |--------------------------------------------------------------------------
    | Abrir modal
    |--------------------------------------------------------------------------
    */

    window.openModal = function (modalId) {

        const modal =
            document.getElementById(modalId);

        if (!modal) {
            return;
        }

        modal.classList.add('active');

        modal.setAttribute(
            'aria-hidden',
            'false'
        );

        document.body.style.overflow = 'hidden';
    };


    /*
    |--------------------------------------------------------------------------
    | Cerrar modal
    |--------------------------------------------------------------------------
    */

    window.closeModal = function (modalId) {

        const modal =
            document.getElementById(modalId);

        if (!modal) {
            return;
        }

        modal.classList.remove('active');

        modal.setAttribute(
            'aria-hidden',
            'true'
        );

        document.body.style.overflow = '';
    };


    /*
    |--------------------------------------------------------------------------
    | Cerrar haciendo clic fuera del modal
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        function (event) {

            if (
                event.target.classList.contains(
                    'modal-overlay'
                )
            ) {

                closeModal(
                    event.target.id
                );
            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Cerrar con tecla ESC
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key !== 'Escape') {
                return;
            }

            const activeModal =
                document.querySelector(
                    '.modal-overlay.active'
                );

            if (activeModal) {

                closeModal(
                    activeModal.id
                );
            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Cargar médicos según especialidad
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const specialtySelect =
                document.getElementById(
                    'create_specialty_id'
                );

            const doctorSelect =
                document.getElementById(
                    'create_doctor_id'
                );


            if (
                !specialtySelect ||
                !doctorSelect
            ) {
                return;
            }


            specialtySelect.addEventListener(
                'change',
                async function () {

                    const specialtyId =
                        this.value;


                    doctorSelect.innerHTML = '';

                    doctorSelect.disabled = true;


                    if (!specialtyId) {

                        const option =
                            document.createElement(
                                'option'
                            );

                        option.value = '';

                        option.textContent =
                            'Primero selecciona una especialidad';

                        doctorSelect.appendChild(
                            option
                        );

                        return;
                    }


                    /*
                    |------------------------------------------------------
                    | Estado de carga
                    |------------------------------------------------------
                    */

                    const loadingOption =
                        document.createElement(
                            'option'
                        );

                    loadingOption.value = '';

                    loadingOption.textContent =
                        'Cargando médicos...';

                    doctorSelect.appendChild(
                        loadingOption
                    );


                    try {

                        const response =
                            await fetch(
                                `{{ url('/appointments/doctors') }}/${specialtyId}`,
                                {
                                    method: 'GET',

                                    headers: {
                                        'Accept':
                                            'application/json',

                                        'X-Requested-With':
                                            'XMLHttpRequest'
                                    }
                                }
                            );


                        if (!response.ok) {

                            throw new Error(
                                `Error HTTP ${response.status}`
                            );
                        }


                        const result =
                            await response.json();


                        console.log(
                            'Médicos recibidos:',
                            result
                        );


                        const doctors =
                            Array.isArray(
                                result.data
                            )
                                ? result.data
                                : [];


                        doctorSelect.innerHTML =
                            '';


                        /*
                        |--------------------------------------------------
                        | No hay médicos
                        |--------------------------------------------------
                        */

                        if (
                            doctors.length === 0
                        ) {

                            const option =
                                document.createElement(
                                    'option'
                                );

                            option.value = '';

                            option.textContent =
                                'No hay médicos disponibles para esta especialidad';

                            doctorSelect.appendChild(
                                option
                            );

                            doctorSelect.disabled =
                                true;

                            return;
                        }


                        /*
                        |--------------------------------------------------
                        | Opción inicial
                        |--------------------------------------------------
                        */

                        const defaultOption =
                            document.createElement(
                                'option'
                            );

                        defaultOption.value = '';

                        defaultOption.textContent =
                            'Selecciona un médico';

                        defaultOption.selected =
                            true;

                        doctorSelect.appendChild(
                            defaultOption
                        );


                        /*
                        |--------------------------------------------------
                        | Cargar médicos
                        |--------------------------------------------------
                        */

                        doctors.forEach(
                            function (doctor) {

                                const option =
                                    document.createElement(
                                        'option'
                                    );

                                option.value =
                                    doctor.id;

                                option.textContent =
                                    `${doctor.nombres} ${doctor.apellidos}`;

                                doctorSelect.appendChild(
                                    option
                                );
                            }
                        );


                        doctorSelect.disabled =
                            false;

                    } catch (error) {

                        console.error(
                            'Error al cargar médicos:',
                            error
                        );


                        doctorSelect.innerHTML =
                            '';


                        const option =
                            document.createElement(
                                'option'
                            );

                        option.value = '';

                        option.textContent =
                            'No se pudieron cargar los médicos';

                        doctorSelect.appendChild(
                            option
                        );

                        doctorSelect.disabled =
                            true;
                    }

                }
            );


            /*
            |--------------------------------------------------------------
            | Contador del motivo de consulta
            |--------------------------------------------------------------
            */

            const motivo =
                document.getElementById(
                    'create_motivo_consulta'
                );

            const counter =
                document.getElementById(
                    'motivoCounter'
                );


            if (
                motivo &&
                counter
            ) {

                const updateCounter =
                    function () {

                        counter.textContent =
                            motivo.value.length;
                    };


                motivo.addEventListener(
                    'input',
                    updateCounter
                );


                updateCounter();
            }

        }
    );

</script>