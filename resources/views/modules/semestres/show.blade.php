@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Eliminar Semestre</h1>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                ¿Estás seguro de eliminar este semestre?
                            </h5>

                            <table class="table datatable text-center">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Año</th>
                                        <th class="text-center">Periodo</th>
                                        <th class="text-center">Materias</th>
                                        <th class="text-center">Activo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">{{ $item->nombre }}</td>
                                        <td class="text-center">{{ $item->anio }}</td>
                                        <td class="text-center">{{ $item->periodo }}</td>
                                        <td class="text-center">
                                            @if ($item->materias->count())
                                                <ul class="list-unstyled mb-0">
                                                    @foreach ($item->materias as $materia)
                                                        <li>{{ $materia->nombre }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="text-muted">Sin materias</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="form-check form-switch d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox"
                                                    {{ $item->activo ? 'checked' : '' }} disabled>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <hr>

                            <form action="{{ route('semestres.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-outline-danger" {{ $item->activo ? 'disabled' : '' }}>
                                    Eliminar Semestre
                                </button>

                                <a href="{{ route('semestres') }}" class="btn btn-outline-info">
                                    Cancelar
                                </a>
                            </form>


                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection
