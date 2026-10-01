@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

    <main id="main" class="main">

        <div class="pagetitle mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="fw-bold text-primary mb-1">
                        Administración de Evidencias
                    </h1>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="" class="text-decoration-none text-secondary">Home</a>
                            </li>
                            <li class="breadcrumb-item active text-primary fw-semibold">
                                Evidencias
                            </li>
                        </ol>
                    </nav>
                </div>

                {{-- Botón de Ayuda --}}
                <div>
                    <button type="button" class="btn btn-info text-white rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalManualEvidenciasDocente">
                        <i class="bi bi-question-circle me-1"></i> Ayuda
                    </button>
                </div>
            </div>
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

                                                $cantidadAprobadas = $evidenciasSubidas->where('estado', 2)->count();
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
                                                                <a href="{{ url('/evidencias/edit/' . $evidenciaActual->id) }}"
                                                                    class="d-inline-block"
                                                                    title="Evidencia Pendiente. Click para gestionar u optimizar.">
                                                                    <button type="button" class="estadoBtn pendiente">
                                                                        <i class="bi bi-clock-history"></i>
                                                                    </button>
                                                                </a>
                                                            @break

                                                            @case(4)
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
    @include('modules.evidencias.manual-index')

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/custom-tables.css') }}">
@endpush