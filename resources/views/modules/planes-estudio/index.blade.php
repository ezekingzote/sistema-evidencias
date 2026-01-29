@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Planes de estudio del docentes</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Ponderaciones</li>
                </ol>
            </nav>
        </div>
        <hr>
        <section class="section">
            <div class="row g-4">

                <!-- Card Materia -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-1">Programación Web</h5>
                            <p class="text-muted mb-2">Grupo: 5 SIS</p>

                            <ul class="list-unstyled small mb-3">
                                <li><strong>Carrera:</strong> Ing. en Sistemas</li>
                                <li><strong>Horario:</strong> Lun - Mié 10:00 - 12:00</li>
                                <li><strong>Periodo:</strong> Ene - Jun 2026</li>
                            </ul>

                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button"
                                    class="btn btn-outline-primary dropdown-toggle mt-3" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="bi bi-bar-chart"></i> Plan por Unidad
                                </button>
                                <ul class="dropdown-menu w-100 text-center" aria-labelledby="btnGroupDrop1">
                                    <li><a class="dropdown-item" href="{{ route('agregar-plan-estudio') }}">Unidad 1</a></li>
                                </ul>

                            </div>

                        </div>
                    </div>
                </div>
            </div>


            </div>
        </section>


    </main><!-- End #main -->

@endsection
