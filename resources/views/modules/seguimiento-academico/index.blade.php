@extends('layouts.main')

@section('titulo', 'Seguimiento Académico')

@section('contenido')

<main id="main" class="main">

    <div class="pagetitle mb-4">

        <h1>Seguimiento Académico</h1>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>

                <li class="breadcrumb-item active">
                    Seguimiento Académico
                </li>
            </ol>
        </nav>

    </div>

    <section class="section">

        <div class="card border-0 shadow-lg overflow-hidden mb-4 seguimientoHeader">

            <div class="card-body p-4">

                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">

                    <div>

                        <h2 class="fw-bold text-white mb-2">
                            Panel de Seguimiento
                        </h2>

                        <p class="text-light opacity-75 mb-0">
                            Monitoreo inteligente de revisiones académicas y entregas docentes.
                        </p>

                    </div>

                    <div class="mt-4 mt-lg-0 d-flex flex-wrap gap-3">

                        <div class="miniStat">
                            <h3>25</h3>
                            <span>Aprobadas</span>
                        </div>

                        <div class="miniStat">
                            <h3>8</h3>
                            <span>Pendientes</span>
                        </div>

                        <div class="miniStat">
                            <h3>3</h3>
                            <span>Demoradas</span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="card border-0 shadow-lg seguimientoCard">

            <div class="card-header bg-white border-0 py-4 px-4">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>

                        <h4 class="fw-bold mb-1">
                            Estado General de Revisiones
                        </h4>

                        <p class="text-muted mb-0">
                            Seguimiento visual del desempeño académico.
                        </p>

                    </div>

                    <button class="btn btn-dark rounded-pill px-4 shadow-sm">

                        <i class="bi bi-download me-2"></i>
                        Exportar Reporte

                    </button>

                </div>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead>

                            <tr>

                                <th class="ps-4 py-4">
                                    Docente
                                </th>

                                <th class="py-4">
                                    Asignatura
                                </th>

                                <th class="py-4 text-center">
                                    Evidencias
                                </th>

                                <th class="py-4 text-center">
                                    Rendimiento
                                </th>

                                <th class="py-4 text-center">
                                    Acción
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <tr>

                                <td class="ps-4 py-4">

                                    <div class="d-flex align-items-center">

                                        <div class="avatarDocente bg-primary-gradient">
                                            JP
                                        </div>

                                        <div>

                                            <h6 class="mb-0 fw-bold">
                                                Juan Pérez
                                            </h6>

                                            <small class="text-muted">
                                                Ingeniería en Sistemas
                                            </small>

                                        </div>

                                    </div>

                                </td>

                                <td>

                                    <span class="fw-semibold">
                                        Base de Datos
                                    </span>

                                </td>

                                <td>

                                    <div class="d-flex justify-content-center gap-3 flex-wrap">

                                        <div class="estadoWrap">

                                            <button class="estadoBtn bg-secondary-custom">

                                                <i class="bi bi-person-x-fill"></i>

                                            </button>

                                            <span class="estadoBadge">
                                                1
                                            </span>

                                        </div>

                                        <div class="estadoWrap">

                                            <button class="estadoBtn bg-warning-custom">

                                                <i class="bi bi-clock-history"></i>

                                            </button>

                                            <span class="estadoBadge">
                                                4
                                            </span>

                                        </div>

                                        <div class="estadoWrap">

                                            <button class="estadoBtn bg-success-custom">

                                                <i class="bi bi-check-circle-fill"></i>

                                            </button>

                                            <span class="estadoBadge">
                                                12
                                            </span>

                                        </div>

                                        <div class="estadoWrap">

                                            <button class="estadoBtn bg-danger-custom">

                                                <i class="bi bi-exclamation-triangle-fill"></i>

                                            </button>

                                            <span class="estadoBadge">
                                                2
                                            </span>

                                        </div>

                                    </div>

                                </td>

                                <td class="text-center">

                                    <span class="estadoTexto success">

                                        Excelente

                                    </span>

                                </td>

                                <td class="text-center">

                                    <button class="btn btn-success rounded-pill px-4 shadow-sm">

                                        <i class="bi bi-whatsapp me-2"></i>
                                        Recordar

                                    </button>

                                </td>

                            </tr>

                            <tr>

                                <td class="ps-4 py-4">

                                    <div class="d-flex align-items-center">

                                        <div class="avatarDocente bg-danger-gradient">
                                            MG
                                        </div>

                                        <div>

                                            <h6 class="mb-0 fw-bold">
                                                María González
                                            </h6>

                                            <small class="text-muted">
                                                Ingeniería en Sistemas
                                            </small>

                                        </div>

                                    </div>

                                </td>

                                <td>

                                    <span class="fw-semibold">
                                        Programación Web
                                    </span>

                                </td>

                                <td>

                                    <div class="d-flex justify-content-center gap-3 flex-wrap">

                                        <div class="estadoWrap">

                                            <button class="estadoBtn bg-secondary-custom">

                                                <i class="bi bi-person-x-fill"></i>

                                            </button>

                                            <span class="estadoBadge">
                                                0
                                            </span>

                                        </div>

                                        <div class="estadoWrap">

                                            <button class="estadoBtn bg-warning-custom">

                                                <i class="bi bi-clock-history"></i>

                                            </button>

                                            <span class="estadoBadge">
                                                8
                                            </span>

                                        </div>

                                        <div class="estadoWrap">

                                            <button class="estadoBtn bg-success-custom">

                                                <i class="bi bi-check-circle-fill"></i>

                                            </button>

                                            <span class="estadoBadge">
                                                5
                                            </span>

                                        </div>

                                        <div class="estadoWrap">

                                            <button class="estadoBtn bg-danger-custom">

                                                <i class="bi bi-exclamation-triangle-fill"></i>

                                            </button>

                                            <span class="estadoBadge">
                                                6
                                            </span>

                                        </div>

                                    </div>

                                </td>

                                <td class="text-center">

                                    <span class="estadoTexto danger">

                                        Atención requerida

                                    </span>

                                </td>

                                <td class="text-center">

                                    <button class="btn btn-danger rounded-pill px-4 shadow-sm">

                                        <i class="bi bi-bell-fill me-2"></i>
                                        Urgente

                                    </button>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </section>

