@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1 class="fw-bold text-primary">Evidencias de Docentes</h1>

            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}" class="text-decoration-none text-secondary">
                            Home
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-primary fw-semibold">
                        Ver mis Materias
                    </li>
                </ol>
            </nav>
        </div>

        <section class="section">

            <div class="row">
                <div class="col-lg-12">

                    <div class="card border-0 shadow-lg materia-card">

                        <div
                            class="card-header materia-header d-flex justify-content-between align-items-center flex-wrap gap-3">

                            <div>
                                <h4 class="mb-1 fw-bold">
                                    Gestión de Materias
                                </h4>

                                <p class="text-muted mb-0">
                                    Visualiza las asignaturas registradas y administra sus evidencias correspondientes.
                                </p>
                            </div>

                            <div class="header-icon">
                                <i class="bi bi-journal-richtext"></i>
                            </div>

                        </div>

                        <div class="card-body p-4">

                            <div class="table-responsive">
                                <table class="table table-hover align-middle text-center materia-table datatable">
                                    <thead>
                                        <tr>
                                            <th>NOMBRE</th>
                                            <th>CARRERA</th>
                                            <th>SEMESTRE</th>
                                            <th>CLAVE</th>
                                            <th>N° UNIDADES</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($materias as $materia)
                                            <tr>
                                                <td class="fw-semibold text-dark">
                                                    {{ $materia->nombre }}
                                                </td>

                                                <td>
                                                    {{ $materia->carrera }}
                                                </td>

                                                <td>
                                                    <span class="badge rounded-pill badge-semestre">
                                                        {{ $materia->semestre }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="badge rounded-pill badge-clave">
                                                        {{ $materia->clave }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="text-muted">
                                                        {{ $materia->unidades }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <a href="{{route('evidencias')}}"
                                                        class="btn btn-primary btn-sm px-4 rounded-pill shadow-sm">
                                                        <i class="bi bi-folder2-open me-2"></i>
                                                        Ver Evidencias
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-muted py-4">
                                                    No tienes materias asignadas en este momento.
                                                </td>
                                            </tr>
                                        @endforelse
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
        .materia-card {
            border-radius: 20px;
            overflow: hidden;
            background: #ffffff;
        }

        .materia-header {
            background: linear-gradient(135deg, #f8fbff, #eef5ff);
            border-bottom: 1px solid #e8eef7;
            padding: 28px;
        }

        .header-icon {
            width: 65px;
            height: 65px;
            border-radius: 18px;
            background: linear-gradient(135deg, #0d6efd, #4da3ff);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
            box-shadow: 0 10px 25px rgba(13, 110, 253, 0.18);
        }

        .materia-table thead th {
            background: #f8fbff;
            border-bottom: 1px solid #e8eef7;
            font-size: 14px;
            font-weight: 700;
            color: #495057;
            padding: 18px;
            white-space: nowrap;
        }

        .materia-table tbody td {
            padding: 20px 14px;
            vertical-align: middle;
        }

        .materia-table tbody tr:hover {
            background: #fcfdff;
        }

        .badge-semestre {
            background: #eaf4ff;
            color: #0d6efd;
            border: 1px solid #d3e7ff;
            padding: 8px 16px;
            font-weight: 600;
        }

        .badge-clave {
            background: #f5f3ff;
            color: #6f42c1;
            border: 1px solid #e4dcff;
            padding: 8px 16px;
            font-weight: 600;
        }

        .badge-unidades {
            background: #ecfff5;
            color: #198754;
            border: 1px solid #d1f7e1;
            padding: 8px 16px;
            font-weight: 600;
        }

        .btn {
            transition: 0.25s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }
    </style>

@endsection
