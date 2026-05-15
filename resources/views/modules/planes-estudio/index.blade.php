@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1 class="fw-bold text-primary">
                Planes de estudio del docente
            </h1>

            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html" class="text-decoration-none text-secondary">
                            Home
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-primary fw-semibold">
                        Ponderaciones
                    </li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row g-4">

                @forelse ($materias as $materia)
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="card border-0 shadow-lg plan-card h-100">
                            <div class="card-body p-4 d-flex flex-column">

                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h4 class="fw-bold text-dark mb-1">
                                            {{ $materia->nombre }}
                                        </h4>
                                        <p class="text-muted mb-0">
                                            Grupo: {{ $materia->pivot->grupo ?? 'Sin asignar' }}
                                        </p>
                                    </div>

                                    <div class="icon-box text-primary">
                                        <i class="bi bi-journal-code fs-3"></i>
                                    </div>
                                </div>

                                <div class="info-box mt-3 mb-4">
                                    <div class="info-item mb-2">
                                        <i class="bi bi-mortarboard-fill text-primary me-2"></i>
                                        <span><strong>Carrera:</strong> {{ $materia->carrera }}</span>
                                    </div>

                                    <div class="info-item mb-2">
                                        <i class="fa-solid fa-user-graduate text-primary me-2"></i>
                                        <span><strong>Alumnos:</strong> {{ $materia->pivot->alumnos }}</span>
                                    </div>

                                    <div class="info-item mb-2">
                                        <i class="bi bi-calendar-event-fill text-primary me-2"></i>
                                        <span><strong>Semestre:</strong> {{ $materia->semestre }}° Semestre</span>
                                    </div>
                                </div>

                                <div class="mt-auto pt-2">
                                    <div class="dropdown">
                                        <button class="btn btn-primary w-100 rounded-pill py-2 fw-semibold dropdown-toggle"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-bar-chart-line-fill me-2"></i>
                                            Plan por Unidad
                                        </button>

                                        <ul class="dropdown-menu w-100 shadow border-0 rounded-4 text-center">
                                            @for ($i = 1; $i <= $materia->unidades; $i++)
                                                <li>
                                                    <a class="dropdown-item py-2"
                                                        href="{{ route('agregar-plan-estudio', ['materia_id' => $materia->id, 'unidad' => $i]) }}">
                                                        Unidad {{ $i }}
                                                    </a>
                                                </li>
                                            @endfor
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Mensaje en caso de que el docente no tenga materias asignadas --}}
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-journal-x display-1 text-muted mb-3 d-block"></i>
                        <h4 class="text-muted">Aún no tienes materias asignadas</h4>
                        <p class="text-muted">Tus planes de estudio aparecerán aquí cuando el administrador te asigne una
                            materia.</p>
                    </div>
                @endforelse

            </div>
        </section>

    </main>


    <style>
        .plan-card {
            border-radius: 22px;
            overflow: hidden;
            background: #ffffff;
            transition: 0.3s;
        }

        .plan-card:hover {
            transform: translateY(-6px);
        }

        .icon-box {
            width: 58px;
            height: 58px;
            border-radius: 16px;
            background: linear-gradient(135deg, #0d6efd, #4da3ff);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.18);
        }

        .icon-box.green {
            background: linear-gradient(135deg, #198754, #3ccf7a);
        }

        .icon-box.purple {
            background: linear-gradient(135deg, #6f42c1, #9b6bff);
        }

        .info-box {
            background: #f8fbff;
            border: 1px solid #e9f0fa;
            border-radius: 16px;
            padding: 20px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
            font-size: 14px;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .text-purple {
            color: #6f42c1;
        }

        .dropdown-menu .dropdown-item:hover {
            background: #f5f9ff;
        }

        .btn {
            transition: 0.25s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }
    </style>

@endsection
