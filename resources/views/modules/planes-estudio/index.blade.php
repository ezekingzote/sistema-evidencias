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

            {{-- CARD 1 --}}
            <div class="col-12 col-md-6 col-xl-4">

                <div class="card border-0 shadow-lg plan-card h-100">

                    <div class="card-body p-4 d-flex flex-column">

                        <div class="d-flex justify-content-between align-items-start mb-3">

                            <div>
                                <h4 class="fw-bold text-dark mb-1">
                                    Programación Web
                                </h4>

                                <p class="text-muted mb-0">
                                    Grupo: 5 SIS
                                </p>
                            </div>

                            <div class="icon-box">
                                <i class="bi bi-journal-code"></i>
                            </div>

                        </div>

                        <div class="info-box">

                            <div class="info-item">
                                <i class="bi bi-mortarboard-fill text-primary"></i>
                                <span><strong>Carrera:</strong> Ing. en Sistemas</span>
                            </div>

                            <div class="info-item">
                                <i class="bi bi-clock-fill text-primary"></i>
                                <span><strong>Horario:</strong> Lun - Mié 10:00 - 12:00</span>
                            </div>

                            <div class="info-item">
                                <i class="bi bi-calendar-event-fill text-primary"></i>
                                <span><strong>Periodo:</strong> Ene - Jun 2026</span>
                            </div>

                        </div>

                        <div class="mt-auto pt-4">

                            <div class="dropdown">

                                <button
                                    class="btn btn-primary w-100 rounded-pill py-2 fw-semibold dropdown-toggle"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">

                                    <i class="bi bi-bar-chart-line-fill me-2"></i>
                                    Plan por Unidad
                                </button>

                                <ul class="dropdown-menu w-100 shadow border-0 rounded-4 text-center">

                                    <li>
                                        <a class="dropdown-item py-2"
                                           href="{{ route('agregar-plan-estudio') }}">
                                            Unidad 1
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item py-2" href="#">
                                            Unidad 2
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item py-2" href="#">
                                            Unidad 3
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item py-2" href="#">
                                            Unidad 4
                                        </a>
                                    </li>

                                </ul>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- CARD 2 --}}
            <div class="col-12 col-md-6 col-xl-4">

                <div class="card border-0 shadow-lg plan-card h-100">

                    <div class="card-body p-4 d-flex flex-column">

                        <div class="d-flex justify-content-between align-items-start mb-3">

                            <div>
                                <h4 class="fw-bold text-dark mb-1">
                                    Base de Datos
                                </h4>

                                <p class="text-muted mb-0">
                                    Grupo: 4 SIS
                                </p>
                            </div>

                            <div class="icon-box green">
                                <i class="bi bi-database-fill"></i>
                            </div>

                        </div>

                        <div class="info-box">

                            <div class="info-item">
                                <i class="bi bi-mortarboard-fill text-success"></i>
                                <span><strong>Carrera:</strong> Ing. en Sistemas</span>
                            </div>

                            <div class="info-item">
                                <i class="bi bi-clock-fill text-success"></i>
                                <span><strong>Horario:</strong> Mar - Jue 08:00 - 10:00</span>
                            </div>

                            <div class="info-item">
                                <i class="bi bi-calendar-event-fill text-success"></i>
                                <span><strong>Periodo:</strong> Ene - Jun 2026</span>
                            </div>

                        </div>

                        <div class="mt-auto pt-4">

                            <button
                                class="btn btn-outline-success w-100 rounded-pill py-2 fw-semibold">

                                <i class="bi bi-folder-check me-2"></i>
                                Administrar Plan
                            </button>

                        </div>

                    </div>

                </div>

            </div>


            {{-- CARD 3 --}}
            <div class="col-12 col-md-6 col-xl-4">

                <div class="card border-0 shadow-lg plan-card h-100">

                    <div class="card-body p-4 d-flex flex-column">

                        <div class="d-flex justify-content-between align-items-start mb-3">

                            <div>
                                <h4 class="fw-bold text-dark mb-1">
                                    Inteligencia Artificial
                                </h4>

                                <p class="text-muted mb-0">
                                    Grupo: 9 SIS
                                </p>
                            </div>

                            <div class="icon-box purple">
                                <i class="bi bi-cpu-fill"></i>
                            </div>

                        </div>

                        <div class="info-box">

                            <div class="info-item">
                                <i class="bi bi-mortarboard-fill text-purple"></i>
                                <span><strong>Carrera:</strong> Ing. en Sistemas</span>
                            </div>

                            <div class="info-item">
                                <i class="bi bi-clock-fill text-purple"></i>
                                <span><strong>Horario:</strong> Vie 12:00 - 15:00</span>
                            </div>

                            <div class="info-item">
                                <i class="bi bi-calendar-event-fill text-purple"></i>
                                <span><strong>Periodo:</strong> Ene - Jun 2026</span>
                            </div>

                        </div>

                        <div class="mt-auto pt-4">

                            <button
                                class="btn btn-outline-primary w-100 rounded-pill py-2 fw-semibold">

                                <i class="bi bi-eye me-2"></i>
                                Revisar Unidades
                            </button>

                        </div>

                    </div>

                </div>

            </div>

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