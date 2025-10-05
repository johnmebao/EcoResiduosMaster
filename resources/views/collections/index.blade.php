
@extends('adminlte::page')

@section('title', 'Recolecciones')

@section('content_header')
    <h1><i class="fas fa-recycle"></i> Gestión de Recolecciones</h1>
@stop

@section('content')
<div class="container-fluid">
    <x-adminlte-card theme="primary" theme-mode="outline" icon="fas fa-list" title="Listado de Recolecciones">
        <x-slot name="toolsSlot">
            <a href="{{ route('collections.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Nueva Recolección
            </a>
        </x-slot>

        <div class="table-responsive">
            <table id="collections-table" class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Empresa</th>
                        <th>Localidad</th>
                        <th>Ruta</th>
                        <th>Tipo Residuo</th>
                        <th>Fecha Programada</th>
                        <th>Turno</th>
                        <th>Peso (kg)</th>
                        <th>Estado</th>
                        <th>Estado Solicitud</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($collections as $collection)
                        <tr>
                            <td>{{ $collection->id }}</td>
                            <td>
                                <i class="fas fa-user text-primary"></i>
                                {{ $collection->user->name }}
                            </td>
                            <td>
                                <i class="fas fa-building text-info"></i>
                                {{ $collection->company->nombre }}
                            </td>
                            <td>
                                @if($collection->localidad)
                                    <i class="fas fa-map-marker-alt text-success"></i>
                                    {{ $collection->localidad->nombre }}
                                @else
                                    <span class="text-muted">Sin localidad</span>
                                @endif
                            </td>
                            <td>
                                @if($collection->ruta)
                                    <i class="fas fa-route text-warning"></i>
                                    {{ $collection->ruta->nombre }}
                                @else
                                    <span class="text-muted">Sin ruta</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $badgeClass = match($collection->tipo_residuo) {
                                        'FO' => 'success',
                                        'INORGANICO' => 'info',
                                        'PELIGROSO' => 'danger',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge badge-{{ $badgeClass }}">
                                    {{ App\Models\Collection::getTiposResiduos()[$collection->tipo_residuo] ?? $collection->tipo_residuo }}
                                </span>
                            </td>
                            <td>
                                <i class="fas fa-calendar-alt text-primary"></i>
                                {{ $collection->fecha_programada->format('d/m/Y') }}
                            </td>
                            <td class="text-center">
                                {{ $collection->turno_num ?? '-' }}
                            </td>
                            <td class="text-right">
                                @if($collection->peso_kg)
                                    <strong>{{ number_format($collection->peso_kg, 2) }}</strong> kg
                                @else
                                    <span class="text-muted">No registrado</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $estadoBadge = match($collection->estado) {
                                        'pendiente' => 'warning',
                                        'programada' => 'info',
                                        'en_proceso' => 'primary',
                                        'completado' => 'success',
                                        'cancelada' => 'danger',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge badge-{{ $estadoBadge }}">
                                    {{ App\Models\Collection::getEstados()[$collection->estado] ?? $collection->estado }}
                                </span>
                            </td>
                            <td>
                                @if($collection->estado_solicitud)
                                    @php
                                        $solicitudBadge = match($collection->estado_solicitud) {
                                            'solicitado' => 'warning',
                                            'aprobado' => 'success',
                                            'rechazado' => 'danger',
                                            'programado' => 'info',
                                            'completado' => 'success',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge badge-{{ $solicitudBadge }}">
                                        {{ App\Models\Collection::getEstadosSolicitud()[$collection->estado_solicitud] ?? $collection->estado_solicitud }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('collections.show', $collection) }}" 
                                       class="btn btn-info btn-sm" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if(auth()->user()->hasRole(App\Models\User::ROLE_RECOLECTOR) && $collection->estado === 'pendiente')
                                        <a href="{{ route('collections.edit', $collection) }}"
                                           class="btn btn-warning btn-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <a href="{{ route('collections.register-waste', $collection) }}"
                                           class="btn btn-success btn-sm" title="Registrar Residuos">
                                            <i class="fas fa-weight"></i>
                                        </a>
                                        
                                        @if(auth()->user()->can('delete collections'))
                                            <form action="{{ route('collections.destroy', $collection) }}" 
                                                  method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" type="submit" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-adminlte-card>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <style>
        .table td {
            vertical-align: middle;
        }
        .btn-group .btn {
            margin: 0 2px;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            $('#collections-table').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                },
                order: [[0, 'desc']],
                pageLength: 25,
                columnDefs: [
                    { orderable: false, targets: -1 }
                ]
            });

            // Manejar las alertas con SweetAlert2
            @if(session('alert'))
                Swal.fire({
                    icon: "{{ session('alert.type') }}",
                    title: "{{ session('alert.title') }}",
                    text: "{{ session('alert.text') }}",
                    confirmButtonColor: '#3085d6',
                });
            @endif

            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#dc3545'
                });
            @endif

            // Confirmar eliminación con SweetAlert2
            $(document).on('submit', '.delete-form', function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: '¿Está seguro?',
                    text: "Esta acción no se puede revertir",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-trash"></i> Sí, eliminar',
                    cancelButtonText: '<i class="fas fa-times"></i> Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@stop
