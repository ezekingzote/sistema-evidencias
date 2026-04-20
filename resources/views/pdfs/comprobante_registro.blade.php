<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>{{ $titulo }}</title>
    <style>
        @page {
            margin: 0cm;
        }

        body {
            font-family: 'Helvetica', Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .header {
            background-color: #1B396A;
            /* Azul Laravel/Bootstrap */
            color: white;
            padding: 40px 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .container {
            padding: 40px;
            background-color: white;
            margin: -30px 40px 0 40px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .welcome-msg {
            text-align: center;
            font-size: 16px;
            margin-bottom: 30px;
            color: #555;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .info-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .label {
            font-weight: bold;
            color: #0d6efd;
            width: 35%;
        }

        .value {
            color: #222;
            font-family: 'Courier New', Courier, monospace;
            font-size: 15px;
        }

        .password-box {
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            border: 1px dashed #adb5bd;
            display: inline-block;
        }

        .footer {
            margin: 40px;
            text-align: center;
            font-size: 12px;
            color: #777;
            line-height: 1.6;
        }

        .date {
            font-style: italic;
            margin-top: 10px;
            color: #999;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>{{ $titulo }}</h1>
    </div>
    <div class="container">
        <div class="welcome-msg">
            Estimado(a) <strong>{{ $nombre }}</strong>,<br>
            Sus credenciales de acceso al sistema han sido generadas correctamente.
        </div>

        <table class="info-table">
            <tr>
                <td class="label">Correo Electrónico:</td>
                <td class="value">{{ $email }}</td>
            </tr>
            <tr>
                <td class="label">Contraseña Temporal:</td>
                <td class="value">
                    <div class="password-box">
                        <strong>{{ $pass }}</strong>
                    </div>
                </td>
            </tr>
        </table>

        <div style="text-align: center; color: #666; font-size: 13px;">
            <p>{{ $leyenda }}</p>
        </div>
    </div>

    <div class="footer">
        Este documento es un comprobante oficial de registro.<br>
        © {{ date('Y') }} Sistema de Gestión Escolar. Todos los derechos reservados.
        <div class="date">Generado el: {{ $fecha }}</div>
    </div>

</body>

</html>
