@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">
        <section class="section">

            <div class="pagetitle">
                <h1>Evidencias de Docentes</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Administrar las evidencias de los docentes</li>
                    </ol>
                </nav>
            </div>

            <hr>

            <!-- Filtros -->
            <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">

                <!-- Botones -->
                <div class="d-flex gap-2">
                    <button class="btn btn-success filterBtn" data-status="aprobada">
                        <i class="fa-solid fa-check"></i> Aprobadas
                    </button>
                    <button class="btn btn-warning filterBtn" data-status="pendiente">
                        <i class="fa-solid fa-clock"></i> Pendientes
                    </button>
                    <button class="btn btn-danger filterBtn" data-status="rechazada">
                        <i class="fa-solid fa-xmark"></i> Rechazadas
                    </button>
                    <button class="btn btn-secondary filterBtn" data-status="">
                        <i class="fa-solid fa-list"></i> Todas
                    </button>
                </div>

                <!-- Search -->
                <div>
                    <input type="search" id="customSearch" class="form-control" placeholder="Buscar evidencia...">
                </div>

            </div>



            <div class="row">
                <div class="col-lg-12">
                    <div class="card p-4">
                        <div class="table-responsive">
                            <table id="miTabla" class="table table-hover align-middle w-100 text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>Docente</th>
                                        <th>Materia</th>
                                        <th>Unidad</th>
                                        <th>Fecha</th>
                                        <th>Status</th>
                                        <th class="d-none">Estado</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Ing. Federico</td>
                                        <td>IA</td>
                                        <td>U2</td>
                                        <td>hace 5 minutos</td>
                                        <td><span class="badge bg-danger">Revisada y rechazada</span></td>
                                        <td class="d-none">rechazada</td>
                                        <td>
                                            <a href="{{ route('review-evidencia') }}" class="btn btn-outline-primary">
                                                <i class="fa-regular fa-eye"></i> Revisar
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Ing. Roldan Aquino</td>
                                        <td>Backend</td>
                                        <td>U1</td>
                                        <td>hace 1 hora</td>
                                        <td><span class="badge bg-success">Revisada y aprobada</span></td>
                                        <td class="d-none">aprobada</td>
                                        <td>
                                            <a href="{{ route('review-evidencia') }}" class="btn btn-outline-primary">
                                                <i class="fa-regular fa-eye"></i> Revisar
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Ing. Roldan Aquino</td>
                                        <td>IA</td>
                                        <td>U2</td>
                                        <td>hace 21 horas</td>
                                        <td><span class="badge bg-warning text-dark">Pendiente por revisar</span></td>
                                        <td class="d-none">pendiente</td>
                                        <td>
                                            <a href="{{ route('review-evidencia') }}" class="btn btn-outline-primary">
                                                <i class="fa-regular fa-eye"></i> Revisar
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
