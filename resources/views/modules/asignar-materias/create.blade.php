@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Asignar Un Docente</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Registrar un docente nuevo</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->


        <nav>

        </nav>
        </div><!-- End Page Title -->
          <section class="section">
  <form id="formMateria">
    <div class="row g-3">

      <div class="col-md-12">
        <label class="form-label fw-bold">Materia</label>
        <select class="form-select" required>
          <option selected disabled>Seleccione...</option>
          <option>IA</option>
          <option>POO</option>
          <option>Programación Web</option>
        </select>
      </div>

      <div class="col-md-12">
        <label class="form-label fw-bold">Profesor</label>
        <select class="form-select" required>
          <option selected disabled>Seleccione...</option>
          <option>Roldan</option>
          <option>Federico</option>
          <option>Omar</option>
        </select>
      </div>

      <div class="col-12 mt-4">
          <a href="{{ route('asignar-materias') }}" class="btn btn-outline-info"><i class="fa-solid fa-arrow-left-long"></i>Regresar</a>
        <button type="submit" class="btn btn-outline-success px-4">
          Registrar Materia
        </button>
      </div>

    </div>
  </form>
</section>

    </main>
@endsection
