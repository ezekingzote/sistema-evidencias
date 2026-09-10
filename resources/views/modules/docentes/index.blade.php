@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

    <main id="main" class="main">

        <div class="pagetitle mb-4">
            <div class="d-flex flex-column gap-3">
                <div>
                    <h1 class="fw-bold text-primary mb-1">
                        Gestión de Docentes
                    </h1>

                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                                    Home
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-primary fw-semibold">
                                Docentes
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex justify-content-between gap-2">
                    <a href="{{ route('nuevo-docente') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="fa-solid fa-user-plus me-2"></i>
                        Nuevo Docente
                    </a>

                    <button type="button" class="btn btn-info text-white rounded-pill px-4 shadow-sm"
                        data-bs-toggle="modal" data-bs-target="#modalManualDocentes">
                        <i class="bi bi-question-circle me-1"></i> Ayuda
                    </button>
                </div>

            </div>
        </div>

        <section class="section">

            <div class="row">
                <div class="col-lg-12">

                    <div class="card border-0 shadow-lg docentes-card">

                        {{-- HEADER --}}
                        <div class="card-header docentes-header">

                            <div class="d-flex align-items-center">

                                <div class="header-icon me-3">
                                    <i class="bi bi-people-fill"></i>
                                </div>

                                <div>
                                    <h4 class="fw-bold mb-1 text-dark">
                                        Lista de Docentes
                                    </h4>

                                    <p class="text-muted mb-0">
                                        Administra usuarios docentes, accesos y estado del sistema
                                    </p>
                                </div>

                            </div>

                        </div>

                        {{-- BODY --}}
                        <div class="card-body p-4">

                            <div class="table-responsive">

                                <table id="tablaDocentes" class="table table-hover align-middle text-center custom-table">

                                    <thead>
                                        <tr>
                                            <th class="text-center">NOMBRE</th>
                                            <th class="text-center">CORREO</th>
                                            <th class="text-center">CELULAR</th>
                                            <th class="text-center">DEPARTAMENTO</th>
                                            <th class="text-center">ROL</th>
                                            <th class="text-center">CARGO</th>
                                            <th class="text-center">CAMBIAR PASSWORD</th>
                                            <th class="text-center">ACTIVO</th>
                                            <th class="text-center">EDITAR</th>
                                        </tr>
                                    </thead>

                                    <tbody></tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>
            </div>

        </section>

    </main>

    {{-- Incluimos el archivo del Modal del Manual de Docentes --}}
    @include('modules.docentes.manual')

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/custom-tables.css') }}">
@endpush

@push('scripts')
    @include('modules.docentes.scripts')
@endpush
