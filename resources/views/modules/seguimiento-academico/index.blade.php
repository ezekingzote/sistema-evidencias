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

                <div>
                    <button type="button" class="btn btn-info text-white rounded-pill px-4 shadow-sm"
                        data-bs-toggle="modal" data-bs-target="#modalManualEvidencias">
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
                            <div>
                                <h4 class="mb-1 fw-bold">Evidencias de Docentes</h4>
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
                                                <th class="text-center" style="width:10%;">
                                                    <div class="fw-bold">{{ $revision->nombre }}</div>
                                                    @if ($revision->fecha_limite)
                                                        <small class="d-block mt-1 text-white-50">
                                                            Límite:
                                                            {{ \Carbon\Carbon::parse($revision->fecha_limite)->format('d/m/Y') }}
                                                        </small>
                                                    @else
                                                        <small class="d-block mt-1 text-white-50">No activa</small>
                                                    @endif
                                                </th>
                                            @endforeach
                                            <th class="text-center" style="width: 20%; min-width: 180px;">Avance Real</th>
                                            <th class="text-center" style="width: 120px;">
                                                Acciones
                                            </th>
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
                                                <td class="fw-semibold text-center">
                                                    {{ $materia->docente_nombre ?? 'Sin docente asignado' }}
                                                </td>
                                                <td class="fw-semibold text-center">
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
                                                                <button class="estadoBtn asignada" title="Revisión inactiva"
                                                                    style="cursor: not-allowed; opacity: 0.6;">
                                                                    <i class="bi bi-pause-circle-fill"></i>
                                                                </button>
                                                            @break

                                                            @case(1)
                                                                <button type="button"
                                                                    class="estadoBtn vacio btn-rechazar-sin-evidencia"
                                                                    data-asignacion="{{ $materia->asignacion_id }}"
                                                                    data-materia="{{ $materia->id }}"
                                                                    data-revision="{{ $revision->id }}" title="Sin evidencia">

                                                                    <i class="bi bi-dash-circle-fill"></i>

                                                                </button>
                                                            @break

                                                            @case(2)
                                                                <a href="{{ route('evaluaciones.show', $evidenciaActual->id) }}"
                                                                    class="d-inline-block"
                                                                    title="Evidencia Aprobada. Clic para modificar dictamen.">
                                                                    <button class="estadoBtn aprobado">
                                                                        <i class="bi bi-check-circle-fill"></i>
                                                                    </button>
                                                                </a>
                                                            @break

                                                            @case(3)
                                                                <a href="{{ route('evaluaciones.show', $evidenciaActual->id) }}"
                                                                    class="d-inline-block"
                                                                    title="Evidencia Pendiente. Clic para evaluar de inmediato.">
                                                                    <button class="estadoBtn pendiente">
                                                                        <i class="bi bi-clock-history"></i>
                                                                    </button>
                                                                </a>
                                                            @break

                                                            @case(4)
                                                                <a href="{{ route('evaluaciones.show', $evidenciaActual->id) }}"
                                                                    class="d-inline-block"
                                                                    title="Evidencia $titulo. Clic para modificar observaciones.">
                                                                    <button class="estadoBtn rechazada">
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
                                                            $colorBarra = 'bg-danger'; // Alerta roja instantánea si hay un rechazo
                                                        } elseif ($porcentaje >= 100) {
                                                            $colorBarra = 'bg-success'; // Verde limpio si todo está aprobado
                                                        } else {
                                                            $colorBarra = 'bg-primary'; // Azul base en progreso regular
                                                        }
                                                    @endphp
                                                    @php

                                                        $docente = $materia->asignaciones->first()?->docente;

                                                        $totalPendientes = $evidenciasSubidas
                                                            ->where('estado', 3)
                                                            ->count();
                                                        $totalRechazadas = $evidenciasSubidas
                                                            ->where('estado', 4)
                                                            ->count();

                                                        if ($totalRechazadas > 0) {
                                                            $mensaje = "Hola {$docente?->name}, tienes {$totalRechazadas} evidencia(s) rechazada(s) en {$materia->nombre}. Favor de revisarlas y corregirlas.";

                                                            $btnClass = 'btn-danger';
                                                            $icono = 'bi-exclamation-triangle-fill';
                                                            $tituloBtn = 'Notificar correcciones';
                                                        } elseif ($porcentaje >= 100) {
                                                            $mensaje = "Hola {$docente?->name}, felicidades. Todas las evidencias de {$materia->nombre} han sido aprobadas correctamente.";

                                                            $btnClass = 'btn-success';
                                                            $icono = 'bi-trophy-fill';
                                                            $tituloBtn = 'Felicitar docente';
                                                        } else {
                                                            $mensaje = "Hola {$docente?->name}, llevas {$cantidadAprobadas} de {$totalRevisiones} evidencias aprobadas en {$materia->nombre}. No olvides completar las evidencias restantes.";

                                                            $btnClass = 'btn-warning';
                                                            $icono = 'bi-bell-fill';
                                                            $tituloBtn = 'Recordar evidencias';
                                                        }

                                                        $telefono = preg_replace(
                                                            '/[^0-9]/',
                                                            '',
                                                            $docente?->celular ?? '',
                                                        );

                                                    @endphp
                                                    <div
                                                        class="d-flex align-items-center justify-content-center gap-3 px-3">
                                                        <div class="progress progress-custom w-100"
                                                            style="position: relative;">
                                                            <div class="progress-bar {{ $colorBarra }}"
                                                                role="progressbar" style="width: {{ $porcentaje }}%;"
                                                                aria-valuenow="{{ $porcentaje }}" aria-vmin="0"
                                                                aria-vmax="100">
                                                            </div>
                                                        </div>
                                                        <span
                                                            class="fw-bold @if ($tieneRechazadas) text-danger @else text-dark @endif"
                                                            style="min-width: 45px; text-align: right;">
                                                            {{ $porcentaje }}%
                                                        </span>
                                                    </div>
                                                </td>

                                                <td class="text-center align-middle">

                                                    @if ($telefono)
                                                        <a href="https://wa.me/52{{ $telefono }}?text={{ urlencode($mensaje) }}"
                                                            target="_blank"
                                                            class="btn {{ $btnClass }} rounded-circle"
                                                            title="{{ $tituloBtn }}">

                                                            <i class="bi {{ $icono }}"></i>

                                                        </a>
                                                    @else
                                                    @endif

                                                </td>
                                            </tr>
                                            @php

                                                $totalAprobadas = $evidenciasSubidas->where('estado', 2)->count();
                                                $totalPendientes = $evidenciasSubidas->where('estado', 3)->count();
                                                $totalRechazadas = $evidenciasSubidas->where('estado', 4)->count();

                                                $docente = $materia->asignaciones->first()?->docente;

                                                if ($totalRechazadas > 0) {
                                                    $mensaje = "Hola {$docente?->name}, tienes {$totalRechazadas} evidencia(s) rechazada(s) en {$materia->nombre}. Favor de revisarlas y corregirlas.";
                                                } elseif ($porcentaje == 100) {
                                                    $mensaje = "Hola {$docente?->name}, felicidades. Todas las evidencias de {$materia->nombre} han sido aprobadas correctamente.";
                                                } elseif ($totalPendientes > 0) {
                                                    $mensaje = "Hola {$docente?->name}, actualmente tienes {$totalPendientes} evidencia(s) pendiente(s) de revisión en {$materia->nombre}.";
                                                } else {
                                                    $faltantes = max($totalRevisiones - $evidenciasSubidas->count(), 0);

                                                    $mensaje = "Hola {$docente?->name}, recuerda subir las evidencias faltantes de {$materia->nombre}. Actualmente faltan {$faltantes}.";
                                                }

                                                $telefono = $docente?->telefono ?? '';
                                            @endphp
                                            <td class="text-center">

                                                @if (!empty($telefono))
                                                    <a href="https://wa.me/52{{ preg_replace('/[^0-9]/', '', $telefono) }}?text={{ urlencode($mensaje) }}"
                                                        target="_blank" class="btn btn-success btn-sm rounded-pill">

                                                        <i class="bi bi-whatsapp"></i>

                                                    </a>
                                                @endif

                                            </td>
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
        @include('modules.seguimiento-academico.manual')
    @endsection

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/custom-tables.css') }}">
    @endpush

    @push('scripts')
        @include('modules.seguimiento-academico.scripts')
    @endpush
