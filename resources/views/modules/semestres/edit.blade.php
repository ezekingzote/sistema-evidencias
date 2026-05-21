@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">

    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card border-0 shadow-lg semestre-card mt-4 mb-4">

                <div class="card-header semestre-header">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                        <div>
                            <h2 class="fw-bold text-primary mb-1">
                                Editar Semestre
                            </h2>

                            <p class="text-muted mb-0">
                                Modifica la información del periodo académico registrado
                            </p>
                        </div>

                        <div class="header-icon">
                            <i class="bi bi-pencil-square"></i>
                        </div>

                    </div>

                    <nav class="mt-3">
                        <ol class="breadcrumb mb-0">

                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}"
                                   class="text-decoration-none text-secondary">
                                    Home
                                </a>
                            </li>

                            <li class="breadcrumb-item">
                                <a href="{{ route('semestres') }}"
                                   class="text-decoration-none text-secondary">
                                    Semestres
                                </a>
                            </li>

                            <li class="breadcrumb-item active text-primary fw-semibold">
                                Editar
                            </li>

                        </ol>
                    </nav>

                </div>

                <div class="card-body p-4 p-lg-5">

                    <section class="section">

                        <form
                            action="{{ route('semestres.update', $item->id) }}"
                            method="POST"
                            id="formSemestreEdit">

                            @csrf
                            @method('PUT')

                            <div class="row g-4">

                                {{-- NOMBRE --}}
                                <div class="col-md-8">

                                    <label class="form-label fw-bold">
                                        Nombre del Semestre
                                    </label>

                                    <div class="input-group custom-input">

                                        <span class="input-group-text bg-white">
                                            <i class="bi bi-journal-bookmark-fill text-primary"></i>
                                        </span>

                                        <input
                                            type="text"
                                            name="nombre"
                                            id="nombre"
                                            class="form-control bg-light"
                                            readonly
                                            value="{{ $item->nombre }}">

                                    </div>

                                </div>

                                {{-- AÑO --}}
                                <div class="col-md-4">

                                    <label class="form-label fw-bold">
                                        Año
                                    </label>

                                    <div class="input-group custom-input">

                                        <span class="input-group-text bg-white">
                                            <i class="bi bi-calendar-event-fill text-primary"></i>
                                        </span>

                                        <input
                                            type="number"
                                            name="anio"
                                            id="anio_manual"
                                            class="form-control"
                                            value="{{ $item->anio }}"
                                            min="{{ date('Y') }}"
                                            max="{{ date('Y') + 5 }}">

                                    </div>

                                </div>

                                {{-- PERIODO --}}
                                <div class="col-md-12">

                                    <label class="form-label fw-bold">
                                        Periodo
                                    </label>

                                    <select
                                        name="periodo"
                                        id="periodo_select"
                                        class="form-select custom-select"
                                        required>

                                        <option value="" disabled>
                                            Seleccione el periodo...
                                        </option>

                                        <option
                                            value="1"
                                            {{ $item->periodo == 1 ? 'selected' : '' }}>
                                            1 (ENERO - JUNIO)
                                        </option>

                                        <option
                                            value="2"
                                            {{ $item->periodo == 2 ? 'selected' : '' }}>
                                            2 (JULIO - DICIEMBRE)
                                        </option>

                                    </select>

                                </div>

                                {{-- FECHA INICIO --}}
                                <div class="col-md-6">

                                    <label class="form-label fw-bold">
                                        Fecha Inicio
                                    </label>

                                    <input
                                        type="date"
                                        name="fecha_inicio"
                                        id="fecha_inicio"
                                        class="form-control custom-date"
                                        required
                                        value="{{ \Carbon\Carbon::parse($item->fecha_inicio)->format('Y-m-d') }}">

                                </div>

                                {{-- FECHA FIN --}}
                                <div class="col-md-6">

                                    <label class="form-label fw-bold">
                                        Fecha Fin
                                    </label>

                                    <input
                                        type="date"
                                        name="fecha_fin"
                                        id="fecha_fin"
                                        class="form-control custom-date"
                                        required
                                        value="{{ \Carbon\Carbon::parse($item->fecha_fin)->format('Y-m-d') }}">

                                </div>

                                {{-- BOTONES --}}
                                <div class="col-12 mt-4 text-center">

                                    <a
                                        href="{{ route('semestres') }}"
                                        class="btn btn-outline-secondary px-4 rounded-pill me-2">

                                        <i class="bi bi-x-circle me-2"></i>
                                        Cancelar

                                    </a>

                                    <button
                                        type="submit"
                                        class="btn btn-primary px-5 rounded-pill shadow-sm">

                                        <i class="fa-solid fa-floppy-disk me-2"></i>
                                        Guardar Cambios

                                    </button>

                                </div>

                            </div>

                        </form>

                    </section>

                </div>

            </div>

        </div>
    </div>

