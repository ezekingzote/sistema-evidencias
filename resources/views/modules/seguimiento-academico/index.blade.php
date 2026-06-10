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
                                            <button
                                                type="button"
                                                class="estadoBtn vacio btn-rechazar-sin-evidencia"
                                                data-asignacion="{{ $materia->asignacion_id }}"
                                                data-materia="{{ $materia->id }}"
                                                data-revision="{{ $revision->id }}"
                                                title="Sin evidencia">

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
                                                    <div class="progress-bar {{ $colorBarra }}" role="progressbar"
                                                        style="width: {{ $porcentaje }}%;"
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

<script>
    document.querySelectorAll('.btn-rechazar-sin-evidencia').forEach(btn => {
        btn.addEventListener('click', async function() {
            const asignacionId = this.dataset.asignacion;
            const materiaId = this.dataset.materia;
            const revisionId = this.dataset.revision;

            const {
                value: datos
            } = await Swal.fire({
                title: 'Rechazar evidencia',
                text: 'El docente no ha adjuntado ninguna evidencia. A continuación, registra la evaluación de seguimiento:',
                width: 900,
                showCancelButton: true,
                confirmButtonText: 'Rechazar y guardar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                background: '#f8f9fa',
                customClass: {
                    popup: 'rounded-4 shadow-lg',
                    title: 'fw-bold text-danger',
                    confirmButton: 'btn btn-danger rounded-pill px-4',
                    cancelButton: 'btn btn-outline-secondary rounded-pill px-4'
                },
                html: `
                    <style>
                        .fachero-card {
                            background: white;
                            border-radius: 20px;
                            padding: 1.25rem;
                            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
                            transition: transform 0.2s;
                            margin-bottom: 1rem;
                        }
                        .fachero-card:hover {
                            transform: translateY(-2px);
                        }
                        .fachero-input {
                            border-radius: 12px !important;
                            border: 1px solid #e2e8f0;
                            padding: 0.6rem 1rem;
                            width: 100%;
                            transition: all 0.2s;
                        }
                        .fachero-input:focus {
                            border-color: #0d6efd;
                            box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
                            outline: none;
                        }
                        .fachero-textarea {
                            border-radius: 12px !important;
                            border: 1px solid #e2e8f0;
                            padding: 0.6rem 1rem;
                            width: 100%;
                            resize: vertical;
                        }
                        .switch {
                            position: relative;
                            display: inline-block;
                            width: 52px;
                            height: 26px;
                        }
                        .switch input {
                            opacity: 0;
                            width: 0;
                            height: 0;
                        }
                        .slider {
                            position: absolute;
                            cursor: pointer;
                            top: 0;
                            left: 0;
                            right: 0;
                            bottom: 0;
                            background-color: #cbd5e1;
                            transition: 0.3s;
                            border-radius: 34px;
                        }
                        .slider:before {
                            position: absolute;
                            content: "";
                            height: 20px;
                            width: 20px;
                            left: 3px;
                            bottom: 3px;
                            background-color: white;
                            transition: 0.3s;
                            border-radius: 50%;
                        }
                        input:checked + .slider {
                            background-color: #0d6efd;
                        }
                        input:checked + .slider:before {
                            transform: translateX(26px);
                        }
                        .label-na {
                            display: flex;
                            align-items: center;
                            gap: 12px;
                            margin-top: 12px;
                            font-weight: 500;
                            color: #334155;
                        }
                        .badge-fachero {
                            background: #eef2ff;
                            color: #1e40af;
                            font-size: 0.7rem;
                            border-radius: 30px;
                            padding: 4px 8px;
                        }
                        .row-fachero {
                            display: flex;
                            gap: 1.5rem;
                            flex-wrap: wrap;
                        }
                        .col-fachero {
                            flex: 1;
                            min-width: 250px;
                        }
                        hr {
                            margin: 0.5rem 0 1rem;
                            opacity: 0.3;
                        }
                    </style>
                    <div class="row-fachero">
                        <div class="col-fachero">
                            <div class="fachero-card">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold mb-0">
                                        <i class="bi bi-graph-up"></i> Avance programático
                                    </h5>
                                    <span class="badge-fachero">Obligatorio</span>
                                </div>
                                <hr>
                                <label class="fw-semibold mb-1">Calificación (0-100)</label>
                                <input type="number" id="avance_calificacion" class="fachero-input mb-3" placeholder="Ej: 85" min="0" max="100">
                                <label class="fw-semibold mb-1">Observaciones</label>
                                <textarea id="avance_observaciones" class="fachero-textarea" rows="2" placeholder="Comentarios sobre el avance..."></textarea>
                                <label class="label-na">
                                    <span class="fw-semibold">No aplica (N/A)</span>
                                    <label class="switch">
                                        <input type="checkbox" id="avance_na">
                                        <span class="slider"></span>
                                    </label>
                                </label>
                            </div>
                        </div>
                        <div class="col-fachero">
                            <div class="fachero-card">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold mb-0">
                                        <i class="bi bi-person-check"></i> Asiste al seguimiento
                                    </h5>
                                    <span class="badge-fachero">Obligatorio</span>
                                </div>
                                <hr>
                                <label class="fw-semibold mb-1">Calificación (0-100)</label>
                                <input type="number" id="seguimiento_calificacion" class="fachero-input mb-3" placeholder="Ej: 90" min="0" max="100">
                                <label class="fw-semibold mb-1">Observaciones</label>
                                <textarea id="seguimiento_observaciones" class="fachero-textarea" rows="2" placeholder="Comentarios sobre asistencia..."></textarea>
                                <label class="label-na">
                                    <span class="fw-semibold">No aplica (N/A)</span>
                                    <label class="switch">
                                        <input type="checkbox" id="seguimiento_na">
                                        <span class="slider"></span>
                                    </label>
                                </label>
                            </div>
                        </div>
                    </div>
                `,
                didOpen: () => {
                    const avanceNa = document.getElementById('avance_na');
                    const avanceCalif = document.getElementById('avance_calificacion');
                    const seguimientoNa = document.getElementById('seguimiento_na');
                    const seguimientoCalif = document.getElementById('seguimiento_calificacion');

                    const toggleAvance = () => {
                        if (avanceNa.checked) {
                            avanceCalif.disabled = true;
                            avanceCalif.value = '';
                            avanceCalif.classList.add('bg-light', 'opacity-50');
                        } else {
                            avanceCalif.disabled = false;
                            avanceCalif.classList.remove('bg-light', 'opacity-50');
                        }
                    };
                    const toggleSeguimiento = () => {
                        if (seguimientoNa.checked) {
                            seguimientoCalif.disabled = true;
                            seguimientoCalif.value = '';
                            seguimientoCalif.classList.add('bg-light', 'opacity-50');
                        } else {
                            seguimientoCalif.disabled = false;
                            seguimientoCalif.classList.remove('bg-light', 'opacity-50');
                        }
                    };
                    avanceNa.addEventListener('change', toggleAvance);
                    seguimientoNa.addEventListener('change', toggleSeguimiento);
                    toggleAvance();
                    toggleSeguimiento();
                },
                preConfirm: () => {
                    const avanceCalif = document.getElementById('avance_calificacion');
                    const seguimientoCalif = document.getElementById('seguimiento_calificacion');
                    return {
                        avance_programatico: {
                            calificacion: avanceCalif.disabled ? '' : avanceCalif.value,
                            observaciones: document.getElementById('avance_observaciones').value,
                            na: document.getElementById('avance_na').checked ? 1 : 0
                        },
                        asiste_seguimiento: {
                            calificacion: seguimientoCalif.disabled ? '' : seguimientoCalif.value,
                            observaciones: document.getElementById('seguimiento_observaciones').value,
                            na: document.getElementById('seguimiento_na').checked ? 1 : 0
                        }
                    };
                }
            });

            if (!datos) return;

            // Enviar al backend
            fetch("{{ route('evaluaciones.rechazarSinEvidencia') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        asignacion_materia_id: asignacionId,
                        materia_id: materiaId,
                        revision_id: revisionId,
                        evaluaciones: {
                            avance_programatico: datos.avance_programatico,
                            asiste_seguimiento: datos.asiste_seguimiento
                        }
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Evidencia rechazada',
                            text: 'La revisión fue rechazada y la evaluación de seguimiento se ha guardado.'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message || 'Ocurrió un error al guardar.', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'No se pudo completar la operación.', 'error');
                    console.error(error);
                });
        });
    });
</script>

@endsection