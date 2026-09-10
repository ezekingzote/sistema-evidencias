@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

<main id="main" class="main">

    <div class="pagetitle mb-4">
        <div class="d-flex flex-column gap-3">
            <div>
                <h1 class="fw-bold text-primary mb-1">
                    Gestión de Asignaciones
                </h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                                Home
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            Asignaciones
                        </li>
                        <li class="breadcrumb-item active text-primary fw-semibold">
                            Asignar Materias
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex justify-content-between gap-2">
                <a href="{{ route('asignar-materias.create') }}"
                    class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="fa-solid fa-plus me-2"></i>
                    Nueva Asignación
                </a>

                <button type="button" class="btn btn-info text-white rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalManualAsignaciones">
                    <i class="bi bi-question-circle me-1"></i> Ayuda
                </button>
            </div>

        </div>
    </div>

    <section class="section mt-2">

        <div class="card border-0 shadow-lg asignaciones-card">

            {{-- HEADER --}}
            <div class="card-header asignaciones-header">

                <div class="d-flex align-items-center">
                    <div class="header-icon me-3">
                        <i class="bi bi-journal-check"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">
                            Lista de Asignaciones
                        </h4>
                        <p class="text-muted mb-0">
                            Administración de materias asignadas a docentes
                        </p>
                    </div>
                </div>

            </div>

            {{-- BODY --}}
            <div class="card-body p-4">

                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center custom-table datatable">
                        <thead>
                            <tr>
                                <th class="text-center">SEMESTRE</th>
                                <th class="text-center">MATERIA</th>
                                <th class="text-center">DOCENTE</th>
                                <th class="text-center">GRUPO</th>
                                <th class="text-center">N. ALUMNOS</th>
                                <th class="text-center">ACTIVO</th>
                                <th class="text-center">ACCIONES</th>
                            </tr>
                        </thead>

                        <tbody id="tbody_asignaciones">
                            @include('modules.asignar-materias.tbody')
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </section>

</main>

@include('modules.asignar-materias.manual')

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/custom-tables.css') }}">
@endpush

@push('scripts')
    @include('modules.asignar-materias.scripts')
@endpush