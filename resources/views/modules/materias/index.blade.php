@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

<main id="main" class="main">
    <div class="pagetitle mb-4">
        <div class="d-flex flex-column gap-3">

            <div>
                <h1 class="fw-bold text-primary mb-1">
                    Gestión de Materias
                </h1>

                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                                Home
                            </a>
                        </li>
                        <li class="breadcrumb-item active text-primary fw-semibold">
                            Materias
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex justify-content-between gap-2">
                <a href="{{ route('nueva-materia') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="fa-solid fa-plus me-2"></i>
                    Nueva Materia
                </a>

                <button type="button" class="btn btn-info text-white rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalManualMaterias">
                    <i class="bi bi-question-circle me-1"></i> Ayuda
                </button>
            </div>

        </div>
    </div>


    <section class="section mt-2">

        <div class="row">
            <div class="col-lg-12">

                <div class="card border-0 shadow-lg materias-card">

                    {{-- HEADER --}}
                    <div class="card-header materias-header">

                        <div class="d-flex align-items-center">

                            <div class="header-icon me-3">
                                <i class="bi bi-collection-fill"></i>
                            </div>

                            <div>
                                <h4 class="fw-bold mb-1 text-dark">
                                    Lista de Materias
                                </h4>

                                <p class="text-muted mb-0">
                                    Administra las materias registradas dentro del sistema
                                </p>
                            </div>

                        </div>

                    </div>

                    {{-- BODY --}}
                    <div class="card-body p-4">

                        <div class="table-responsive">

                            <table
                                class="table table-hover align-middle text-center datatable custom-table">

                                <thead>
                                    <tr>
                                        <th>NOMBRE</th>
                                        <th>CLAVE</th>
                                        <th>SEMESTRE</th>
                                        <th>CARRERA</th>
                                        <th>UNIDADES</th>
                                        <th>ACTIVO</th>
                                        <th>EDITAR</th>
                                    </tr>
                                </thead>

                                <tbody id="tbody_materias">
                                    @include('modules.materias.tbody')
                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>
        </div>

    </section>

</main>


@include('modules.materias.manual')

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/custom-tables.css') }}">
@endpush

@push('scripts')
    @include('modules.materias.scripts')
@endpush