@extends('layouts.main')

@section('titulo', 'Ver Evidencias')

@section('contenido')
<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="fw-bold text-primary">Detalle de Evidencias</h1>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item"><a href="">Evidencias</a></li>
                <li class="breadcrumb-item active">Ver</li>
            </ol>
        </nav>
    </div>

    <section class="section">

        <div class="card shadow-lg border-0" style="border-radius:18px;">
            <div class="card-header bg-white p-4">
                <h4 class="mb-1 fw-bold">Programación Web</h4>
                <p class="text-muted mb-0">
                    Revisión aprobada • Solo visualización
                </p>
            </div>

            <div class="card-body p-4">

                <div class="row g-4">

                    <div class="col-md-6">
                        <div class="border rounded-4 p-4">

                            <h5 class="fw-bold text-primary mb-4">
                                Documentos
                            </h5>

                            <div class="mb-3">
                                <label>a) Instrumentación didáctica</label>
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-outline-primary w-100">
                                        <i class="bi bi-eye me-2"></i>
                                        Ver PDF
                                    </a>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>b) Lista de calificaciones</label>
                                <a href="#" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-eye me-2"></i>
                                    Ver PDF
                                </a>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="border rounded-4 p-4">

                            <h5 class="fw-bold text-success mb-4">
                                Evidencias
                            </h5>

                            <div class="mb-3">
                                <label>a) Tareas complementarias</label>
                                <a href="#" class="btn btn-outline-success w-100">
                                    <i class="bi bi-eye me-2"></i>
                                    Ver PDF
                                </a>
                            </div>

                            <div class="mb-3">
                                <label>b) Rúbricas</label>
                                <a href="#" class="btn btn-outline-success w-100">
                                    <i class="bi bi-eye me-2"></i>
                                    Ver PDF
                                </a>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="text-center mt-4">
                    <a href="#" class="btn btn-secondary px-4">
                        Regresar
                    </a>
                </div>

            </div>
        </div>

    </section>

</main>
@endsection