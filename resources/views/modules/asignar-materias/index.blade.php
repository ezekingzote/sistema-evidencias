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
        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('asignar-una-materia') }}" class="btn btn-outline-primary mt-3">
                                <i class="fa-solid fa-user-plus"></i>
                                Asignar Profesor
                            </a>

                            <hr>

                            <table class="table datatable align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-center">ASIGNATURA</th>
                                        <th class="text-center">PROFESOR</th>
                                        <th class="text-center">SEMESTRE</th>
                                        <th class="text-center">CARRERA</th>
                                        <th class="text-center">ACTIVO</th>
                                        <th class="text-center">EDITAR</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-usuarios">
                                    <tr>
                                        <td class="text-center">Inteligencia Artificial</td>
                                        <td class="text-center">ROLDAN</td>
                                        <td class="text-center">9no</td>
                                        <td class="text-center">ING SIS</td>

                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="switch1">
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="#" class="btn btn-outline-warning">
                                                    <i class="fa-solid fa-user-pen"></i>
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
        </section>
    </main>
@endsection
