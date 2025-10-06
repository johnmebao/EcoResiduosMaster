
@extends('adminlte::page')

@section('title', 'Detalle del Canje')

@section('content_header')
@stop

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Detalle del Canje</h1>
            <a href="{{ route('canjes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al historial
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <!-- Información del canje -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h3 class="card-title">
                            <i class="fas fa-gift"></i> Información del Canje
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong><i class="fas fa-store text-primary"></i> Tienda:</strong>
                                <p class="mb-0">{{ $canje->tienda->nombre }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong><i class="fas fa-calendar text-info"></i> Fecha de Canje:</strong>
                                <p class="mb-0">{{ $canje->fecha_canje->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong><i class="fas fa-coins text-warning"></i> Puntos Canjeados:</strong>
                                <p class="mb-0">
                                    <span class="badge badge-primary badge-lg">
                                        {{ number_format($canje->puntos_canjeados) }} puntos
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <strong><i class="fas fa-percentage text-success"></i> Descuento Obtenido:</strong>
                                <p class="mb-0">
                                    <span class="badge badge-success badge-lg">
                                        {{ number_format($canje->descuento_obtenido, 0) }}% OFF
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <strong><i class="fas fa-info-circle text-info"></i> Estado:</strong>
                                <p class="mb-0">
                                    @if($canje->estado === 'pendiente')
                                        <span class="badge badge-warning badge-lg">
                                            <i class="fas fa-clock"></i> Pendiente de Uso
                                        </span>
                                    @elseif($canje->estado === 'usado')
                                        <span class="badge badge-success badge-lg">
                                            <i class="fas fa-check"></i> Usado
                                        </span>
                                    @else
                                        <span class="badge badge-secondary badge-lg">
                                            <i class="fas fa-times"></i> Expirado
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if($canje->tienda->descripcion)
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <strong><i class="fas fa-align-left text-secondary"></i> Descripción de la Tienda:</strong>
                                    <p class="mb-0">{{ $canje->tienda->descripcion }}</p>
                                </div>
                            </div>
                        @endif

                        @if($canje->tienda->direccion || $canje->tienda->telefono)
                            <hr>
                            <div class="row">
                                @if($canje->tienda->direccion)
                                    <div class="col-md-6">
                                        <strong><i class="fas fa-map-marker-alt text-danger"></i> Dirección:</strong>
                                        <p class="mb-0">{{ $canje->tienda->direccion }}</p>
                                    </div>
                                @endif
                                @if($canje->tienda->telefono)
                                    <div class="col-md-6">
                                        <strong><i class="fas fa-phone text-primary"></i> Teléfono:</strong>
                                        <p class="mb-0">{{ $canje->tienda->telefono }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Código de canje -->
            <div class="col-md-4">
                <div class="card {{ $canje->estado === 'pendiente' ? 'border-success' : 'border-secondary' }}">
                    <div class="card-header {{ $canje->estado === 'pendiente' ? 'bg-success' : 'bg-secondary' }} text-white">
                        <h3 class="card-title">
                            <i class="fas fa-qrcode"></i> Código de Canje
                        </h3>
                    </div>
                    <div class="card-body text-center">
                        @if($canje->estado === 'pendiente')
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i> Código Activo
                            </div>
                        @else
                            <div class="alert alert-secondary">
                                <i class="fas fa-info-circle"></i> Código {{ ucfirst($canje->estado) }}
                            </div>
                        @endif

                        <div class="mb-3">
                            <h2 class="display-4 font-weight-bold text-primary" style="font-family: monospace;">
                                {{ $canje->codigo_canje }}
                            </h2>
                        </div>

                        @if($canje->estado === 'pendiente')
                            <button class="btn btn-primary btn-block" onclick="copiarCodigo()">
                                <i class="fas fa-copy"></i> Copiar Código
                            </button>
                            
                            <hr>
                            
                            <div class="alert alert-info mb-0">
                                <small>
                                    <i class="fas fa-info-circle"></i>
                                    Presenta este código en la tienda para obtener tu descuento del 
                                    <strong>{{ number_format($canje->descuento_obtenido, 0) }}%</strong>
                                </small>
                            </div>
                        @endif
                    </div>
                </div>

                @if($canje->estado === 'pendiente')
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5><i class="fas fa-lightbulb text-warning"></i> Instrucciones</h5>
                            <ol class="mb-0 pl-3">
                                <li>Visita la tienda {{ $canje->tienda->nombre }}</li>
                                <li>Muestra este código al personal</li>
                                <li>Obtén tu descuento del {{ number_format($canje->descuento_obtenido, 0) }}%</li>
                            </ol>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .badge-lg {
            font-size: 1.1rem;
            padding: 0.5rem 1rem;
        }
    </style>
@stop

@section('js')
    <script>
        function copiarCodigo() {
            const codigo = "{{ $canje->codigo_canje }}";
            navigator.clipboard.writeText(codigo).then(function() {
                // Mostrar mensaje de éxito
                Swal.fire({
                    icon: 'success',
                    title: '¡Código copiado!',
                    text: 'El código ha sido copiado al portapapeles',
                    timer: 2000,
                    showConfirmButton: false
                });
            }, function(err) {
                // Fallback para navegadores antiguos
                const textarea = document.createElement('textarea');
                textarea.value = codigo;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
                
                Swal.fire({
                    icon: 'success',
                    title: '¡Código copiado!',
                    text: 'El código ha sido copiado al portapapeles',
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        }
    </script>
@stop
