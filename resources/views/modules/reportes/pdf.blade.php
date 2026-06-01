<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reporte de Seguimiento</title>
    <style>
        /* Configuración de la página física */
        @page {
            margin: 140px 50px 100px 50px;
            /* Márgenes para dar espacio a header y footer */
        }

        /* Estilos Generales */
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            line-height: 1.4;
        }

        .bold {
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .justify {
            text-align: justify;
        }

        /* Encabezado fijo en todas las páginas */
        #header {
            position: fixed;
            top: -110px;
            left: 0px;
            right: 0px;
            height: 90px;
            border-bottom: 1px solid #ddd;
        }

        #header img {
            width: 100%;
            height: auto;
        }

        /* Pie de página fijo en todas las páginas */
        #footer {
            position: fixed;
            bottom: -10px;
            left: 0px;
            right: 0px;
            height: 60px;
            font-size: 8px;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td {
            border: none !important;
            padding: 0;
        }

        /* Datos de control (Oficio, Asunto, Fecha) */
        .meta-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .meta-table td {
            border: none;
            padding: 2px 0;
            vertical-align: top;
        }

        /* Contenedor Principal */
        .content {
            width: 100%;
        }

        /* Tabla de Criterios (Estilo oficial e idéntico) */
        table.criterios-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        table.criterios-table th {
            background-color: #f5f5f5;
            border: 1px solid #000;
            padding: 5px;
            font-size: 10px;
            font-weight: bold;
            text-align: center;
        }

        table.criterios-table td {
            border: 1px solid #000;
            padding: 5px;
            font-size: 10px;
            vertical-align: middle;
        }

        /* Sección de firmas */
        .firma-container {
            margin-top: 50px;
            width: 100%;
            page-break-inside: avoid;
            /* Evita que la firma se parta en dos páginas */
        }

        .docente {
            background-color: #D9E2D0 !important;
            /* verde claro */
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }

        .seguimiento {
            background-color: #70AD47 !important;
            /* verde fuerte */
            color: #000;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }

        .encabezado-tabla {
            background-color: #D9E2D0 !important;
            font-size: 13px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>

<body>

    <div id="header">
        <img src="{{ public_path('img/header-pdf-cb.png') }}" style="width:100%;">
    </div>
    <div id="footer">
        <img src="{{ public_path('img/footer-pdf-cb.png') }}" style="width:100%;">
    </div>

    <div class="content">

        <table class="meta-table">
            <tr>
                <td width="50%">
                    <span class="bold">Instituto Tecnológico de Milpa Alta II</span><br>
                    Departamento de {{ $admin->departamento }}
                </td>

                <td width="50%" class="right" style="padding-top: 45px;">
                    <span>Ciudad de México,</span> {{ now()->format('d/m/Y') }}<br>
                    <span>Oficio No.</span> ITMAII/CBAS/060/{{ now()->format('Y') }}<br>
                    Asunto:<span class="bold">Reporde de {{ ($evidencia->revision->nombre) }}</span>
                </td>
            </tr>
        </table>

        <div style="margin-bottom: 15px;">
            <span class="bold" style="font-size: 12px; text-transform: uppercase;">{{ $evidencia->asignacion->docente->name }}</span><br>
            <span class="bold" style="font-size: 12px;">DOCENTE DEL INSTITUTO TECNOLÓGICO DE MILPA ALTA II</span><br>
            <span class="bold" style="font-size: 12px;">PRESENTE</span>
        </div>

        <p class="justify" style="font-size: 12px;">
            Con base al Procedimiento para la Gestión del Curso en Programas Educativos con Enfoque por Competencias
            del Sistema de Gestión de Calidad que certifica al Tecnológico Nacional de México, hago de su conocimiento
            el resultado de la "<span class="bold">{{ $evidencia->revision->nombre }} a la gestión del curso</span>" realizado para la materia de <span class="bold">{{ $evidencia->materia->nombre }}</span> programado para el semestre <span class="bold">{{ $evidencia->asignacionMateria->semestre->nombre }}</span>.
        </p>

        <table class="criterios-table">
            <thead>
                <tr>
                    <th colspan="4" class="docente">
                        {{ strtoupper($evidencia->asignacion->docente->name) }}
                    </th>
                </tr>
                <tr>
                    <th colspan="4" class="seguimiento">
                        {{ strtoupper($evidencia->revision->nombre) }} {{ $evidencia->asignacionMateria->semestre->nombre }}
                    </th>
                </tr>
                <tr>
                    <th class="encabezado-tabla">CRITERIO</th>
                    <th class="encabezado-tabla" width="110">% CUMPLIMIENTO</th>
                    <th class="encabezado-tabla" width="50">N/A</th>
                    <th class="encabezado-tabla">OBSERVACIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach($criterios as $key => $nombre)
                @php
                $item = $evaluacion[$key] ?? [];

                $calificacion = $item['calificacion'] ?? '';
                $na = !empty($item['na']);
                $observacion = $item['observaciones'] ?? '';
                @endphp

                <tr>
                    <td>{{ $nombre }}</td>

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
                        {{ strtoupper($observacion) }}
                    </td>
                </tr>
                @endforeach

                <tr>
                    <td class="bold encabezado-tabla">TOTAL DE CUMPLIMIENTO</td>
                    <td class="center bold encabezado-tabla">
                        {{ number_format($promedioFinal,2) }}
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <p class="justify" style="padding-top: 165px;">
            En función del resultado, solicito de la manera más atenta solventar a la brevedad las observaciones reportadas, en caso de haberlas. Recordando el artículo IV y VII del Capítulo II de las obligaciones del Reglamento Interior de Trabajo del Personal Docente de los Institutos Tecnológicos, es obligación del docente cumplir con los puntos mencionados en el reporte de seguimiento a la gestión del curso.
        </p>

        <p>Agradezco su atención y quedo atento.</p>

        <div class="firma-container">
            <p style="margin-bottom: 30px; text-transform: uppercase;"><span class="bold">Atentamente</span><br>
                <span style="font-size: 8px; font-style: italic;" class="bold">
                    Excelencia en Educación Tecnológica®
                </span>
            </p>
            <img src="{{ public_path('img/firma-cb.png') }}" style="width:35%;" alt="Firma">
            <div style="text-align: right;">
                <img src="{{ public_path('img/sello-cb.png') }}" style="width:35%;" alt="Firma">
            </div>

            <p style="margin-top: 5px; line-height: 1.2;">
                <span class="bold" style="text-transform: uppercase;">{{ $admin->name }}</span><br>
                <span class="bold" style="text-transform: uppercase;">{{ $admin->cargo }}</span><br>
            </p>
        </div>

        <div style="font-size: 9px; color: #777; margin-top: 5px;">
            ccp. Archivo.
        </div>

    </div>

</body>

</html>