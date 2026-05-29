@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="fw-bold text-primary">
            Reportes de Evaluación
        </h1>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="" class="text-decoration-none text-secondary">
                        Home
                    </a>
                </li>

                <li class="breadcrumb-item active text-primary fw-semibold">
                    Reportes
                </li>
            </ol>
        </nav>
    </div>

    <section class="section">

        <div class="row">

            <div class="col-lg-12">

                <div class="card border-0 shadow-lg reportes-card">

                    {{-- HEADER --}}
                    <div class="card-header reportes-header">

                        <div>

                            <h4 class="fw-bold mb-1">
                                Reportes de Seguimiento Académico
                            </h4>

                            <p class="text-muted mb-0">
                                Genera reportes PDF con calificaciones,
                                observaciones y promedio final de cada revisión.
                            </p>

                        </div>

                    </div>

                    <div class="card-body p-4">

                        {{-- ALERTAS --}}
                        @if(session('success'))

                        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">

                            <i class="bi bi-check-circle-fill me-2"></i>

                            {{ session('success') }}

                        </div>

                        @endif

                        @if(session('error'))

                        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">

                            <i class="bi bi-exclamation-triangle-fill me-2"></i>

                            {{ session('error') }}

                        </div>

                        @endif

                        {{-- CARDS RESUMEN --}}
                        <div class="row mb-4 g-3">

                            <div class="col-md-4">

                                <div class="infoCard shadow-sm">

                                    <div class="infoIcon bg-primary">

                                        <i class="bi bi-file-earmark-pdf-fill"></i>

                                    </div>

                                    <div>

                                        <h5 class="fw-bold mb-0">
                                            {{ $evidencias->count() }}
                                        </h5>

                                        <small>
                                            Reportes disponibles
                                        </small>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="infoCard shadow-sm">

                                    <div class="infoIcon bg-success">

                                        <i class="bi bi-check-circle-fill"></i>

                                    </div>

                                    <div>

                                        <h5 class="fw-bold mb-0">
                                            {{ $evidencias->where('estado', 2)->count() }}
                                        </h5>

                                        <small>
                                            Evidencias aprobadas
                                        </small>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="infoCard shadow-sm">

                                    <div class="infoIcon bg-danger">

                                        <i class="bi bi-x-circle-fill"></i>

                                    </div>

                                    <div>

                                        <h5 class="fw-bold mb-0">
                                            {{ $evidencias->where('estado', 4)->count() }}
                                        </h5>

                                        <small>
                                            Evidencias rechazadas
                                        </small>

                                    </div>

                                </div>

                            </div>

                        </div>

                        {{-- TABLA --}}
                        <div class="table-responsive">

                            <table class="table align-middle table-hover">

                                <thead>

                                    <tr>

                                        <th class="text-center">
                                            #
                                        </th>

                                        <th>
                                            Docente
                                        </th>

                                        <th>
                                            Cargo
                                        </th>

                                        <th>
                                            Materia
                                        </th>

                                        <th class="text-center">
                                            Revisión
                                        </th>

                                        <th class="text-center">
                                            Estado
                                        </th>

                                        <th class="text-center">
                                            Promedio
                                        </th>

                                        <th class="text-center">
                                            Acciones
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @forelse($evidencias as $item)

                                    @php

                                    $evaluacion =
                                    $item->evaluacion ?? [];

                                    $criterios = [

                                    'instrumentacion',
                                    'reporte_inicio',
                                    'examen_diagnostico',
                                    'analisis_diagnostico',
                                    'acuerdos',
                                    'instrumentos',
                                    'rubricas',
                                    'calificaciones',
                                    'rac',

                                    ];

                                    $suma = 0;
                                    $contador = 0;

                                    foreach($criterios as $criterio){

                                    $calificacion =
                                    $evaluacion[$criterio]['calificacion']
                                    ?? null;

                                    $na =
                                    $evaluacion[$criterio]['na']
                                    ?? false;

                                    if(!$na && $calificacion !== null){

                                    $suma += $calificacion;
                                    $contador++;

                                    }

                                    }

                                    $promedio =
                                    $contador > 0
                                    ? round($suma / $contador, 2)
                                    : 0;

                                    @endphp

                                    <tr>

                                        <td class="text-center fw-bold">

                                            {{ $item->id }}

                                        </td>

                                        <td>

                                            <div class="d-flex flex-column">

                                                <span class="fw-bold">

                                                    {{ $item->asignacion?->docente?->name }}

                                                </span>

                                                <small class="text-muted">

                                                    {{ $item->asignacion?->docente?->email }}

                                                </small>

                                            </div>

                                        </td>

                                        <td>

                                            <span class="badge bg-dark rounded-pill px-3 py-2">

                                                {{ $item->asignacion?->docente?->cargo ?? 'Sin cargo' }}

                                            </span>

                                        </td>

                                        <td class="fw-semibold">

                                            {{ $item->materia?->nombre }}

                                        </td>

                                        <td class="text-center">

                                            <span class="badge bg-primary rounded-pill px-3 py-2">

                                                {{ $item->revision?->nombre }}

                                            </span>

                                        </td>

                                        <td class="text-center">

                                            @switch($item->estado)

                                            @case(2)

                                            <span class="badge bg-success rounded-pill px-3 py-2">

                                                <i class="bi bi-check-circle-fill"></i>
                                                Aprobada

                                            </span>

                                            @break

                                            @case(3)

                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">

                                                <i class="bi bi-clock-history"></i>
                                                Pendiente

                                            </span>

                                            @break

                                            @case(4)

                                            <span class="badge bg-danger rounded-pill px-3 py-2">

                                                <i class="bi bi-x-circle-fill"></i>
                                                Rechazada

                                            </span>

                                            @break

                                            @default

                                            <span class="badge bg-secondary rounded-pill px-3 py-2">

                                                Sin estado

                                            </span>

                                            @endswitch

                                        </td>

                                        <td class="text-center">

                                            @if($promedio >= 70)

                                            <span class="fw-bold text-success">

                                                {{ $promedio }}

                                            </span>

                                            @else

                                            <span class="fw-bold text-danger">

                                                {{ $promedio }}

                                            </span>

                                            @endif

                                        </td>

                                        <td class="text-center">

                                            <div class="d-flex justify-content-center gap-2">

                                                {{-- PDF --}}
                                                <a
                                                    href="{{ route('reportes-generar', $item->id) }}"
                                                    target="_blank"
                                                    class="btn btn-danger rounded-circle shadow-sm"
                                                    title="Generar PDF"
                                                    style="width:46px;height:46px;display:flex;align-items:center;justify-content:center;">

                                                    <i class="bi bi-file-earmark-pdf-fill"></i>

                                                </a>

                                                {{-- VER EVALUACION --}}
                                                <a
                                                    href="{{ route('evaluaciones.show', $item->id) }}"
                                                    class="btn btn-primary rounded-circle shadow-sm"
                                                    title="Ver evaluación"
                                                    style="width:46px;height:46px;display:flex;align-items:center;justify-content:center;">

                                                    <i class="bi bi-eye-fill"></i>

                                                </a>

                                            </div>

                                        </td>

                                    </tr>

                                    @empty

                                    <tr>

                                        <td colspan="8"
                                            class="text-center py-5 text-muted">

                                            <i class="bi bi-folder-x display-4 d-block mb-3"></i>

                                            No existen reportes disponibles.

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
    .reportes-card {

        border-radius: 24px;
        overflow: hidden;
        background: white;

    }

    .reportes-header {

        background: linear-gradient(135deg, #f8fbff, #eef5ff);
        border-bottom: 1px solid #e8eef7;
        padding: 25px;

    }

    .infoCard {

        background: white;
        border-radius: 18px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 16px;
        border: 1px solid #e5e7eb;

    }

    .infoIcon {

        width: 60px;
        height: 60px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;

    }

    table thead th {

        background: linear-gradient(135deg, #0a2342, #102c57) !important;
        color: white !important;
        border: none;
        padding: 16px;
        font-weight: 700;
        vertical-align: middle;

    }

    table tbody td {

        padding: 16px 12px;
        vertical-align: middle;

    }

    table tbody tr:hover {

        background: rgba(15, 23, 42, .03);

    }

    table thead tr th:first-child {

        border-top-left-radius: 12px;

    }

    table thead tr th:last-child {

        border-top-right-radius: 12px;

    }
</style>

@endsection