
@extends('adminlte::page')

@section('title', 'Canjear Puntos')

@section('content_header')
@stop

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1><i class="fas fa-store"></i> Tienda de Canjes</h1>
            <a href="{{ route('canjes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Mis Canjes
            </a>
        </div>

        <!-- Tarjeta de puntos disponibles -->
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <h4><i class="fas fa-coins"></i> Puntos Disponibles: <strong>{{ $puntosDisponibles }}</strong></h4>
                    <p class="mb-0">Selecciona un producto de la tienda para canjear tus puntos por descuentos exclusivos.</p>
                </div>
            </div>
        </div>

        @if($tiendas->isEmpty())
            <div class="alert alert-warning text-center">
                <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                <p class="mb-0">No hay productos disponibles en la tienda en este momento. Por favor, vuelve más tarde.</p>
            </div>
        @else
            <div class="row">
                @foreach($tiendas as $tienda)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 {{ $tienda->puntos_requeridos > $puntosDisponibles ? 'border-secondary' : 'border-success' }}">
                            <div class="card-header {{ $tienda->puntos_requeridos > $puntosDisponibles ? 'bg-secondary' : 'bg-success' }} text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-tag"></i> {{ $tienda->nombre }}
                                </h5>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <p class="card-text flex-grow-1">{{ $tienda->descripcion }}</p>
                                
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge badge-warning badge-lg">
                                            <i class="fas fa-coins"></i> {{ $tienda->puntos_requeridos }} puntos
                                        </span>
                                        <span class="badge badge-success badge-lg">
                                            <i class="fas fa-percentage"></i> {{ $tienda->descuento_porcentaje }}% OFF
                                        </span>
                                    </div>
                                    
                                    @if($tienda->puntos_requeridos > $puntosDisponibles)
                                        <div class="alert alert-warning mb-0 py-2">
                                            <small>
                                                <i class="fas fa-info-circle"></i> 
                                                Te faltan {{ $tienda->puntos_requeridos - $puntosDisponibles }} puntos
                                            </small>
                                        </div>
                                    @endif
                                </div>

                                <form action="{{ route('canjes.store') }}" method="POST" class="canje-form">
                                    @csrf
                                    <input type="hidden" name="tienda_id" value="{{ $tienda->id }}">
                                    <button 
                                        type="submit" 
                                        class="btn btn-block {{ $tienda->puntos_requeridos > $puntosDisponibles ? 'btn-secondary' : 'btn-success' }}"
                                        {{ $tienda->puntos_requeridos > $puntosDisponibles ? 'disabled' : '' }}
                                    >
                                        <i class="fas fa-shopping-cart"></i> 
                                        {{ $tienda->puntos_requeridos > $puntosDisponibles ? 'Puntos Insuficientes' : 'Canjear Ahora' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Información adicional -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle"></i> ¿Cómo funciona?</h5>
                    </div>
                    <div class="card-body">
                        <ol>
                            <li><strong>Acumula puntos:</strong> Realiza recolecciones de residuos para ganar puntos.</li>
                            <li><strong>Elige tu producto:</strong> Selecciona el producto que deseas canjear de nuestra tienda.</li>
                            <li><strong>Obtén tu código:</strong> Recibirás un código único para usar tu descuento.</li>
                            <li><strong>Disfruta tu beneficio:</strong> Usa el código en la tienda asociada para obtener tu descuento.</li>
                        </ol>
                        <p class="mb-0 text-muted">
                            <i class="fas fa-lightbulb"></i> 
                            <strong>Tip:</strong> Los códigos de canje tienen validez limitada. Úsalos pronto para aprovechar tus descuentos.
                        </p>
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
            font-size: 0.9rem;
            padding: 0.4rem 0.6rem;
        }
        .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover:not(.border-secondary) {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .border-success {
            border-width: 2px !important;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            // Confirmar canje con SweetAlert2
            $('.canje-form').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const tiendaNombre = form.closest('.card').find('h5').text().trim();
                const puntosRequeridos = form.find('input[name="tienda_id"]').closest('.card-body').find('.badge-warning').text().trim();

                Swal.fire({
                    title: '¿Confirmar Canje?',
                    html: `
                        <p>Estás a punto de canjear:</p>
                        <p><strong>${tiendaNombre}</strong></p>
                        <p>${puntosRequeridos}</p>
                        <p class="text-muted">Esta acción no se puede deshacer.</p>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-check"></i> Sí, Canjear',
                    cancelButtonText: '<i class="fas fa-times"></i> Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.off('submit').submit();
                    }
                });
            });

            // Manejar alertas con SweetAlert2
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#dc3545',
                });
            @endif
        });
    </script>
@stop
