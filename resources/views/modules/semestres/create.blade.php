@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">
        <div class="card mt-4 mb-4">
            <div class="card-body">
                <div class="pagetitle">
                    <h1>Crear Nuevo semestre</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Registrar nuevo semestre</li>
                        </ol>
                    </nav>
                </div>

                <section class="section">
                    <form action="{{ route('semestre.store') }}" id="formSemestre" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Nombre del Semestre</label>
                                <input name="nombre" id="nombre" type="text" class="form-control bg-light" readonly>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Año</label>
                                <input type="number" id="anio_manual" name="anio" class="form-control"
                                    value="{{ date('Y') }}" min="{{ date('Y') - 1 }}" max="{{ date('Y') + 5 }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">Periodo</label>
                                <select id="periodo_select" name="periodo" class="form-select" required>
                                    <option value="" selected disabled>Seleccione el periodo...</option>
                                    <option value="1">1 (ENERO - JUNIO)</option>
                                    <option value="2">2 (JULIO - DICIEMBRE)</option>
                                </select>
                                <small id="error_duplicado" class="text-danger" style="display:none;">Este periodo ya está
                                    registrado para este año.</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Fecha Inicio</label>
                                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required
                                    disabled>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Fecha Fin</label>
                                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required
                                    disabled>
                            </div>

                            <div class="col-12 mt-4 text-center">
                                <a href="{{ route('semestres') }}" class="btn btn-outline-info">
                                    Regresar
                                </a>
                                <button type="submit" id="btnGuardar" class="btn btn-dark px-5">Registrar Semestre</button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
        </section>

    </main>
@endsection
