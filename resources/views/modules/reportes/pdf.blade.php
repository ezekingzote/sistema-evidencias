<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte PDF</title>

    <style>
        body {
            font-family: Arial;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .sub {
            text-align: center;
            margin-bottom: 15px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #0a2342;
            color: white;
            padding: 8px;
        }

        table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background: #f5f5f5;
        }
    </style>
</head>

<body>

    <h2>Reporte de Seguimiento Académico</h2>

    <div class="sub">
        Revisión {{ $revisionId }}
    </div>

    <table>

        <thead>
            <tr>
                <th>Docente</th>
                <th>Materia</th>
                <th>Calificación</th>
            </tr>
        </thead>

        <tbody>

            @foreach($data as $row)

                <tr>
                    <td>{{ $row['docente'] }}</td>
                    <td>{{ $row['materia'] }}</td>
                    <td>{{ $row['calificacion'] }}</td>
                </tr>

            @endforeach

        </tbody>

    </table>

</body>

</html>