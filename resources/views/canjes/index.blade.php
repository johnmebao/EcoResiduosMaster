
@extends('adminlte::page')

@section('title', 'Mis Canjes')

@section('content_header')
@stop

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1><i class="fas fa-gift"></i> Historial de Canjes</h1>
            <div>
                <a href="{{ route('canjes.create') }}" class="btn btn-success">
                    <i class="fas fa-shopping-cart"></i> Canjear Puntos
                </a>
            </div>
        </div>

        <!-- Tarjeta de puntos disponibles -->
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ auth()->user()->point->available_points ?? 0 }}</h3>
                        <p>Puntos Disponibles</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <a href="{{ route('canjes.create') }}" class="small-box-footer">
                        Canjear ahora <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $canjes->where('estado', 'pendiente')->count() }}</h3>
                        <p>Canjes Pendientes</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $canjes->where('estado', 'usado')->count() }}</h3>
                        <p>Canjes Utilizados</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list"></i> Mis Canjes Realizados</h3>
            </div>
            <div class="card-body">
                @if($canjes->isEmpty())
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle fa-2x mb-2"></i>
                        <p class="mb-0">Aún no has realizado ningún canje. ¡Empieza a canjear tus puntos ahora!</p>
                        <a href="{{ route('canjes.create') }}" class="btn btn-success mt-2">
                            <i class="fas fa-shopping-cart"></i> Ver Tienda
                        </a>
                    </div>
                @else
                    <table id="canjesTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tienda</th>
                                <th>Descuento</th>
                                <th>Puntos Canjeados</th>
                                <th>Código</th>
                                <th>Fecha Canje</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($canjes as $canje)
                                <tr>
                                    <td>{{ $canje->id }}</td>
                                    <td>
                                        <strong>{{ $canje->tienda->nombre }}</strong><br>
                                        <small class="text-muted">{{ Str::limit($canje->tienda->descripcion, 50) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-success badge-lg">
                                            <i class="fas fa-percentage"></i> {{ $canje->descuento_obtenido }}% OFF
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-warning">
                                            <i class="fas fa-coins"></i> {{ $canje->puntos_canjeados }} pts
                                        </span>
                                    </td>
                                    <td>
                                        <code class="text-primary">{{ $canje->codigo_canje }}</code>
                                    </td>
                                    <td>{{ $canje->fecha_canje->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($canje->estado === 'pendiente')
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock"></i> Pendiente
                                            </span>
                                        @elseif($canje->estado === 'usado')
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle"></i> Usado
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">
                                                <i class="fas fa-times-circle"></i> {{ ucfirst($canje->estado) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('canjes.show', $canje) }}" class="btn btn-info btn-sm" title="Ver detalle">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
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
        .small-box {
            border-radius: 0.25rem;
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            // Inicializar DataTable
            $('#canjesTable').DataTable({
                "responsive": true,
                "autoWidth": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                "order": [[0, "desc"]]
            });

            // Manejar alertas con SweetAlert2
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#28a745',
                });
            @endif

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
