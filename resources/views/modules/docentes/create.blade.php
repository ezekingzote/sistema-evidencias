@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Crear Nuevo Docente</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Registrar un docente nuevo</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->


        <nav>

        </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <form id="formDocente">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold" for="nombre">Nombre(s) del Docente</label>
                        <input type="text" id="nombre" name="nombre" class="form-control"
                            placeholder="Nombre del docente" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold" for="apellido1">Apellido Paterno del docente</label>
                        <input type="text" id="apellido1" name="apellido1" class="form-control"
                            placeholder="Apellido Paterno del docente" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold" for="apellido2">Apellido Materno del docente</label>
                        <input type="text" name="apellido2" id="apellido2" class="form-control"
                            placeholder="Apellido Materno del docente">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">RFC</label>
                        <input type="text" class="form-control" placeholder="RFC" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Carrera</label>
                        <select class="form-select" required>
                            <option selected disabled>Seleccione...</option>
                            <option>Ingeniería en Sistemas</option>
                            <option>Ingeniería Industrial</option>
                            <option>Turismo</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <a href="{{ route('docentes') }}" class="btn btn-outline-info"><i
                                class="fa-solid fa-arrow-left-long"></i>Regresar</a>
                        <button type="submit" class="btn btn-outline-primary px-4">Guardar</button>
                    </div>
                </div>
            </form>
        </section>
    </main>
@endsection