</main>

<style>

    .seguimientoHeader {

        border-radius: 24px;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);

    }

    .miniStat {

        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(10px);
        border-radius: 18px;
        padding: 16px 28px;
        text-align: center;

    }

    .miniStat h3 {

        color: white;
        font-weight: 800;
        margin-bottom: 2px;

    }

    .miniStat span {

        color: rgba(255,255,255,0.7);
        font-size: 13px;

    }

    .seguimientoCard {

        border-radius: 24px;
        overflow: hidden;

    }

    .table thead tr {

        background: #0f172a;

    }

    .table thead th {

        border: none;
        font-size: 14px;
        font-weight: 600;

    }

    .table tbody tr {

        transition: 0.3s ease;

    }

    .table tbody tr:hover {

        background: rgba(15, 23, 42, 0.03);

    }

    .avatarDocente {

        width: 58px;
        height: 58px;
        border-radius: 50%;
        margin-right: 16px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-weight: 700;
        font-size: 18px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);

    }

    .bg-primary-gradient {

        background: linear-gradient(135deg, #2563eb, #1d4ed8);

    }

    .bg-danger-gradient {

        background: linear-gradient(135deg, #ef4444, #b91c1c);

    }

    .estadoWrap {

        position: relative;

    }

    .estadoBtn {

        width: 55px;
        height: 55px;
        border-radius: 50%;
        border: none;
        color: white;
        font-size: 20px;
        box-shadow: 0 8px 18px rgba(0,0,0,0.12);
        transition: 0.3s ease;

    }

    .estadoBtn:hover {

        transform: translateY(-4px) scale(1.05);

    }

    .bg-secondary-custom {

        background: linear-gradient(135deg, #6b7280, #4b5563);

    }

    .bg-warning-custom {

        background: linear-gradient(135deg, #f59e0b, #d97706);

    }

    .bg-success-custom {

        background: linear-gradient(135deg, #10b981, #059669);

    }

    .bg-danger-custom {

        background: linear-gradient(135deg, #ef4444, #dc2626);

    }

    .estadoBadge {

        position: absolute;
        top: -6px;
        right: -6px;
        width: 24px;
        height: 24px;
        background: #111827;
        border-radius: 50%;
        color: white;
        font-size: 11px;
        font-weight: 700;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 2px solid white;

    }

    .estadoTexto {

        padding: 10px 18px;
        border-radius: 999px;
        font-weight: 600;
        font-size: 13px;

    }

    .estadoTexto.success {

        background: rgba(16,185,129,.12);
        color: #059669;

    }

    .estadoTexto.danger {

        background: rgba(239,68,68,.12);
        color: #dc2626;

    }

    .btn {

        transition: .3s ease;

    }

    .btn:hover {

        transform: translateY(-2px);

    }

</style>

@endsection