@extends('adminlte::page')

@section('title', 'Recolecciones')

@section('content_header')
@stop

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Recolecciones</h1>
            <div>
                <a href="{{ route('collections.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nueva recolección
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Empresa</th>
                            <th>Tipo residuo</th>
                            <th>Fecha programada</th>
                            <th>Peso (kg)</th>
                            <th>Estado</th>

                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($collections as $collection)
                            <tr>
                                <td>{{ $collection->id }}</td>
                                <td>{{ $collection->user->name }}</td>
                                <td>{{ $collection->company->nombre }}</td>
                                <td>{{ $collection->tipo_residuo }}</td>
                                <td>{{ $collection->fecha_programada }}</td>
                                <td>{{ $collection->peso_kg ?? 'No registrado' }}</td>
                                <td>
                                    <span
                                        class="badge badge-{{ $collection->estado === 'pendiente' ? 'warning' : ($collection->estado === 'completado' ? 'success' : ($collection->estado === 'en_proceso' ? 'info' : 'secondary')) }}">
                                        {{ App\Models\Collection::getEstados()[$collection->estado] }}
                                    </span>
                                </td>
                                <td>
                                    @if (auth()->user()->hasRole(App\Models\User::ROLE_RECOLECTOR) && $collection->estado === 'pendiente')
                                        <a href="{{ route('collections.show', $collection) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif
                                    @if (auth()->user()->hasRole(App\Models\User::ROLE_RECOLECTOR) && $collection->estado === 'pendiente')
                                        <a href="{{ route('collections.edit', $collection) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif

                                    @if (auth()->user()->hasRole(App\Models\User::ROLE_RECOLECTOR) && $collection->estado === 'pendiente')
                                        <a href="{{ route('collections.register-waste', $collection) }}"
                                            class="btn btn-success btn-sm">
                                            <i class="fas fa-weight"></i> Registrar Residuos
                                        </a>
                                    @endif
                                    @if (auth()->user()->hasRole(App\Models\User::ROLE_RECOLECTOR) && $collection->estado === 'pendiente')
                                        @if (auth()->user()->can('delete collections'))
                                            <form action="{{ route('collections.destroy', $collection) }}" method="POST"
                                                style="display:inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" type="submit"
                                                    onclick="return confirm('¿Está seguro de eliminar esta recolección?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            $('table').DataTable({
                "responsive": true,
                "autoWidth": false,
            });

            // Manejar las alertas con SweetAlert2
            @if (session('alert'))
                Swal.fire({
                    icon: "{{ session('alert.type') }}",
                    title: "{{ session('alert.title') }}",
                    text: "{{ session('alert.text') }}",
                    confirmButtonColor: '#3085d6',
                });
            @endif

            // Confirmar eliminación con SweetAlert2
            $(document).on('click', '.btn-danger', function(e) {
                e.preventDefault();
                const form = $(this).closest('form');

                Swal.fire({
                    title: '¿Está seguro?',
                    text: "Esta acción no se puede revertir",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@stop
