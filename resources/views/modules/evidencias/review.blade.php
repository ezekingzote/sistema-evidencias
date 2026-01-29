@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Revisar Evidencia</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Revisión de evidencias</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <hr>
        <section class="container-fluid min-vh-100 p-0">
            <div class="card h-100 border-0 rounded-0">

                <!-- Header -->
                <div class="card-header bg-dark text-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold d-flex align-items-center mb-0">
                        <i class="bi bi-search me-2"></i>
                        Dictamen:
                        <span class="fw-normal ms-1">Examen Unidad 1 - Ing. Roldan Aquino</span>
                    </h5>

                    <a href="{{ route('evidencias') }}" class="btn btn-sm btn-outline-light">Volver</a>
                </div>

                <!-- Body -->
                <div class="card-body p-0">
                    <div class="row g-0 min-vh-100">

                        <!-- Evidencia -->
                        <div class="col-lg-7 bg-light border-end d-flex align-items-center justify-content-center">
                            <!-- Visor PDF / Imagen / Evidencia -->
                            <span class="text-muted">Vista previa de la evidencia</span>
                        </div>

                        <!-- Panel derecho -->
                        <div class="col-lg-5 d-flex flex-column">

                            <!-- Datos -->
                            <div class="p-4 bg-white border-bottom">
                                <h6 class="fw-bold text-muted small text-uppercase mb-3">
                                    Datos de la Entrega
                                </h6>

                                <div class="d-flex justify-content-between">
                                    <div class="small">
                                        <p class="mb-1"><strong>Docente:</strong> Ing. Roldan Aquino</p>
                                        <p class="mb-1"><strong>Materia:</strong> Inteligencia Artificial</p>
                                        <p class="mb-0"><strong>Unidad:</strong> U1</p>
                                    </div>

                                </div>
                                <div class="d-flex justify-content-end">
                                    <span class="badge bg-info text-dark">Rúbrica incluida</span>
                                </div>
                            </div>

                            <!-- Instrumentación -->
                            <div class="p-4 flex-grow-1 overflow-auto bg-light">
                                <h6 class="fw-bold text-muted small text-uppercase mb-3">
                                    Instrumentación de la unidad
                                </h6>

                                <div class="list-group list-group-flush border rounded shadow-sm">
                                    <div class="list-group-item p-3">
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold text-primary small">Actividad A</span>
                                            <span class="badge bg-dark">25%</span>
                                        </div>
                                        <p class="small fw-bold mb-1">Entrevista técnica</p>
                                    </div>

                                    <div class="list-group-item p-3">
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold text-primary small">Actividad B</span>
                                            <span class="badge bg-dark">20%</span>
                                        </div>
                                        <p class="small fw-bold mb-1">Tareas y prácticas</p>
                                    </div>

                                    <div class="list-group-item p-3">
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold text-primary small">Actividad C</span>
                                            <span class="badge bg-dark">55%</span>
                                        </div>
                                        <p class="small fw-bold mb-1">Examen</p>
                                    </div>
                                    <div class="list-group-item p-3">
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold text-primary small">Total de ponderación</span>
                                            <span class="badge bg-dark">100%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dictamen -->
                            <div class="p-4 bg-white border-top">
                                <h6 class="fw-bold text-muted small text-uppercase mb-3">
                                    Dictamen de revisión
                                </h6>
                                <textarea class="form-control mb-3" rows="3" placeholder="Observaciones o motivos del rechazo..."></textarea>

                                <div class="d-grid gap-2">
                                    <button class="btn btn-success fw-bold">
                                        <i class="bi bi-check-circle-fill me-2"></i>
                                        Aprobar Evidencia
                                    </button>

                                    <button class="btn btn-danger fw-bold">
                                        <i class="bi bi-arrow-counterclockwise me-2"></i>
                                        Regresar para corrección
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
