
@extends('adminlte::page')

@section('title', 'Detalle del Canje')

@section('content_header')
@stop

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1><i class="fas fa-ticket-alt"></i> Detalle del Canje</h1>
            <a href="{{ route('canjes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Mis Canjes
            </a>
        </div>

        <div class="row">
            <!-- Tarjeta principal del canje -->
            <div class="col-md-8">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle"></i> Información del Canje
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-5">ID Canje:</dt>
                                    <dd class="col-sm-7"><span class="badge badge-primary">#{{ $canje->id }}</span></dd>

                                    <dt class="col-sm-5">Tienda:</dt>
                                    <dd class="col-sm-7"><strong>{{ $canje->tienda->nombre }}</strong></dd>

                                    <dt class="col-sm-5">Descripción:</dt>
                                    <dd class="col-sm-7">{{ $canje->tienda->descripcion }}</dd>

                                    <dt class="col-sm-5">Descuento:</dt>
                                    <dd class="col-sm-7">
                                        <span class="badge badge-success badge-lg">
                                            <i class="fas fa-percentage"></i> {{ $canje->descuento_obtenido }}% OFF
                                        </span>
                                    </dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-5">Puntos Canjeados:</dt>
                                    <dd class="col-sm-7">
                                        <span class="badge badge-warning badge-lg">
                                            <i class="fas fa-coins"></i> {{ $canje->puntos_canjeados }} puntos
                                        </span>
                                    </dd>

                                    <dt class="col-sm-5">Fecha de Canje:</dt>
                                    <dd class="col-sm-7">{{ $canje->fecha_canje->format('d/m/Y H:i') }}</dd>

                                    <dt class="col-sm-5">Estado:</dt>
                                    <dd class="col-sm-7">
                                        @if($canje->estado === 'pendiente')
                                            <span class="badge badge-warning badge-lg">
                                                <i class="fas fa-clock"></i> Pendiente de Uso
                                            </span>
                                        @elseif($canje->estado === 'usado')
                                            <span class="badge badge-success badge-lg">
                                                <i class="fas fa-check-circle"></i> Utilizado
                                            </span>
                                        @else
                                            <span class="badge badge-secondary badge-lg">
                                                <i class="fas fa-times-circle"></i> {{ ucfirst($canje->estado) }}
                                            </span>
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta del código de canje -->
            <div class="col-md-4">
                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-qrcode"></i> Código de Canje
                        </h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-ticket-alt fa-3x text-warning"></i>
                        </div>
                        <h3 class="text-primary mb-3">
                            <code id="codigoCanje" style="font-size: 1.5rem; letter-spacing: 2px;">
                                {{ $canje->codigo_canje }}
                            </code>
                        </h3>
                        <button class="btn btn-info btn-block" onclick="copiarCodigo()">
                            <i class="fas fa-copy"></i> Copiar Código
                        </button>
                        
                        @if($canje->estado === 'pendiente')
                            <div class="alert alert-info mt-3 mb-0">
                                <small>
                                    <i class="fas fa-info-circle"></i> 
                                    Presenta este código en la tienda para obtener tu descuento.
                                </small>
                            </div>
                        @elseif($canje->estado === 'usado')
                            <div class="alert alert-success mt-3 mb-0">
                                <small>
                                    <i class="fas fa-check-circle"></i> 
                                    Este código ya fue utilizado.
                                </small>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-lightbulb"></i> Instrucciones
                        </h3>
                    </div>
                    <div class="card-body">
                        <ol class="pl-3 mb-0">
                            <li>Copia el código de canje</li>
                            <li>Visita la tienda: <strong>{{ $canje->tienda->nombre }}</strong></li>
                            <li>Presenta el código al momento de pagar</li>
                            <li>Disfruta tu descuento del <strong>{{ $canje->descuento_obtenido }}%</strong></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta de acciones -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{ route('canjes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-list"></i> Ver Todos Mis Canjes
                        </a>
                        <a href="{{ route('canjes.create') }}" class="btn btn-success">
                            <i class="fas fa-shopping-cart"></i> Realizar Otro Canje
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .badge-lg {
            font-size: 1rem;
            padding: 0.5rem 0.75rem;
        }
        code {
            background-color: #f8f9fa;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            border: 2px dashed #007bff;
        }
        .card-outline {
            border-top: 3px solid;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function copiarCodigo() {
            const codigo = document.getElementById('codigoCanje').textContent.trim();
            
            // Crear elemento temporal para copiar
            const tempInput = document.createElement('input');
            tempInput.value = codigo;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            
            // Mostrar confirmación
            Swal.fire({
                icon: 'success',
                title: '¡Código Copiado!',
                text: 'El código ha sido copiado al portapapeles',
                timer: 2000,
                showConfirmButton: false
            });
        }

        // Manejar alertas con SweetAlert2
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Canje Exitoso!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#28a745',
            });
        @endif
    </script>
@stop
