@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Crear Nueva Materia</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Registrar una nueva materia</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->


        <nav>

        </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <form id="formMateria">
                <div class="row g-3">

                    <div class="col-12">
                        <label class="form-label fw-bold">Nombre de la Materia</label>
                        <input type="text" class="form-control" placeholder="Ej. Estructura de Datos" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Clave Materia</label>
                        <input type="text" class="form-control" placeholder="AED-128" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Número de Unidades</label>
                        <input type="number" class="form-control" min="1" max="10" value="1" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Carrera correspondiente</label>
                        <select class="form-select" required>
                            <option selected disabled>Seleccione...</option>
                            <option>Ingeniería en Sistemas</option>
                            <option>Ingeniería Industrial</option>
                            <option>Turismo</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <a href="{{ route('materias') }}" class="btn btn-outline-info"><i
                                class="fa-solid fa-arrow-left-long"></i>Regresar</a>
                        <button type="submit" class="btn btn-outline-dark px-4">
                            Crear Materia
                        </button>
                    </div>

                </div>
            </form>
        </section>

    </main>
@endsection
