
@extends('adminlte::page')

@section('title', 'Canjear Puntos')

@section('content_header')
@stop

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Canjear Puntos</h1>
            <a href="{{ route('canjes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al historial
            </a>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Tarjeta de puntos disponibles -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card bg-gradient-success">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3 class="text-white mb-0">
                                    <i class="fas fa-coins"></i> Tus Puntos Disponibles
                                </h3>
                                <p class="text-white-50 mb-0">Puntos acumulados listos para canjear</p>
                            </div>
                            <div class="col-md-4 text-right">
                                <h1 class="text-white mb-0 display-3">
                                    {{ number_format($puntosDisponibles) }}
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tiendas disponibles -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-store"></i> Tiendas Disponibles para Canjear
                </h3>
            </div>
            <div class="card-body">
                @if($tiendas->isEmpty())
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> No hay tiendas disponibles en este momento.
                    </div>
                @else
                    <div class="row">
                        @foreach($tiendas as $tienda)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100 {{ $puntosDisponibles >= $tienda->puntos_requeridos ? 'border-success' : 'border-secondary' }}">
                                    <div class="card-header {{ $puntosDisponibles >= $tienda->puntos_requeridos ? 'bg-success' : 'bg-secondary' }} text-white">
                                        <h5 class="mb-0">
                                            <i class="fas fa-store"></i> {{ $tienda->nombre }}
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">{{ $tienda->descripcion }}</p>
                                        
                                        @if($tienda->direccion)
                                            <p class="mb-2">
                                                <i class="fas fa-map-marker-alt text-danger"></i>
                                                <small>{{ $tienda->direccion }}</small>
                                            </p>
                                        @endif
                                        
                                        @if($tienda->telefono)
                                            <p class="mb-2">
                                                <i class="fas fa-phone text-primary"></i>
                                                <small>{{ $tienda->telefono }}</small>
                                            </p>
                                        @endif

                                        <hr>
                                        
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <small class="text-muted">Puntos requeridos:</small>
                                                <h4 class="mb-0">
                                                    <span class="badge badge-primary">
                                                        <i class="fas fa-coins"></i> {{ number_format($tienda->puntos_requeridos) }}
                                                    </span>
                                                </h4>
                                            </div>
                                            <div>
                                                <small class="text-muted">Descuento:</small>
                                                <h4 class="mb-0">
                                                    <span class="badge badge-success">
                                                        {{ number_format($tienda->descuento_porcentaje, 0) }}% OFF
                                                    </span>
                                                </h4>
                                            </div>
                                        </div>

                                        @if($puntosDisponibles >= $tienda->puntos_requeridos)
                                            <form action="{{ route('canjes.store') }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas canjear {{ number_format($tienda->puntos_requeridos) }} puntos por un descuento del {{ number_format($tienda->descuento_porcentaje, 0) }}% en {{ $tienda->nombre }}?');">
                                                @csrf
                                                <input type="hidden" name="tienda_id" value="{{ $tienda->id }}">
                                                <button type="submit" class="btn btn-success btn-block">
                                                    <i class="fas fa-gift"></i> Canjear Ahora
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-secondary btn-block" disabled>
                                                <i class="fas fa-lock"></i> Puntos Insuficientes
                                            </button>
                                            <small class="text-danger">
                                                Te faltan {{ number_format($tienda->puntos_requeridos - $puntosDisponibles) }} puntos
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Información adicional -->
        <div class="card bg-light">
            <div class="card-body">
                <h5><i class="fas fa-info-circle text-info"></i> ¿Cómo funciona?</h5>
                <ol class="mb-0">
                    <li>Selecciona la tienda donde deseas obtener un descuento</li>
                    <li>Asegúrate de tener suficientes puntos para el canje</li>
                    <li>Confirma el canje y recibirás un código único</li>
                    <li>Presenta el código en la tienda para obtener tu descuento</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .card {
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .bg-gradient-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }
    </style>
@stop
