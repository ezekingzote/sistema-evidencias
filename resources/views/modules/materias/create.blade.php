@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Gestión de Asignaturas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Materias</li>
                <li class="breadcrumb-item active">Nueva Materia</li>
            </ol>
        </nav>
    </div><section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-primary-light me-3">
                                <i class="bi bi-book-half text-primary fs-4"></i>
                            </div>
                            <h5 class="card-title mb-0 p-0">Detalles de la Nueva Materia</h5>
                        </div>
                    </div>

                    <div class="card-body mt-3">
                        <p class="text-muted small mb-4">Complete todos los campos para dar de alta una nueva asignatura en el sistema.</p>

                        <form action="{{ route('materias.store') }}" id="formMateria" method="POST" class="needs-validation">
                            @csrf
                            <div class="row g-4">

                                <div class="col-6">
                                    <label class="form-label fw-bold" for="nombre">
                                        <i class="bi bi-fonts me-1"></i> Nombre de la Materia
                                    </label>
                                    <input oninput="this.value = this.value.toUpperCase();" 
                                           name="nombre" id="nombre" type="text"
                                           class="form-control" 
                                           placeholder="EJ. ESTRUCTURA DE DATOS" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold" for="clave">
                                        <i class="bi bi-key me-1"></i> Clave Materia
                                    </label>
                                    <input oninput="this.value = this.value.toUpperCase();" 
                                           name="clave" id="clave" type="text"
                                           class="form-control" 
                                           placeholder="EJ. AED-128" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold" for="unidades">
                                        <i class="bi bi-list-check me-1"></i> Número de Unidades
                                    </label>
                                    <div class="input-group">
                                        <input name="unidades" id="unidades" type="number" 
                                               class="form-control" min="1" max="10" value="1" required>
                                        <span class="input-group-text">Unid.</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold" for="carrera">
                                        <i class="bi bi-mortarboard me-1"></i> Carrera Correspondiente
                                    </label>
                                    <select id="carrera" name="carrera" class="form-select select-custom" required>
                                        <option value="" selected disabled>Seleccione una carrera...</option>
                                        <option value="INGENIERIA EN SISTEMAS COMPUTACIONALES">INGENIERIA EN SISTEMAS COMPUTACIONALES</option>
                                        <option value="INGENIERIA INDUSTRIAL">INGENIERIA INDUSTRIAL</option>
                                        <option value="INGENIERIA EN GESTION EMPRESARIAL">INGENIERIA EN GESTION EMPRESARIAL</option>
                                        <option value="LICENCIATURA EN TURISMO">LICENCIATURA EN TURISMO</option>
                                    </select>
                                </div>



                                <div class="col-md-6">
                                    <label for="especialidad" class="form-label fw-bold">
                                        <i class="bi bi-calendar3 me-1"></i> ¿ES DE ESPECIALIDAD LA MATERIA?
                                    </label>
                                    <select id="especialidad" name="especialidad" class="form-select" required>
                                        <option value="" selected disabled>Seleccione una respuesta</option>
                                        <option value="SÍ">Sí</option>
                                        <option value="NO">No</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="semestre" class="form-label fw-bold">
                                        <i class="bi bi-calendar3 me-1"></i> Semestre de la Asignatura
                                    </label>
                                    <select id="semestre" name="semestre" class="form-select" required>
                                        <option value="" selected disabled>Seleccione el semestre...</option>
                                        @for ($i = 1; $i <= 9; $i++)
                                            <option value="{{ $i }}">{{ $i }}° Semestre</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-12 mt-5">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('materias') }}" class="btn btn-outline-info border px-4">
                                            <i class="bi bi-x-circle me-2"></i> Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-outline-primary px-5 shadow-sm">
                                            <i class="bi bi-plus-circle me-1"></i> Guardar Materia
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
    /* Decoración extra para un look más moderno */
    .bg-primary-light {
        background-color: #e7f1ff;
        padding: 10px;
        border-radius: 10px;
        display: inline-flex;
    }
    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }
    .card {
        border-radius: 15px;
    }
    .card-header {
        border-top-left-radius: 15px !important;
        border-top-right-radius: 15px !important;
    }
    .btn {
        border-radius: 8px;
        transition: all 0.3s;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }
</style>
@endsection