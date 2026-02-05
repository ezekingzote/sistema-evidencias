@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Semestres</h1>

            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Semestres</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <a href="{{ route('crear-semestre') }}" class="btn btn-outline-primary"><i class="fa-solid fa-plus"></i> Nuevo
                Semestre</a>
            <hr>
            <div class="row g-4">

                @foreach ($semestres as $semestre)
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card shadow-sm h-100 border-start border-primary border-4">
                            <div class="card-body d-flex flex-column p-3">

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0" style="color: #012970; font-weight: 700;">
                                        {{ $semestre->nombre }} {{ $semestre->anio }}
                                    </h5>

                                    <div class="position-relative form-check form-switch">
                                        <input class="form-check-input" type="checkbox" checked>
                                    </div>
                                </div>

                                <p class="text-muted mb-3 small text-uppercase fw-bold"
                                    style="letter-spacing: 1px; font-size: 0.75rem;">
                                    {{ $semestre->carrera }}
                                </p>

                                <ul class="list-unstyled small mb-4">
                                    <li class="mb-2">
                                        <i class="bi bi-journal-text me-2"></i>
                                        <strong>Año:</strong> {{ $semestre->anio }}
                                    </li>

                                    <li class="mb-2">
                                        <i class="bi bi-journal-text me-2"></i>
                                        <strong>Materias:</strong> {{ $semestre->materias_count }}
                                    </li>

                                    <li>
                                        <i class="bi bi-calendar-check me-2"></i>
                                        <strong>Estatus:</strong>
                                        <span class="badge rounded-pill"
                                            style="background-color: #e0f8e9; color: #28a745; font-size: 0.7rem;">
                                            Activo
                                        </span>
                                    </li>
                                </ul>

                                <div class="mt-auto">
                                    <div class="btn-group w-100">
                                        <button type="button"
                                            class="btn btn-outline-primary dropdown-toggle btn-sm d-flex align-items-center justify-content-center"
                                            data-bs-toggle="dropdown" style="border-radius: 6px;">

                                            <i class="bi bi-eye me-2"></i> Detalles
                                        </button>

                                        <ul class="dropdown-menu w-100 text-center shadow-sm">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="#">
                                                    Ver materias
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </section>

    </main>
@endsection
