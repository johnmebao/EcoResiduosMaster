@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')

<div class="align-items-right">
<h1>Roles</h1>
    <a href="{{ url('/admin/roles/create') }}" class="btn btn-success ms-auto align-items-right">
                <i class="fas fa-plus me-2"></i> Nuevo Rol
            </a>
    <hr>
</div>
    
@stop

@section('content')
    <x-adminlte-card theme="lime" theme-mode="outline">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Lista de Roles</h3>
            
        </div>
        <div class="card-body">
            <table id="sedes-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $index => $rol)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $rol->name }}</td>
                            <td>
                                <!-- Aquí puedes poner botones de editar/eliminar -->
                                <a href="{{ url('/admin/roles/edit', $rol->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                <a href="{{ url('/admin/roles/permisos', $rol->id) }}" class="btn btn-sm btn-info">Permisos</a>

                                <form action="{{ url('/admin/roles/delete/' . $rol->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta sede?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-adminlte-card>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>  </script>
@stop