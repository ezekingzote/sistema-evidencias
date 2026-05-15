@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

<main id="main" class="main">

    {{-- PAGE TITLE --}}
    <div class="pagetitle mb-4">

        <h1 class="fw-bold text-primary">
            Gestión de Asignaturas
        </h1>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                        Home
                    </a>
                </li>

                <li class="breadcrumb-item">
                    Materias
                </li>

                <li class="breadcrumb-item active text-primary fw-semibold">
                    Nueva Materia
                </li>
            </ol>
        </nav>

    </div>


    <section class="section">

        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="card border-0 shadow-lg materia-card">

                    {{-- HEADER --}}
                    <div class="card-header materia-header">

                        <div class="d-flex align-items-center">

                            <div class="header-icon me-3">
                                <i class="bi bi-book-half"></i>
                            </div>

                            <div>
                                <h4 class="fw-bold mb-1 text-dark">
                                    Detalles de la Nueva Materia
                                </h4>

                                <p class="text-muted mb-0">
                                    Complete todos los campos para registrar una nueva asignatura
                                </p>
                            </div>

                        </div>

                    </div>


                    {{-- BODY --}}
                    <div class="card-body p-4 p-lg-5">

                        <form
                            action="{{ route('materias.store') }}"
                            id="formMateria"
                            method="POST"
                            class="needs-validation"
                        >
                            @csrf

                            <div class="row g-4">

                                {{-- NOMBRE --}}
                                <div class="col-md-6">

                                    <label class="form-label fw-bold" for="nombre">
                                        <i class="bi bi-fonts me-1"></i>
                                        Nombre de la Materia
                                    </label>

                                    <input
                                        oninput="this.value = this.value.toUpperCase();"
                                        name="nombre"
                                        id="nombre"
                                        type="text"
                                        class="form-control custom-input"
                                        placeholder="EJ. ESTRUCTURA DE DATOS"
                                        required
                                    >

                                </div>


                                {{-- CLAVE --}}
                                <div class="col-md-6">

                                    <label class="form-label fw-bold" for="clave">
                                        <i class="bi bi-key me-1"></i>
                                        Clave Materia
                                    </label>

                                    <input
                                        oninput="this.value = this.value.toUpperCase();"
                                        name="clave"
                                        id="clave"
                                        type="text"
                                        class="form-control custom-input"
                                        placeholder="EJ. AED-128"
                                        required
                                    >

                                </div>


                                {{-- UNIDADES --}}
                                <div class="col-md-6">

                                    <label class="form-label fw-bold" for="unidades">
                                        <i class="bi bi-list-check me-1"></i>
                                        Número de Unidades
                                    </label>

                                    <div class="input-group">

                                        <input
                                            name="unidades"
                                            id="unidades"
                                            type="number"
                                            class="form-control custom-input"
                                            min="1"
                                            max="10"
                                            value="1"
                                            required
                                        >

                                        <span class="input-group-text bg-white fw-semibold">
                                            Unid.
                                        </span>

                                    </div>

                                </div>


                                {{-- CARRERA --}}
                                <div class="col-md-6">

                                    <label class="form-label fw-bold" for="carrera">
                                        <i class="bi bi-mortarboard me-1"></i>
                                        Carrera Correspondiente
                                    </label>

                                    <select
                                        id="carrera"
                                        name="carrera"
                                        class="form-select custom-input"
                                        required
                                    >
                                        <option value="" selected disabled>
                                            Seleccione una carrera...
                                        </option>

                                        <option value="INGENIERIA EN SISTEMAS COMPUTACIONALES">
                                            INGENIERIA EN SISTMAS COMPUTACIONALES
                                        </option>

                                        <option value="INGENIERIA INDUSTRIAL">
                                            INGENIERIA INDUSTRIAL
                                        </option>

                                        <option value="INGENIERIA EN GESTION EMPRESARIAL">
                                            INGENIERIA EN GESTION EMPRESARIAL
                                        </option>

                                        <option value="LICENCIATURA EN TURISMO">
                                            LICENCIATURA EN TURISMO
                                        </option>

                                    </select>

                                </div>


                                {{-- ESPECIALIDAD --}}
                                <div class="col-md-6">

                                    <label for="especialidad" class="form-label fw-bold">
                                        <i class="bi bi-patch-check me-1"></i>
                                        ¿Es de especialidad la materia?
                                    </label>

                                    <select
                                        id="especialidad"
                                        name="especialidad"
                                        class="form-select custom-input"
                                        required
                                    >
                                        <option value="" selected disabled>
                                            Seleccione una respuesta
                                        </option>

                                        <option value="SÍ">
                                            Sí
                                        </option>

                                        <option value="NO">
                                            No
                                        </option>

                                    </select>

                                </div>


                                {{-- SEMESTRE --}}
                                <div class="col-md-6">

                                    <label for="semestre" class="form-label fw-bold">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        Semestre de la Asignatura
                                    </label>

                                    <select
                                        id="semestre"
                                        name="semestre"
                                        class="form-select custom-input"
                                        required
                                    >
                                        <option value="" selected disabled>
                                            Seleccione el semestre...
                                        </option>

                                        @for ($i = 1; $i <= 9; $i++)
                                            <option value="{{ $i }}">
                                                {{ $i }}° Semestre
                                            </option>
                                        @endfor

                                    </select>

                                </div>


                                {{-- BOTONES --}}
                                <div class="col-12 mt-5">

                                    <div class="d-flex justify-content-end gap-3">

                                        <a
                                            href="{{ route('materias') }}"
                                            class="btn btn-outline-secondary px-4 rounded-pill"
                                        >
                                            <i class="bi bi-x-circle me-1"></i>
                                            Cancelar
                                        </a>

                                        <button
                                            type="submit"
                                            class="btn btn-primary px-5 rounded-pill shadow-sm fw-bold"
                                        >
                                            <i class="bi bi-plus-circle me-1"></i>
                                            Guardar Materia
                                        </button>

                                    </div>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </div>

    </section>

</main>


<style>
    .materia-card {
        border-radius: 22px;
        overflow: hidden;
        background: #ffffff;
    }

    .materia-header {
        background: linear-gradient(135deg, #f8fbff, #eef5ff);
        border-bottom: 1px solid #e8eef7;
        padding: 30px;
    }

    .header-icon {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: linear-gradient(135deg, #0d6efd, #4da3ff);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 26px;
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.18);
        flex-shrink: 0;
    }

    .custom-input {
        min-height: 50px;
        border-radius: 12px !important;
        border: 1px solid #dee2e6;
        padding-left: 14px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.15);
    }

    .btn {
        transition: 0.25s;
        font-weight: 600;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-primary:hover {
        box-shadow: 0 10px 20px rgba(13, 110, 253, 0.20);
    }

    label {
        color: #495057;
        margin-bottom: 8px;
    }

    .input-group-text {
        border-radius: 12px !important;
    }
</style>

@endsection