<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 12px;
            color: #000;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 11px;
        }

        .firma {
            margin-top: 80px;
            text-align: center;
        }
    </style>

</head>

<body>

    <div class="center">

        <h2>
            Instituto Tecnológico de Milpa Alta II
        </h2>

        <h4>
            Departamento de
            {{ $admin->departamento }}
        </h4>

    </div>

    <div class="right">

        Ciudad de México,
        {{ now()->format('d/m/Y') }}

    </div>

    <br>

    <b>
        Asunto:
    </b>

    Reporte de seguimiento

    <br><br>

    <b>
        {{ $evidencia->asignacion->docente->name }}
    </b>

    <br>

    DOCENTE DEL INSTITUTO TECNOLÓGICO DE MILPA ALTA II

    <br><br>

    PRESENTE

    <br><br>

    Con base al procedimiento para la gestión del curso,
    hago de su conocimiento el resultado del seguimiento
    realizado.

    <br><br>

    <b>
        Materia:
    </b>

    {{ $evidencia->materia->nombre }}

    <br>

    <b>
        Revisión:
    </b>

    {{ $evidencia->revision->nombre }}

    <table>

        <thead>

            <tr>

                <th>
                    CRITERIO
                </th>

                <th width="120">
                    % CUMPLIMIENTO
                </th>

                <th width="70">
                    N/A
                </th>

                <th>
                    OBSERVACIONES
                </th>

            </tr>

        </thead>

        <tbody>

            @foreach($criterios as $key => $nombre)

            @php

            $calificacion =
            $evaluacion[$key]['calificacion'] ?? 0;

            $na =
            $evaluacion[$key]['na'] ?? false;

            $observacion =
            $evaluacion[$key]['observacion'] ?? '';

            @endphp

            <tr>

                <td>
                    {{ $nombre }}
                </td>

                <td class="center">

                    @if(!$na)
                    {{ $calificacion }}
                    @endif

                </td>

                <td class="center">

                    @if($na)
                    X
                    @endif

                </td>

                <td>
                    {{ $observacion }}
                </td>

            </tr>

            @endforeach

            <tr>

                <td class="bold">
                    TOTAL DE CUMPLIMIENTO
                </td>

                <td class="center bold">

                    {{ $promedioFinal }}

                </td>

                <td></td>

                <td></td>

            </tr>

        </tbody>

    </table>

    <p style="margin-top:30px;">

        En función del resultado,
        solicito solventar las observaciones reportadas.

    </p>

    <div class="firma">

        <br><br><br>

        ___________________________________

        <br><br>

        <b>
            {{ $admin->name }}
        </b>

        <br>

        {{ $admin->cargo }}

        <br>

        Departamento de
        {{ $admin->departamento }}

    </div>

</body>

</html>