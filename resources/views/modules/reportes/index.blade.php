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

                                                    {{-- EXISTE EVIDENCIA --}}
                                                    @elseif($evidencia)
                                                        @php

                                                            $estado = $evidencia->estado;

                                                        @endphp

                                                        @if($estado == 3)
                                                            {{-- PENDIENTE SIN EVALUAR: botón deshabilitado gris con tooltip --}}
                                                            <button class="estadoBtn sin-evaluar" 
                                                                    style="background: linear-gradient(135deg, #9ca3af, #6b7280); cursor: not-allowed;"
                                                                    data-bs-toggle="tooltip" 
                                                                    data-bs-placement="top" 
                                                                    title="Revisión sin evaluar"
                                                                    disabled>
                                                                <i class="bi bi-file-earmark-pdf-fill"></i>
                                                            </button>
                                                        @else
                                                            <a href="{{ route('reportes-generar', $evidencia->id) }}"
                                                               target="_blank">

                                                                <button class="estadoBtn 
                                                                    @switch($estado)
                                                                        @case(2) aprobado @break
                                                                        @case(4) rechazada @break
                                                                        @default vacio
                                                                    @endswitch">

                                                                    <i class="bi bi-file-earmark-pdf-fill"></i>

                                                                </button>

                                                            </a>
                                                        @endif

                                                    {{-- NO EXISTE EVIDENCIA --}}
                                                    @else
                                                        <a href="{{ route('reportes-vacio', [
                                                            'materia' => $materia->id,
                                                            'revision' => $revision->id,
                                                        ]) }}"
                                                           class="btn btn-secondary rounded-circle generar-vacio">

                                                            <i class="bi bi-file-earmark-pdf-fill"></i>

                                                        </a>
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

                                                        if ($evidencia) {
                                                            $pdf = route('reportes-generar', $evidencia->id);
                                                        } else {
                                                            $pdf = route('reportes-vacio', [
                                                                'materia' => $materia->id,
                                                                'revision' => $revision->id,
                                                            ]);
                                                        }

                                                        $mensaje = "Hola {$docente?->name}, comparto el reporte de {$materia->nombre} correspondiente a {$revision->nombre}: {$pdf}";

                                                        $revisionesDisponibles[] = [
                                                            'nombre' => $revision->nombre,
                                                            'url' =>
                                                                "https://wa.me/52{$telefono}?text=" .
                                                                urlencode($mensaje),
                                                        ];
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

    .estadoBtn:hover:not(:disabled) {
        transform: translateY(-3px);
    }

    .aprobado {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .rechazada {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    .vacio {
        background: linear-gradient(135deg, #9ca3af, #6b7280);
    }

    .asignada {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
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

<script>
    // Inicializar tooltips de Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    // Confirmación para reporte vacío
    document.querySelectorAll('.generar-vacio').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.href;
            Swal.fire({
                icon: 'warning',
                title: 'Sin evaluación',
                html: `
                    Esta revisión se encuentra activa pero el docente
                    <b>no ha entregado evidencia</b>.
                    <br><br>
                    El reporte se generará con:
                    <ul style="text-align:left;margin-top:10px;">
                        <li>Todas las calificaciones en 0</li>
                        <li>Observación: "SIN ENTREGAR EVIDENCIA"</li>
                    </ul>
                    ¿Deseas generar el PDF?
                `,
                showCancelButton: true,
                confirmButtonText: 'Sí, generar PDF',
                cancelButtonText: 'No',
                confirmButtonColor: '#198754',
                cancelButtonColor: '#dc3545'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open(url, '_blank');
                }
            });
        });
    });

    // Envío por WhatsApp
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('enviarWhatsapp')) {
            const url = e.target.value;
            if (url) {
                window.open(url, '_blank');
                e.target.selectedIndex = 0;
            }
        }
    });
</script>

@endsection