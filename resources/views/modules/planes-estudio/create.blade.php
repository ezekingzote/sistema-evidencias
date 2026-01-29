@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Crear Nueva Ponderación</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./evidencias-docente-index.php">Home</a></li>
                    <li class="breadcrumb-item active">Registrar una ponderacion nueva</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">


                        <div class="card-body p-4">
                            <div class="row g-3 mb-4 p-3 rounded-3 bg-light border">
                                <div class="col-md-6">
                                    <label for="material"
                                        class="form-label fw-bold text-secondary small text-uppercase">Materia
                                        Académica</label>
                                    <input type="text" id="materia" name="materia" class="form-control" readonly
                                        value="Programación Web">
                                </div>
                                <div class="col-md-6">
                                    <label for="unidad"
                                        class="form-label fw-bold text-secondary small text-uppercase">Unidad a
                                        Evaluar</label>
                                    <input type="text" id="unidad" name="unidad" class="form-control" readonly
                                        value="Unidad 1">
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-borderless align-middle">
                                    <thead class="table-light">
                                        <tr class="text-secondary small text-uppercase">
                                            <th style="width: 45%;" class="ps-3 py-3">Actividad / Criterio</th>
                                            <th style="width: 15%;" class="text-center py-3">Ponderación (%)</th>
                                            <th style="width: 30%;" class="py-3">Instrumento de Evaluación</th>
                                            <th style="width: 10%;" class="text-center py-3">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyInstrumentacion">
                                        <tr class="border-bottom">
                                            <td class="ps-3">
                                                <input type="text" class="form-control form-control-sm border-0 bg-light"
                                                    value="Exámen">
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm w-75 mx-auto">
                                                    <input type="number"
                                                        class="form-control border-0 bg-light text-center fw-bold"
                                                        value="50">
                                                    <span class="input-group-text border-0 bg-light small">%</span>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm border-0 bg-light"
                                                    value="Rubrica de Exámen">
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-link text-danger p-0" title="Eliminar criterio">
                                                    <i class="bi bi-x-circle-fill fs-5"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="border-bottom">
                                            <td class="ps-3">
                                                <input type="text" class="form-control form-control-sm border-0 bg-light"
                                                    value="Trabajo en Clase">
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm w-75 mx-auto">
                                                    <input type="number"
                                                        class="form-control border-0 bg-light text-center fw-bold"
                                                        value="30">
                                                    <span class="input-group-text border-0 bg-light small">%</span>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm border-0 bg-light"
                                                    value="Rúbrica de tareas">
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-link text-danger p-0" title="Eliminar criterio">
                                                    <i class="bi bi-x-circle-fill fs-5"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-grid d-md-block mt-3">
                                <button class="btn btn-sm btn-outline-primary px-3">
                                    <i class="bi bi-plus-lg me-1"></i> Agregar nuevo criterio
                                </button>
                            </div>
                        </div>

                        <div class="card-footer bg-light border-0 p-4">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <h4 class="mb-0 me-3 fw-bold text-primary">80%</h4>
                                        <div>
                                            <div class="progress" style="width: 150px; height: 8px;">
                                                <div class="progress-bar bg-primary" style="width: 80%"></div>
                                            </div>
                                            <span class="small text-danger fw-semibold mt-1 d-block">
                                                <i class="bi bi-exclamation-triangle-fill me-1"></i> Falta 20% para el total
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                    <a href="{{ route('planes-estudio') }}" class="btn btn-outline-danger me-2">Cancelar</a>
                                    <button type="button" class="btn btn-outline-success px-4 shadow">Guardar
                                        Ponderación</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </main><!-- End #main -->
@endsection
