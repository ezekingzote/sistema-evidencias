@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="fw-bold text-primary">Gestión de Evidencias</h1>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="" class="text-decoration-none text-secondary">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item active text-primary fw-semibold">
                    Evidencias
                </li>
            </ol>
        </nav>
    </div>

    <section class="section">

        <div class="row">
            <div class="col-lg-12">

                <div class="card border-0 shadow-lg evidencia-card">

                    <div class="card-header evidencia-header d-flex justify-content-between align-items-center flex-wrap gap-3">

                        <div>
                            <h4 class="mb-1 fw-bold">
                                Evidencias Registradas
                            </h4>

                            <p class="text-muted mb-0">
                                Visualiza el avance de revisiones por asignatura y el estado de cada evidencia.
                            </p>
                        </div>

                        <a href="{{ route('evidencias.create') }}"
                           class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">

                            <i class="bi bi-plus-circle me-2"></i>
                            Nueva Evidencia
                        </a>

                    </div>

                    <div class="card-body p-4">

                        {{-- LEYENDA DE ESTADOS --}}
                        <div class="mb-4">

                            <div class="legend-box">

                                <div class="legend-item">
                                    <span class="status approved">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </span>
                                    <small>Aprobada (Solo ver)</small>
                                </div>

                                <div class="legend-item">
                                    <span class="status pending">
                                        <i class="bi bi-clock-fill"></i>
                                    </span>
                                    <small>Pendiente (Editar)</small>
                                </div>

                                <div class="legend-item">
                                    <span class="status rejected">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </span>
                                    <small>Rechazada (Editar)</small>
                                </div>

                                <div class="legend-item">
                                    <span class="status empty">
                                        <i class="bi bi-dash-circle-fill"></i>
                                    </span>
                                    <small>Sin asignar</small>
                                </div>

                            </div>

                        </div>

                        {{-- TABLA --}}
                        <div class="table-responsive">

                            <table class="table table-hover align-middle">

                                <thead>
                                    <tr>
                                        <th class="text-center">Asignatura</th>
                                        <th class="text-center">Docente</th>
                                        <th class="text-center">Revisión 1</th>
                                        <th class="text-center">Revisión 2</th>
                                        <th class="text-center">Revisión 3</th>
                                        <th class="text-center">Revisión 4</th>
                                        <th class="text-center">Avance</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    {{-- FILA 1 --}}
                                    <tr>

                                        <td class="fw-semibold">
                                            Programación Web
                                        </td>

                                        <td>
                                            Dr. Juan Pérez
                                        </td>

                                        {{-- APROBADA -> SHOW --}}
                                        <td class="text-center">
                                            <a href="{{ route('evidencias.show', 1) }}"
                                               class="status approved"
                                               title="Ver evidencia aprobada">

                                                <i class="bi bi-check-circle-fill"></i>
                                            </a>
                                        </td>

                                        {{-- APROBADA -> SHOW --}}
                                        <td class="text-center">
                                            <a href="{{ route('evidencias.show', 1) }}"
                                               class="status approved"
                                               title="Ver evidencia aprobada">

                                                <i class="bi bi-check-circle-fill"></i>
                                            </a>
                                        </td>

                                        {{-- PENDIENTE -> EDIT --}}
                                        <td class="text-center">
                                            <a href="{{ route('evidencias.edit', 1) }}"
                                               class="status pending"
                                               title="Editar evidencia pendiente">

                                                <i class="bi bi-clock-fill"></i>
                                            </a>
                                        </td>

                                        {{-- SIN ASIGNAR --}}
                                        <td class="text-center">
                                            <span class="status empty"
                                                  title="Sin asignar">

                                                <i class="bi bi-dash-circle-fill"></i>
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <div class="progress progress-custom">
                                                <div class="progress-bar bg-warning"
                                                     style="width: 50%">
                                                    50%
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-center">

                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm rounded-circle"
                                                        data-bs-toggle="dropdown">

                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>

                                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow">

                                                    <li>
                                                        <a class="dropdown-item"
                                                           href="{{ route('evidencias.show', 1) }}">

                                                            <i class="bi bi-eye me-2 text-primary"></i>
                                                            Ver detalle
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="bi bi-download me-2 text-success"></i>
                                                            Descargar ZIP
                                                        </a>
                                                    </li>

                                                    <li><hr class="dropdown-divider"></li>

                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#">
                                                            <i class="bi bi-trash me-2"></i>
                                                            Eliminar
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>

                                        </td>

                                    </tr>


                                    {{-- FILA 2 --}}
                                    <tr>

                                        <td class="fw-semibold">
                                            Base de Datos
                                        </td>

                                        <td>
                                            Mtra. Laura Sánchez
                                        </td>

                                        {{-- APROBADA --}}
                                        <td class="text-center">
                                            <a href="{{ route('evidencias.show', 2) }}"
                                               class="status approved">

                                                <i class="bi bi-check-circle-fill"></i>
                                            </a>
                                        </td>

                                        {{-- RECHAZADA --}}
                                        <td class="text-center">
                                            <a href="{{ route('evidencias.edit', 2) }}"
                                               class="status rejected">

                                                <i class="bi bi-x-circle-fill"></i>
                                            </a>
                                        </td>

                                        {{-- PENDIENTE --}}
                                        <td class="text-center">
                                            <a href="{{ route('evidencias.edit', 2) }}"
                                               class="status pending">

                                                <i class="bi bi-clock-fill"></i>
                                            </a>
                                        </td>

                                        {{-- SIN ASIGNAR --}}
                                        <td class="text-center">
                                            <span class="status empty">
                                                <i class="bi bi-dash-circle-fill"></i>
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <div class="progress progress-custom">
                                                <div class="progress-bar bg-danger text-dark"
                                                     style="width: 25%">
                                                    25%
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-center">

                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm rounded-circle"
                                                        data-bs-toggle="dropdown">

                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>

                                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow">

                                                    <li>
                                                        <a class="dropdown-item"
                                                           href="{{ route('evidencias.edit', 2) }}">

                                                            <i class="bi bi-pencil-square me-2 text-warning"></i>
                                                            Editar
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item text-danger"
                                                           href="#">

                                                            <i class="bi bi-trash me-2"></i>
                                                            Eliminar
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>

                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>
        </div>

    </section>

</main>


<style>
    .evidencia-card {
        border-radius: 18px;
        overflow: hidden;
        background: #ffffff;
    }

    .evidencia-header {
        background: linear-gradient(135deg, #f8fbff, #eef5ff);
        border-bottom: 1px solid #e8eef7;
        padding: 25px;
    }

    .legend-box {
        display: flex;
        gap: 25px;
        flex-wrap: wrap;
        background: #f8fbff;
        padding: 18px;
        border-radius: 14px;
        border: 1px solid #e8eef7;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .status {
        font-size: 24px;
        text-decoration: none;
        transition: 0.2s;
    }

    .status:hover {
        transform: scale(1.15);
    }

    .approved {
        color: #198754;
    }

    .pending {
        color: #f39c12;
    }

    .rejected {
        color: #dc3545;
    }

    .empty {
        color: #adb5bd;
        cursor: default;
    }

    table thead th {
        background: #f8fbff;
        border-bottom: 1px solid #e8eef7;
        font-size: 14px;
        font-weight: 700;
        color: #495057;
        padding: 16px;
    }

    table tbody td {
        padding: 18px 12px;
        vertical-align: middle;
    }

    .progress-custom {
        height: 28px;
        border-radius: 30px;
        background: #edf2f7;
        min-width: 150px;
    }

    .progress-bar {
        font-weight: 600;
        border-radius: 30px;
    }
</style>

@endsection