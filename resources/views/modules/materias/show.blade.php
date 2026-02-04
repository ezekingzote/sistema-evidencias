@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Eliminar Materia</h1>

        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <p>Una vez eliminada la materia no podrá ser recuperada !!!</p>

                            <hr>
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th class="text-center">NOMBRE</th>
                                        <th class="text-center">CLAVE</th>
                                        <th class="text-center">N UNIDADES</th>
                                        <th class="text-center">CARRERA</th>
                                        <th class="text-center">SEMESTRE</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td class="text-center">{{ $items->nombre }}</td>
                                        <td class="text-center">{{ $items->clave }}</td>
                                        <td class="text-center">{{ $items->unidades }}</td>
                                        <td class="text-center">{{ $items->carrera }}</td>
                                        <td class="text-center">{{ $items->semestre }}</td>
                                    </tr>

                                </tbody>
                            </table>

                            <hr>
                            <form action="{{ route('materias.destroy', $items->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger" actio>Eliminar Materia</button>
                                <a href="{{ route('materias') }}" class="btn btn-outline-info">Cancelar</a>
                            </form>
                            
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection
