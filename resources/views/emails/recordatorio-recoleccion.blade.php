
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recordatorio de Recolección</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #ffc107;
            color: #333;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 0 0 5px 5px;
        }
        .info-box {
            background-color: white;
            padding: 15px;
            margin: 15px 0;
            border-left: 4px solid #ffc107;
        }
        .info-box strong {
            color: #ffc107;
        }
        .alert {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>⏰ Recordatorio de Recolección</h1>
    </div>
    <div class="content">
        <p>Hola <strong>{{ $usuario->name }}</strong>,</p>
        
        <div class="alert">
            <p><strong>¡Recuerda!</strong> Mañana es tu día de recolección.</p>
        </div>
        
        <p>Te recordamos los detalles de tu recolección programada:</p>
        
        <div class="info-box">
            <p><strong>Tipo de Residuo:</strong> {{ $recoleccion->tipo_residuo }}</p>
            <p><strong>Fecha:</strong> {{ $recoleccion->fecha_programada ? $recoleccion->fecha_programada->format('d/m/Y') : 'No programada' }}</p>
            @if($localidad)
                <p><strong>Localidad:</strong> {{ $localidad->nombre }}</p>
            @endif
            @if($ruta)
                <p><strong>Ruta:</strong> {{ $ruta->nombre }}</p>
                <p><strong>Día:</strong> {{ $ruta->dia_semana }}</p>
                <p><strong>Horario:</strong> {{ $ruta->hora_inicio }} - {{ $ruta->hora_fin }}</p>
            @endif
            @if($empresa)
                <p><strong>Empresa Recolectora:</strong> {{ $empresa->name }}</p>
            @endif
        </div>
        
        <p><strong>Recomendaciones:</strong></p>
        <ul>
            <li>Prepara tus residuos con anticipación</li>
            <li>Asegúrate de que estén correctamente separados</li>
            <li>Colócalos en un lugar visible y accesible</li>
        </ul>
        
        <p>Gracias por tu compromiso con el medio ambiente.</p>
        
        <p>Saludos,<br><strong>Equipo EcoResiduos</strong></p>
    </div>
    <div class="footer">
        <p>Este es un correo automático, por favor no responder.</p>
    </div>
</body>
</html>
