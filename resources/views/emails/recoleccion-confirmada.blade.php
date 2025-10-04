
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recolección Confirmada</title>
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
            background-color: #28a745;
            color: white;
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
            border-left: 4px solid #28a745;
        }
        .info-box strong {
            color: #28a745;
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
        <h1>✓ Recolección Confirmada</h1>
    </div>
    <div class="content">
        <p>Hola <strong>{{ $usuario->name }}</strong>,</p>
        
        <p>Tu recolección ha sido confirmada exitosamente. A continuación los detalles:</p>
        
        <div class="info-box">
            <p><strong>Tipo de Residuo:</strong> {{ $recoleccion->tipo_residuo }}</p>
            <p><strong>Fecha Programada:</strong> {{ $recoleccion->fecha_programada ? $recoleccion->fecha_programada->format('d/m/Y') : 'No programada' }}</p>
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
        
        <p>Recibirás un recordatorio el día anterior a tu recolección.</p>
        
        <p>Gracias por contribuir al cuidado del medio ambiente.</p>
        
        <p>Saludos,<br><strong>Equipo EcoResiduos</strong></p>
    </div>
    <div class="footer">
        <p>Este es un correo automático, por favor no responder.</p>
    </div>
</body>
</html>
