@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Crear Nueva Materia</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Registrar una nueva materia</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->


        <nav>

        </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <form action="{{ route('materias.store') }}" id="formMateria" method="POST">
                @csrf
                <div class="row g-3">

                    <div class="col-12">
                        <label class="form-label fw-bold" for="nombre">Nombre de la Materia</label>
                        <input oninput="this.value = this.value.toUpperCase();" name="nombre" id="nombre" type="text"
                            class="form-control" placeholder="Ej. Estructura de Datos" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold" for="clave">Clave Materia</label>
                        <input oninput="this.value = this.value.toUpperCase();" name="clave" id="clave" type="text"
                            class="form-control" placeholder="AED-128" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold" for="unidades">Número de Unidades</label>
                        <input name="unidades" id="unidades" type="number" class="form-control" min="1"
                            max="10" value="1" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold" for="carrera" for="carrera">Carrera correspondiente</label>
                        <select id="carrera" name="carrera" class="form-select" required>
                            <option value="" selected disabled>Seleccione la carrera correspondiente...</option>
                            <option value="INGENIERIA EN SISTEMAS COMPUTACIONALES">INGENIERIA EN SISTEMAS COMPUTACIONALES</option>
                            <option value="INGENIERIA INDUSTRIAL">INGENIERIA INDUSTRIAL</option>
                            <option value="INGENIERIA EN GESTION EMPRESARIAL">INGENIERIA EN GESTION EMPRESARIAL</option>
                            <option value="LICENCIATURA EN TURISMO">LICENCIATURA EN TURISMO</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="semestre" class="form-label fw-bold">Semestre de la asignatura</label>
                        <select id="semestre" name="semestre" class="form-select" required>
                            <option value="" selected disabled>Seleccione el semestre correspondiente ...</option>
                            <option value="1">1er Semstre</option>
                            <option value="2">2do Semstre</option>
                            <option value="3">3er Semstre</option>
                            <option value="4">4to Semstre</option>
                            <option value="5">5to Semstre</option>
                            <option value="6">6to Semstre</option>
                            <option value="7">7mo Semstre</option>
                            <option value="8">8vo Semstre</option>
                            <option value="9">9no Semstre</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-outline-dark px-4">
                            Crear Materia
                        </button>
                        <a href="{{ route('materias') }}" class="btn btn-outline-info">Regresar</a>
                    </div>

                </div>
            </form>
        </section>

    </main>
@endsection
