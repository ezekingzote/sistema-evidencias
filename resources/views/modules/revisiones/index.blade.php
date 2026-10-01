@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">

    <div class="pagetitle mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="fw-bold text-primary mb-1">Gestión de Revisiones</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-decoration-none text-secondary">Home</a>
                        </li>
                        <li class="breadcrumb-item active text-primary fw-semibold">
                            Revisiones
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-info text-white rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalManualRevisiones">
                    <i class="bi bi-question-circle me-1"></i> Ayuda
                </button>
            </div>
        </div>
    </div>

    <section class="section">

        <div class="card shadow-sm border-0" style="border-radius: 16px;">
            <div class="card-header bg-white py-4 border-bottom">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-primary-light rounded-3 me-3">
                        <i class="bi bi-journal-check text-primary fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">Control de Revisiones</h4>
                        <p class="text-muted mb-0">
                            Administra el estado de cada revisión académica del semestre activo.
                        </p>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">

                @if(!$semestreActivo)
                <div class="alert alert-warning text-center shadow-sm border-0">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    No hay semestre activo configurado.
                    Debes activar uno para habilitar las revisiones.
                </div>
                @endif

                <div class="row g-4">
                    @include('modules.revisiones.cards')
                </div>

            </div>
        </div>

    </section>

</main>


@include('modules.revisiones.manual')

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/custom-tables.css') }}">
@endpush

@push('scripts')
    @include('modules.revisiones.scripts')
@endpush