@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

<main id="main" class="main">

    <div class="pagetitle">

        <h1 class="fw-bold text-primary">
            Administración de Evidencias
        </h1>

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

                    <div class="card-header evidencia-header">

                        <div>

                            <h4 class="mb-1 fw-bold">
                                Evidencias de Docentes
                            </h4>

                            <p class="text-muted mb-0">
                                Consulta el estado de evidencias registradas por cada docente.
                            </p>

                        </div>

                    </div>

                    <div class="card-body p-4">

                        <div class="estadoLegend mb-4">

                            <div class="estadoCard">

                                <div class="estadoIcon aprobado">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>

                                <div>
                                    <h6>Aprobada</h6>
                                    <small>Validada por administración</small>
                                </div>

                            </div>

                            <div class="estadoCard">

                                <div class="estadoIcon pendiente">
                                    <i class="bi bi-clock-history"></i>
                                </div>

                                <div>
                                    <h6>Pendiente</h6>
                                    <small>En espera de revisión</small>
                                </div>

                            </div>

                            <div class="estadoCard">

                                <div class="estadoIcon rechazada">
                                    <i class="bi bi-x-circle-fill"></i>
                                </div>

                                <div>
                                    <h6>Rechazada</h6>
                                    <small>Requiere corrección</small>
                                </div>

                            </div>

                            <div class="estadoCard">

                                <div class="estadoIcon vacio">
                                    <i class="bi bi-dash-circle-fill"></i>
                                </div>

                                <div>
                                    <h6>Sin evidencia</h6>
                                    <small>No entregada</small>
                                </div>

                            </div>

                            <div class="estadoCard">

                                <div class="estadoIcon asignada">
                                    <i class="bi bi-pause-circle-fill"></i>
                                </div>

                                <div>
                                    <h6>Revisión inactiva</h6>
                                    <small>Actualmente deshabilitada</small>
                                </div>

                            </div>

                        </div>

                        <div class="table-responsive">

                            <table class="table table-hover align-middle">

                                <thead>

                                    <tr>

                                        <th class="text-center">
                                            Docente
                                        </th>

                                        <th class="text-center">
                                            Asignatura
                                        </th>

                                        @foreach ($revisiones as $revision)

                                        <th class="text-center">
                                            {{ $revision->nombre }}
                                        </th>

                                        @endforeach

                                        <th class="text-center">
                                            Avance
                                        </th>

                                    </tr>

                                </thead>

                                <tbody class="text-center">

                                    @forelse ($materias as $materia)

                                    @php

                                    $evidenciasSubidas = $materia->evidencias;

                                    $totalRevisiones = $revisiones
                                    ->where('activo', 1)
                                    ->count();

                                    $cantidadSubidas = $evidenciasSubidas
                                    ->whereIn('estado', [2,3,4])
                                    ->count();

                                    $porcentaje = $totalRevisiones > 0
                                    ? ($cantidadSubidas / $totalRevisiones) * 100
                                    : 0;

                                    @endphp

                                    <tr>

                                        <td class="fw-semibold">

                                            {{ $materia->asignaciones->first()?->docente?->name }}

                                        </td>

                                        <td class="fw-semibold">
                                            {{ $materia->nombre }}
                                        </td>

                                        @foreach ($revisiones as $revision)

                                        @php

                                        $evidenciaActual = $evidenciasSubidas
                                        ->where('revision_id', $revision->id)
                                        ->first();

                                        if (!$revision->activo) {

                                        $estado = 0;

                                        } elseif (!$evidenciaActual) {

                                        $estado = 1;

                                        } else {

                                        $estado = $evidenciaActual->estado;
                                        }

                                        @endphp

                                        <td>

                                            @switch($estado)

                                            @case(0)

                                            <button class="estadoBtn asignada"
                                                title="Revisión inactiva">

                                                <i class="bi bi-pause-circle-fill"></i>

                                            </button>

                                            @break

                                            @case(1)

                                            <button class="estadoBtn vacio"
                                                title="Sin evidencia">

                                                <i class="bi bi-dash-circle-fill"></i>

                                            </button>

                                            @break

                                            @case(2)

                                            <button class="estadoBtn aprobado"
                                                title="Aprobada">

                                                <i class="bi bi-check-circle-fill"></i>

                                            </button>

                                            @break

                                            @case(3)

                                            <button class="estadoBtn pendiente"
                                                title="Pendiente">

                                                <i class="bi bi-clock-history"></i>

                                            </button>

                                            @break

                                            @case(4)

                                            <button class="estadoBtn rechazada"
                                                title="Rechazada">

                                                <i class="bi bi-x-circle-fill"></i>

                                            </button>

                                            @break

                                            @endswitch

                                        </td>

                                        @endforeach

                                        <td class="text-center align-middle">

                                            @php
                                            $porcentaje = (int) round($porcentaje);
                                            $colorBarra = $porcentaje >= 100 ? 'bg-success' : 'bg-primary';
                                            @endphp

                                            <div class="d-flex align-items-center gap-2">

                                                <div class="progress progress-custom flex-grow-1">

                                                    <div class="progress-bar {{ $colorBarra }}"
                                                        role="progressbar"
                                                        style="width: {{ $porcentaje }}%; min-width: 35px;"
                                                        aria-valuenow="{{ $porcentaje }}"
                                                        aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    </div>

                                                </div>

                                                <span class="fw-bold text-dark">
                                                    {{ $porcentaje }}%
                                                </span>

                                            </div>

                                        </td>

                                    </tr>

                                    @empty

                                    <tr>

                                        <td colspan="{{ $revisiones->count() + 3 }}"
                                            class="text-center py-5 text-muted">

                                            <i class="bi bi-folder-x display-4 d-block mb-3"></i>

                                            No existen evidencias registradas.

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
    .evidencia-card {

        border-radius: 24px;
        overflow: hidden;
        background: white;

    }

    .evidencia-header {

        background: linear-gradient(135deg, #f8fbff, #eef5ff);
        border-bottom: 1px solid #e8eef7;
        padding: 25px;

    }

    .estadoLegend {

        display: flex;
        flex-wrap: wrap;
        gap: 18px;

    }

    .estadoCard {

        background: white;
        border-radius: 18px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 8px 20px rgba(0, 0, 0, .05);
        transition: .3s ease;

    }

    .estadoCard:hover {

        transform: translateY(-4px);

    }

    .estadoIcon {

        width: 55px;
        height: 55px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-size: 22px;
        box-shadow: 0 8px 18px rgba(0, 0, 0, .12);

    }

    .estadoCard h6 {

        margin: 0;
        font-weight: 700;
        font-size: 14px;

    }

    .estadoCard small {

        color: #6b7280;

    }

    .aprobado {

        background: linear-gradient(135deg, #10b981, #059669);

    }

    .asignada {

        background: linear-gradient(135deg, #3b82f6, #2563eb);

    }

    .pendiente {

        background: linear-gradient(135deg, #f59e0b, #d97706);

    }

    .rechazada {

        background: linear-gradient(135deg, #ef4444, #dc2626);

    }

    .vacio {

        background: linear-gradient(135deg, #9ca3af, #6b7280);

    }

    table thead th {

        background: #0f172a;
        color: white;
        border: none;
        font-size: 14px;
        font-weight: 700;
        padding: 18px;

    }

    table tbody tr {

        transition: .3s ease;

    }

    table tbody tr:hover {

        background: rgba(15, 23, 42, .03);

    }

    table tbody td {

        padding: 18px 12px;
        vertical-align: middle;

    }

    .estadoBtn {

        width: 55px;
        height: 55px;
        border-radius: 50%;
        border: none;
        color: white;
        font-size: 20px;
        box-shadow: 0 8px 18px rgba(0, 0, 0, .12);
        transition: .3s ease;

    }

    .estadoBtn:hover {

        transform: translateY(-4px) scale(1.05);

    }

    .progress-custom {

        height: 22px;
        border-radius: 30px;
        background: #edf2f7;
        min-width: 160px;
        overflow: hidden;

    }

    .progress-bar {

        border-radius: 30px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: width .6s ease;

    }
</style>

@endsection