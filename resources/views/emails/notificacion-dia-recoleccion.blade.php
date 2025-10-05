@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
        <div class="header">
        <h1>🚛 ¡Hoy es tu Recolección!</h1>
    </div>
    <div class="content">
        <p>Hola <strong>{{ $usuario->name }}</strong>,</p>
        
        <div class="alert">
            <p><strong>¡Atención!</strong> Hoy es el día de tu recolección programada.</p>
        </div>
        
        @if($turno)
        <div class="turno-box">
            Tu número de turno en la ruta: <span style="font-size: 36px;">{{ $turno }}</span>
        </div>
        @endif
        
        <p>Detalles de tu recolección:</p>
        
        <div class="info-box">
            <p><strong>Tipo de Residuo:</strong> {{ $recoleccion->tipo_residuo }}</p>
            <p><strong>Fecha:</strong> {{ $recoleccion->fecha_programada ? $recoleccion->fecha_programada->format('d/m/Y') : 'Hoy' }}</p>
            @if($localidad)
                <p><strong>Localidad:</strong> {{ $localidad->nombre }}</p>
            @endif
            @if($ruta)
                <p><strong>Ruta:</strong> {{ $ruta->nombre }}</p>
                <p><strong>Horario Estimado:</strong> {{ $ruta->hora_inicio }} - {{ $ruta->hora_fin }}</p>
            @endif
            @if($empresa)
                <p><strong>Empresa Recolectora:</strong> {{ $empresa->name }}</p>
            @endif
        </div>
        
        <p><strong>Instrucciones finales:</strong></p>
        <ul>
            <li>Coloca tus residuos en un lugar visible</li>
            <li>Asegúrate de que estén correctamente embolsados</li>
            <li>El camión pasará aproximadamente en el horario indicado</li>
            @if($turno)
            <li>Tu turno es el número {{ $turno }} en la ruta</li>
            @endif
        </ul>
        
        <p>¡Gracias por cuidar nuestro planeta!</p>
        
        <p>Saludos,<br><strong>Equipo EcoResiduos</strong></p>
    </div>
    <div class="footer">
        <p>Este es un correo automático, por favor no responder.</p>
    </div>
@stop

@section('css')
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
            background-color: #007bff;
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
            border-left: 4px solid #007bff;
        }
        .info-box strong {
            color: #007bff;
        }
        .turno-box {
            background-color: #007bff;
            color: white;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
            border-radius: 5px;
            font-size: 24px;
            font-weight: bold;
        }
        .alert {
            background-color: #d1ecf1;
            border: 1px solid #007bff;
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
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
