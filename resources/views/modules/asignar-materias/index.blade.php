@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Asignar Materias</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Asignar Materias</li>
                </ol>
            </nav>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('asignar-materias.create') }}" class="btn btn-outline-primary shadow-sm">
                <i class="fa-solid fa-plus me-1"></i>
                Asignar Profesor
            </a>
        </div>

        <section class="section mt-2">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card mt-2">
                        <div class="card-body">

                            <div class="card-header bg-white py-3 border-0">
                                <div class="d-flex align-items-center">
                                    <div class="p-2 bg-primary-light rounded-3 me-3">
                                        <i class="bi bi-person-check-fill text-primary fs-4"></i>
                                    </div>
                                    <h5 class="card-title mb-0 p-0">
                                        Relación Materia - Profesor
                                    </h5>
                                </div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table class="table table-hover align-middle text-center datatable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">ASIGNATURA</th>
                                            <th class="text-center">PROFESOR</th>
                                            <th class="text-center">SEMESTRE</th>
                                            <th class="text-center">CARRERA</th>
                                            <th class="text-center">ACTIVO</th>
                                            <th class="text-center">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-asignaciones">

                                        <tr>
                                            <td class="text-center">Inteligencia Artificial</td>
                                            <td class="text-center">ROLDAN</td>
                                            <td class="text-center">9no</td>
                                            <td class="text-center">ING SIS</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="switch1" checked>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="#" class="btn btn-outline-warning shadow-sm">
                                                        <i class="fa-solid fa-user-pen"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-outline-danger shadow-sm">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
@endsection
