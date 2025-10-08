
@extends('adminlte::page')

@section('title', 'Configuraciones del Sistema')

@section('content_header')
    <h1>
        <i class="fas fa-cogs"></i> Configuraciones del Sistema
    </h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i> Listado de Configuraciones
                    </h3>
                    <a href="{{ route('settings.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nueva Configuración
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if($settings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" id="settingsTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width: 5%">ID</th>
                                    <th style="width: 20%">Clave</th>
                                    <th style="width: 25%">Valor</th>
                                    <th style="width: 30%">Descripción</th>
                                    <th style="width: 10%">Fecha Creación</th>
                                    <th style="width: 10%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($settings as $setting)
                                <tr>
                                    <td>{{ $setting->id }}</td>
                                    <td>
                                        <strong>{{ $setting->key }}</strong>
                                    </td>
                                    <td>
                                        <code>{{ Str::limit($setting->value, 50) }}</code>
                                    </td>
                                    <td>{{ $setting->description ?? 'Sin descripción' }}</td>
                                    {{-- <td>{{ $setting->created_at->format('d/m/Y') }}</td> --}}
                                    <td>{{ $setting->created_at?->format('d/m/Y') ?? '—' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('settings.edit', $setting->id) }}" 
                                               class="btn btn-warning btn-sm" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm" 
                                                    onclick="confirmDelete({{ $setting->id }}, '{{ $setting->key }}')"
                                                    title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $setting->id }}" 
                                              action="{{ url('settings.destroy', $setting->id) }}" 
                                              method="POST" 
                                              style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> No hay configuraciones registradas en el sistema.
                        <a href="{{ route('settings.create') }}" class="alert-link">Crear la primera configuración</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Información sobre configuraciones importantes -->
        <div class="card card-info mt-3">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Configuraciones Importantes para Canjes
                </h3>
            </div>
            <div class="card-body">
                <p><strong>Configuraciones recomendadas para el sistema de puntos y canjes:</strong></p>
                <ul>
                    <li><code>puntos_por_kg</code>: Puntos otorgados por cada kilogramo de residuo recolectado (ej: 10)</li>
                    <li><code>puntos_minimos_canje</code>: Puntos mínimos requeridos para realizar un canje (ej: 50)</li>
                    <li><code>factor_conversion</code>: Factor de conversión para cálculos especiales (ej: 1.5)</li>
                    <li><code>puntos_bienvenida</code>: Puntos otorgados al registrarse (ej: 100)</li>
                </ul>
                <p class="text-muted mb-0">
                    <i class="fas fa-lightbulb"></i> 
                    Estas configuraciones se utilizan en el cálculo automático de puntos cuando se registran recolecciones.
                </p>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <style>
        .table thead th {
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
            $('#settingsTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                },
                order: [[0, 'asc']],
                pageLength: 25
            });
        });

        function confirmDelete(id, key) {
            Swal.fire({
                title: '¿Estás seguro?',
                html: `¿Deseas eliminar la configuración <strong>${key}</strong>?<br>Esta acción no se puede deshacer.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
@stop
