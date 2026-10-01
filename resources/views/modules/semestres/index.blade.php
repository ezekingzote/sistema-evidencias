@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between align-items-center">
            <div>
                <h1>Semestres</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Semestres</li>
                    </ol>
                </nav>
            </div>
            
            <button type="button" class="btn btn-info text-white shadow-sm" data-bs-toggle="modal" data-bs-target="#modalManualSemestres">
                <i class="bi bi-question-circle me-1"></i> Ayuda
            </button>
        </div>

        <section class="section mt-3">
            <a href="{{ route('semestre.create') }}" class="btn btn-outline-primary mb-3">
                <i class="fa-solid fa-plus"></i> Nuevo Semestre
            </a>

            <div class="card">
                <div class="card-body">
                    <div class="row g-4" id="contenedor-semestres">
                        @include('modules.semestres.cards')
                    </div>
                </div>
            </div>
        </section>
        @include('modules.semestres.manual')

    </main>
@endsection

@push('scripts')
    @include('components.scripts.toggle-status')
@endpush