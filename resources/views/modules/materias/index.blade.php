@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Materias</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Materias</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <a href="{{ route('agregar-materia') }}" class="btn btn-outline-primary"><i class="fa-solid fa-plus"></i> Nueva Materia</a>
        <hr>
        <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <table class="table datatable text-center">
                            <thead>
                                <tr>
                                    <th>NOMBRE</th>
                                    <th>CARRERA</th>
                                    <th>SEMESTRE</th>
                                    <th>CLAVE</th>
                                    <th>N UNIDADES</th>
                                    <th>Activo</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-usuarios">
                                <tr>
                                    <td>Inteligencia Artificial</td>
                                    <td>Ing. Sistemas</td>
                                    <td>9no</td>
                                    <td>IASIS9</td>
                                    <td>5</td>

                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="">
                                        </div>
                                    </td>

                                    <td>
                                        <a href=""
                                            class="btn btn-outline-warning"><i class="fa-solid fa-user-pen"></i></a>
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
