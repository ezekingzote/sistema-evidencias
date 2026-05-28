@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="fw-bold text-primary">Reportes Académicos</h1>
    </div>

    <section class="section">

        <div class="card border-0 shadow-lg">

            <div class="card-header">
                <h4 class="mb-0 fw-bold">Seguimiento de Evidencias</h4>
                <small class="text-muted">Exporta por revisión directamente</small>
            </div>

            <div class="card-body table-responsive">

                <table class="table table-hover text-center align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>Docente</th>
                            <th>Asignatura</th>

                            {{-- BOTONES POR REVISIÓN --}}
                            @for($i = 1; $i <= 4; $i++)
                                <th>
                                    Revisión {{ $i }} <br>

                                    {{-- EXPORTAR SOLO ESA REVISIÓN --}}
                                    <a href="{{ route('reportes-pdf', ['revision_id' => $i]) }}"
                                       class="btn btn-sm btn-danger mt-1">
                                        PDF
                                    </a>
                                </th>
                            @endfor

                        </tr>
                    </thead>

                    <tbody>

                        @foreach($asignaciones as $asignacion)

                            <tr>

                                <td class="fw-bold">
                                    {{ $asignacion->docente->name ?? 'Sin Asignar' }}
                                </td>

                                <td>
                                    {{ $asignacion->materia->nombre ?? 'Sin Materia' }}
                                </td>

                                @for($i = 1; $i <= 4; $i++)

                                    @php
                                        $ev = $asignacion->evidencias
                                            ->where('revision_id', $i)
                                            ->first();
                                    @endphp

                                    <td>
                                        {{ $ev->calificacion ?? 0 }}
                                    </td>

                                @endfor

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </section>

</main>

@endsection