</main>

<style>

    .semestre-card {
        border-radius: 22px;
        overflow: hidden;
        background: #ffffff;
    }

    .semestre-header {
        background: linear-gradient(135deg, #f8fbff, #eef5ff);
        border-bottom: 1px solid #e8eef7;
        padding: 30px;
    }

    .header-icon {
        width: 68px;
        height: 68px;
        border-radius: 18px;
        background: linear-gradient(135deg, #0d6efd, #4da3ff);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 28px;
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.18);
    }

    .custom-input .input-group-text,
    .custom-input .form-control,
    .custom-select,
    .custom-date {
        min-height: 50px;
        border-radius: 12px !important;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.15);
    }

    .custom-select {
        border: 1px solid #dee2e6;
    }

    .custom-date {
        padding-left: 15px;
    }

    .btn {
        transition: 0.25s;
        font-weight: 600;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    label {
        color: #495057;
        margin-bottom: 8px;
    }

</style>

<script>

    function actualizarRestricciones() {

        const anio = document.getElementById('anio_manual').value;
        const periodo = document.getElementById('periodo_select').value;

        const fechaInicio = document.getElementById('fecha_inicio');
        const fechaFin = document.getElementById('fecha_fin');

        let texto = '';

        if (periodo == '1') {

            texto = 'ENERO - JUNIO ' + anio;

            fechaInicio.min = `${anio}-01-01`;
            fechaInicio.max = `${anio}-01-31`;

            fechaFin.min = `${anio}-06-01`;
            fechaFin.max = `${anio}-06-30`;
        }

        if (periodo == '2') {

            texto = 'JULIO - DICIEMBRE ' + anio;

            fechaInicio.min = `${anio}-07-01`;
            fechaInicio.max = `${anio}-07-31`;

            fechaFin.min = `${anio}-12-01`;
            fechaFin.max = `${anio}-12-31`;
        }

        document.getElementById('nombre').value = texto;
    }

    function actualizarFechasAutomaticamente() {

        const anio = document.getElementById('anio_manual').value;
        const periodo = document.getElementById('periodo_select').value;

        const fechaInicio = document.getElementById('fecha_inicio');
        const fechaFin = document.getElementById('fecha_fin');

        if (periodo == '1') {

            fechaInicio.value = `${anio}-01-01`;
            fechaFin.value = `${anio}-06-30`;
        }

        if (periodo == '2') {

            fechaInicio.value = `${anio}-07-01`;
            fechaFin.value = `${anio}-12-31`;
        }
    }

    document
        .getElementById('periodo_select')
        .addEventListener('change', () => {

            actualizarRestricciones();
            actualizarFechasAutomaticamente();
        });

    document
        .getElementById('anio_manual')
        .addEventListener('input', () => {

            const anioActual = new Date().getFullYear();
            const inputAnio = document.getElementById('anio_manual');

            if (parseInt(inputAnio.value) < anioActual) {
                inputAnio.value = anioActual;
            }

            actualizarRestricciones();
            actualizarFechasAutomaticamente();
        });

    window.addEventListener('load', () => {

        const anioActual = new Date().getFullYear();

        document.getElementById('anio_manual').min = anioActual;

        actualizarRestricciones();
    });

</script>

@endsection