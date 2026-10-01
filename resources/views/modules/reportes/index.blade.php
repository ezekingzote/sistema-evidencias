@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

<main id="main" class="main">

    <div class="pagetitle mb-4">
        {{-- Alineación premium del título y botón de ayuda --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="fw-bold text-primary mb-1">
                    Reportes de Evaluación
                </h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="" class="text-decoration-none text-secondary">Home</a>
                        </li>
                        <li class="breadcrumb-item active text-primary fw-semibold">
                            Reportes
                        </li>
                    </ol>
                </nav>
            </div>

            <div>
                <button type="button" class="btn btn-info text-white rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalManualReportes">
                    <i class="bi bi-question-circle me-1"></i> Ayuda
                </button>
            </div>
        </div>
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
                        @if (session('success'))
                            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">

                                <i class="bi bi-check-circle-fill me-2"></i>

                                {{ session('success') }}

                            </div>
                        @endif

                        @if (session('error'))
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

                            <table class="table table-hover align-middle">

                                <thead>

                                    <tr>

                                        <th>Docente</th>

                                        <th>Materia</th>

                                        @foreach ($revisiones as $revision)
                                            <th class="text-center">

                                                <div class="fw-bold">

                                                    {{ $revision->nombre }}

                                                </div>

                                                @if ($revision->fecha_limite)
                                                    <small class="text-white-50">

                                                        {{ \Carbon\Carbon::parse($revision->fecha_limite)->format('d/m/Y') }}

                                                    </small>
                                                @endif

                                            </th>
                                        @endforeach
                                        <th class="text-center">
                                            Acciones
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @forelse($materias as $materia)

                                        <tr>

                                            <td>

                                                {{ $materia->docente_nombre ?? 'Sin docente asignado' }}

                                            </td>

                                            <td>

                                                {{ $materia->nombre }}

                                            </td>

                                            @foreach ($revisiones as $revision)
                                                @php

                                                    $evidencia = $materia->evidencias
                                                        ->where('revision_id', $revision->id)
                                                        ->first();

                                                @endphp

                                                <td class="text-center">

                                                    {{-- REVISION INACTIVA --}}
                                                    @if (!$revision->activo)
                                                        <button class="estadoBtn asignada" disabled>

                                                            <i class="bi bi-pause-circle-fill"></i>

                                                        </button>

                                                    {{-- EXISTE EVIDENCIA Y ESTÁ EVALUADA (aprobada/rechazada) --}}
                                                    @elseif($evidencia && in_array($evidencia->estado, [2, 4]))
                                                        <a href="{{ route('reportes-generar', $evidencia->id) }}"
                                                           target="_blank">

                                                            <button class="estadoBtn 
                                                                @if($evidencia->estado == 2) aprobado @else rechazada @endif">

                                                                <i class="bi bi-file-earmark-pdf-fill"></i>

                                                            </button>

                                                        </a>

                                                    {{-- EXISTE EVIDENCIA PERO ESTÁ PENDIENTE (estado=3) --}}
                                                    @elseif($evidencia && $evidencia->estado == 3)
                                                        <button class="estadoBtn pendiente" 
                                                                style="background: linear-gradient(135deg, #f59e0b, #d97706); cursor: not-allowed;"
                                                                data-bs-toggle="tooltip" 
                                                                data-bs-placement="top" 
                                                                title="Evidencia subida pero aún no evaluada. No se puede generar reporte."
                                                                disabled>
                                                            <i class="bi bi-hourglass-split"></i>
                                                        </button>

                                                    {{-- NO EXISTE EVIDENCIA --}}
                                                    @else
                                                        <button class="estadoBtn vacio" 
                                                                style="cursor: not-allowed; opacity: 0.7;"
                                                                data-bs-toggle="tooltip" 
                                                                data-bs-placement="top" 
                                                                title="PDF NO DISPONIBLE - Revisión no evaluada"
                                                                disabled>
                                                            <i class="fa-solid fa-file-excel"></i>
                                                        </button>
                                                    @endif

                                                </td>
                                            @endforeach

                                            <td class="text-center">

                                                @php
                                                    $docente = $materia->asignaciones->first()?->docente;
                                                    $telefono = preg_replace(
                                                        '/[^0-9]/',
                                                        '',
                                                        $docente?->celular ?? '',
                                                    );

                                                    $revisionesDisponibles = [];

                                                    foreach ($revisiones as $revision) {
                                                        if (!$revision->activo) {
                                                            continue;
                                                        }

                                                        $evidencia = $materia->evidencias
                                                            ->where('revision_id', $revision->id)
                                                            ->first();

                                                        // Solo se puede enviar el PDF si la evidencia existe y está evaluada (aprobada o rechazada)
                                                        if ($evidencia && in_array($evidencia->estado, [2, 4])) {
                                                            $pdfUrl = route('reportes-generar', $evidencia->id);

                                                            $mensaje = "Hola {$docente?->name}, comparto el reporte de {$materia->nombre} correspondiente a {$revision->nombre}: {$pdfUrl}";

                                                            $revisionesDisponibles[] = [
                                                                'nombre' => $revision->nombre,
                                                                'url' => "https://wa.me/52{$telefono}?text=" . urlencode($mensaje),
                                                            ];
                                                        }
                                                    }
                                                @endphp

                                                @if ($telefono && count($revisionesDisponibles))
                                                    <select class="form-select form-select-sm enviarWhatsapp">

                                                        <option value="">
                                                            Enviar PDF...
                                                        </option>

                                                        @foreach ($revisionesDisponibles as $item)
                                                            <option value="{{ $item['url'] }}">
                                                                {{ $item['nombre'] }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        Sin WhatsApp
                                                    </span>
                                                @endif

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="{{ $revisiones->count() + 3 }}" class="text-center py-5">

                                                No existen registros.

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

@include('modules.reportes.manual')

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/custom-tables.css') }}">
@endpush

@push('scripts')
    @include('modules.reportes.scripts')
@endpush