@extends('layouts.main')

@section('titulo', 'Seguimiento Académico')

@section('contenido')
<main id="main" class="main">

    <div class="pagetitle mb-4">
        <h1>Seguimiento Académico</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('revisiones') }}">Revisiones</a>
                </li>
                <li class="breadcrumb-item active">
                    Seguimiento Académico
                </li>
            </ol>
        </nav>
    </div>

    <section class="section">

        <div class="card shadow-sm border-0" style="border-radius: 16px;">
            <div class="card-header bg-white py-4 border-bottom">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-primary-light rounded-3 me-3">
                        <i class="bi bi-table text-primary fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">Control de Revisiones</h4>
                        <p class="text-muted mb-0">
                            Gestión de revisión, aprobación, rechazo y retroalimentación docente.
                        </p>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">

                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>DOCENTE</th>
                                <th>MATERIA</th>
                                <th>GRUPO</th>
                                <th>REVISIÓN</th>
                                <th>ESTADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td>JUAN PÉREZ</td>
                                <td>PROGRAMACIÓN WEB</td>
                                <td>SIS-6</td>
                                <td>REVISIÓN 1</td>
                                <td>
                                    <span class="badge bg-warning text-dark px-3 py-2">
                                        Pendiente
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-outline-success btn-sm me-1">
                                        <i class="bi bi-check-circle"></i> Aprobar
                                    </button>

                                    <button class="btn btn-outline-danger btn-sm me-1">
                                        <i class="bi bi-x-circle"></i> Rechazar
                                    </button>

                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-chat-left-text"></i> Retroalimentar
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>MARÍA LÓPEZ</td>
                                <td>BASE DE DATOS</td>
                                <td>SIS-5</td>
                                <td>REVISIÓN 2</td>
                                <td>
                                    <span class="badge bg-success px-3 py-2">
                                        Aprobada
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                        Cancelar Aprobación
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>CARLOS RAMÍREZ</td>
                                <td>REDES</td>
                                <td>SIS-7</td>
                                <td>REVISIÓN 3</td>
                                <td>
                                    <span class="badge bg-danger px-3 py-2">
                                        Rechazada
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-chat-left-text"></i> Nueva Retroalimentación
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>ANA TORRES</td>
                                <td>ESTRUCTURA DE DATOS</td>
                                <td>SIS-4</td>
                                <td>REVISIÓN FINAL</td>
                                <td>
                                    <span class="badge bg-info text-dark px-3 py-2">
                                        En revisión
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-outline-success btn-sm me-1">
                                        <i class="bi bi-check-circle"></i> Aprobar
                                    </button>

                                    <button class="btn btn-outline-danger btn-sm me-1">
                                        <i class="bi bi-x-circle"></i> Rechazar
                                    </button>

                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-chat-left-text"></i> Retroalimentar
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="text-end mt-4 border-top pt-4">
                    <a href="{{ route('revisiones') }}"
                       class="btn btn-outline-info px-4 shadow-sm">
                        <i class="bi bi-arrow-left-circle me-2"></i>
                        Regresar
                    </a>
                </div>

            </div>
        </div>

    </section>

</main>

<style>
    .bg-primary-light {
        background-color: rgba(13, 110, 253, 0.10);
    }

    .card {
        border-radius: 16px;
    }

    .table thead th {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn {
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .badge {
        font-size: 0.85rem;
        border-radius: 8px;
    }
</style>
@endsection