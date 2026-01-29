@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Docentes</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Docentes</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <a href="{{ route('nuevo-docente') }}" class="btn btn-outline-primary"><i class="fa-solid fa-user-plus"></i> Nuevo Docente</a>
        <hr>
        <section class="section mt-3">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">

                            <table class="table datatable text-center">
                                <thead>
                                    <tr>
                                        <th>NOMBRE(S)</th>
                                        <th>APELLIDO(S)</th>
                                        <th>C. PROFECIONAL</th>
                                        <th>CARRERA</th>
                                        <th>RFC</th>
                                        <th>Cambio password</th>
                                        <th>Activo</th>
                                        <th>Editar</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-usuarios">
                                    <tr>
                                        <td>Roldan</td>
                                        <td>Aquino Segura</td>
                                        <td>BUAS87A8S78</td>
                                        <td>LIC. TURISMO</td>
                                        <td>REOM901252HFG</td>
                                        <td>
                                            <a href="" onclick="agregar_id_usuario()"
                                                class="btn btn-outline-secondary" data-bs-toggle="modal"
                                                data-bs-target="#cambiar_password"><i class="fa-solid fa-user-lock"></i></a>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"">
                                            </div>
                                        </td>

                                        <td>
                                            <a href="" class="btn btn-outline-warning"><i
                                                    class="fa-solid fa-user-pen"></i></a>
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
