@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Evidencias de Docentes</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Mis Evidencias</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <a href="./evidencias-docente-create.php" class="btn btn-outline-dark"><i class="fa-solid fa-circle-plus"></i> Subir nueva evidencia</a>
  <hr>
  <div class="row">
    <div class="col-lg-12">
      <div class="card p-4">
        <div class="table-responsive">
          <table id="miTabla" class="table table-hover align-middle w-100">
            <thead class="table-light">
              <tr>
                <th>Unidad</th>
                <th>Evidencia</th>
                <th>Materia</th>
                <th>Estatus</th>
                <th class="text-center">Ver</th>
                <th class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>U1</td>
                <td>Tareas (Alumnos)</td>
                <td>Backend</td>
                <td><span class="badge bg-success">Aprobado</span></td>
                <td class="text-center"><button class="btn btn-sm btn-outline-primary"><i
                      class="bi bi-eye"></i></button></td>
                <td class="text-center">Ninguna disponible
                </td>
              </tr>
              <tr>
                <td>U1</td>
                <td>Examen (Alumno)</td>
                <td>Backend</td>
                <td><span class="badge bg-danger">Correcciones</span></td>
                <td class="text-center"><button class="btn btn-sm btn-outline-primary"><i
                      class="bi bi-eye"></i></button></td>
                <td class="text-center"><button class="btn btn-sm btn-outline-warning"><i class="fa-solid fa-pen-to-square"></i></button>
                  <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></button>
                </td>
              </tr>
              <tr>
                <td>U1</td>
                <td>Examen (Docente)</td>
                <td>Backend</td>
                <td><span class="badge bg-warning">Por revisar</span></td>
                <td class="text-center"><button class="btn btn-sm btn-outline-primary"><i
                      class="bi bi-eye"></i></button></td>
                <td class="text-center"><button class="btn btn-sm btn-outline-warning"><i class="fa-solid fa-pen-to-square"></i></button>
                  <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


</main>
@endsection
