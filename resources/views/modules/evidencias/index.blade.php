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
                        <a href="" class="text-decoration-none text-secondary">Home</a>
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
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="mb-1 fw-bold">Evidencias de Docentes</h4>
                                    <p class="text-muted mb-0">
                                        Consulta el estado de evidencias registradas por cada docente y gestiona sus
                                        dictámenes.
                                    </p>
                                </div>

                                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                    <a href="{{ route('evidencias.create') }}"
                                        class="btn btn-outline-primary shadow-sm px-4 py-2 rounded-pill fw-bold">
                                        <i class="bi bi-plus-circle me-2"></i>Nueva Evidencia
                                    </a>
                                </div>
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
                                        <small>Validada (Redirige a Detalle)</small>
                                    </div>
                                </div>
                                <div class="estadoCard">
                                    <div class="estadoIcon pendiente">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                    <div>
                                        <h6>Pendiente</h6>
                                        <small>En espera (Redirige a Editar)</small>
                                    </div>
                                </div>
                                <div class="estadoCard">
                                    <div class="estadoIcon rechazada">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </div>
                                    <div>
                                        <h6>Rechazada</h6>
                                        <small>Requiere ajuste (Redirige a Editar)</small>
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

                            {{-- Alertas de éxito o error al evaluar --}}
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4"
                                    role="alert">
                                    <i class="bi bi-check-circle-fill me-2"></i><strong>¡Éxito!</strong>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4"
                                    role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Atención:</strong>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 30%;">Docente</th>
                                            <th class="text-center" style="width: 30%;">Asignatura</th>
                                            @foreach ($revisiones as $revision)
                                                <th class="text-center" style="min-width:10%;">
                                                    <div class="fw-bold">{{ $revision->nombre }}</div>
                                                    @if ($revision->fecha_limite)
                                                        <small class="d-block mt-1 text-white-50" style="font-size: 11px;">
                                                            Límite:
                                                            {{ \Carbon\Carbon::parse($revision->fecha_limite)->format('d/m/Y') }}
                                                        </small>
                                                    @else
                                                        <small class="d-block mt-1 text-white-50"
                                                            style="font-size: 11px;">Sin fecha límite</small>
                                                    @endif
                                                </th>
                                            @endforeach
                                            <th class="text-center" style="width: 20%; min-width: 180px;">Avance Real</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @forelse ($materias as $materia)
                                            @php
                                                $evidenciasSubidas = $materia->evidencias;
                                                $totalRevisiones = $revisiones->where('activo', 1)->count();

                                                // 1. Contamos únicamente las que estén APROBADAS (estado 2) para el avance real
                                                $cantidadAprobadas = $evidenciasSubidas->where('estado', 2)->count();

                                                // Comprobamos si tiene alguna rechazada (estado 4) para alertar visualmente en la barra
                                                $tieneRechazadas = $evidenciasSubidas->where('estado', 4)->count() > 0;

                                                $porcentaje =
                                                    $totalRevisiones > 0
                                                        ? ($cantidadAprobadas / $totalRevisiones) * 100
                                                        : 0;
                                                $porcentaje = (int) round($porcentaje);
                                            @endphp
                                            <tr>
                                                <td class="fw-semibold text-center text-dark">
                                                    {{ $materia->asignaciones->first()?->docente?->user?->name ?? 'Sin Docente Asignado' }}
                                                </td>
                                                <td class="fw-semibold text-center text-secondary">
                                                    {{ $materia->nombre }}
                                                </td>

                                                @foreach ($revisiones as $revision)
                                                    @php
                                                        $evidenciaActual = $evidenciasSubidas
                                                            ->where('revision_id', $revision->id)
                                                            ->first();

                                                        if (!$revision->activo) {
                                                            $estado = 0; // Inactiva
                                                        } elseif (!$evidenciaActual) {
                                                            $estado = 1; // Sin entregar
                                                        } else {
                                                            $estado = $evidenciaActual->estado; // Estado real de la DB (2, 3 o 4)
                                                        }
                                                    @endphp
                                                    <td>
                                                        @switch($estado)
                                                            @case(0)
                                                                <button type="button" class="estadoBtn asignada"
                                                                    title="Revisión inactiva"
                                                                    style="cursor: not-allowed; opacity: 0.6;">
                                                                    <i class="bi bi-pause-circle-fill"></i>
                                                                </button>
                                                            @break

                                                            @case(1)
                                                                <button type="button" class="estadoBtn vacio"
                                                                    title="Sin evidencia cargada"
                                                                    style="cursor: not-allowed; opacity: 0.6;">
                                                                    <i class="bi bi-dash-circle-fill"></i>
                                                                </button>
                                                            @break

                                                            @case(2)
                                                                <a href="{{ route('evidencias.edit', $evidenciaActual->id) }}"
                                                                    class="d-inline-block" title="Ver evidencia">

                                                                    <button type="button" class="estadoBtn aprobado">
                                                                        <i class="bi bi-check-circle-fill"></i>
                                                                    </button>

                                                                </a>
                                                            @break

                                                            @case(3)
                                                                {{-- Pendiente: Redirecciona al EDIT --}}
                                                                <a href="{{ url('/evidencias/edit/' . $evidenciaActual->id) }}"
                                                                    class="d-inline-block"
                                                                    title="Evidencia Pendiente. Click para gestionar u optimizar.">
                                                                    <button type="button" class="estadoBtn pendiente">
                                                                        <i class="bi bi-clock-history"></i>
                                                                    </button>
                                                                </a>
                                                            @break

                                                            @case(4)
                                                                {{-- Rechazada: Redirecciona al EDIT --}}
                                                                <a href="{{ url('/evidencias/edit/' . $evidenciaActual->id) }}"
                                                                    class="d-inline-block"
                                                                    title="Evidencia Rechazada. Click para corregir u observar anomalías.">
                                                                    <button type="button" class="estadoBtn rechazada">
                                                                        <i class="bi bi-x-circle-fill"></i>
                                                                    </button>
                                                                </a>
                                                            @break
                                                        @endswitch
                                                    </td>
                                                @endforeach

                                                <td class="text-center align-middle">
                                                    @php
                                                        // Determinación dinámica del color de la barra
                                                        if ($tieneRechazadas) {
                                                            $colorBarra = 'bg-danger';
                                                        } elseif ($porcentaje >= 100) {
                                                            $colorBarra = 'bg-success';
                                                        } else {
                                                            $colorBarra = 'bg-primary';
                                                        }
                                                    @endphp
                                                    <div
                                                        class="d-flex align-items-center justify-content-center gap-3 px-3">
                                                        <div class="progress progress-custom w-100"
                                                            style="position: relative;">
                                                            <div class="progress-bar {{ $colorBarra }}"
                                                                role="progressbar" style="width: {{ $porcentaje }}%;"
                                                                aria-valuenow="{{ $porcentaje }}" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                        <span
                                                            class="fw-bold @if ($tieneRechazadas) text-danger @else text-dark @endif"
                                                            style="min-width: 45px; text-align: right;">
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
                                                        No existen asignaturas ni evidencias registradas en este bloque.
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
                background: linear-gradient(135deg, #0a2342, #102c57) !important;
                color: white !important;
                border: none;
                padding: 16px;
                text-align: center;
                vertical-align: middle;
                font-size: 15px;
                font-weight: 700;
            }

            table tbody tr:hover {
                background: rgba(15, 23, 42, .03);
            }

            table tbody td {
                padding: 14px 10px;
                vertical-align: middle;
            }

            .estadoBtn {
                width: 46px;
                height: 46px;
                border-radius: 50%;
                border: none;
                color: white;
                font-size: 18px;
                box-shadow: 0 6px 14px rgba(0, 0, 0, .1);
                transition: .3s ease;
            }

            a .estadoBtn:hover {
                transform: translateY(-3px) scale(1.05);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            }

            .progress-custom {
                height: 18px;
                border-radius: 30px;
                background: #edf2f7;
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

            table thead tr th:first-child {
                border-top-left-radius: 12px;
            }

            table thead tr th:last-child {
                border-top-right-radius: 12px;
            }
        </style>

    @endsection
