    @extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    
@stop

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Usuario</h1>
            <a href="{{ route('personas.create') }}" class="btn btn-primary">Nueva empresa</a>
            </div>
                <div class="card-body">
                    <table id="sedes-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Nombre</th>
                                <th>Rol</th>
                                <th>Documento</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($personas as $index => $persona)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $persona->nombres }}</td>
                                    <td>{{ $persona->usuario ? $persona->usuario->getRoleNames()->first() : '' }}</td>
                                    <td>{{ $persona->documento }}</td>
                                    <td>
                                        <!-- Aquí puedes poner botones de editar/eliminar -->
                                        
                                        @if ($user->role !== 'Administrador')
                                            <a href="{{ url('personas/edit', $persona->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                            <form action="{{ url('personas/delete/' . $persona->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta persona?')">Eliminar</button>
                                            </form>
                                        @else
                                            <span class="text-muted">No autorizado</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
