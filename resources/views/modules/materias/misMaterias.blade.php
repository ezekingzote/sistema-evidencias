@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')<main id="main" class="main">

        <div class="pagetitle">
            <h1>Evidencias de Docentes</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Administrar mis Materias</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <hr>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body pt-3">
                            <table class="table datatable text-center align-middle">
                                <thead>
                                    <tr>
                                        <th>NOMBRE</th>
                                        <th>CARRERA</th>
                                        <th>SEMESTRE</th>
                                        <th>CLAVE</th>
                                        <th>N UNIDADES</th>
                                        <th>Evidencias entregadas</th>
                                        <th>Ver Evidencias</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Inteligencia Artificial</td>
                                        <td>Ing. Sistemas</td>
                                        <td>9no</td>
                                        <td>IASIS9</td>
                                        <td>5</td>
                                        <td>2 / 5</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#modalVerEvidencias">
                                                <i class="bi bi-eye"></i>
                                            </button>
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
