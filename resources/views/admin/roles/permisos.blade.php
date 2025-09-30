@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')

<div class="align-items-right">
<h1>Permisos x Role a {{ $rol->name }}</h1>
    <hr>
</div>
    
@stop

@section('content')
    <x-adminlte-card theme="lime" theme-mode="outline">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Lista de Roles</h3>
            
        </div>
        <div class="card-body">
            <form action="{{ url('/admin/roles/permisos/' . $rol->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    @foreach ($permisos as $grupo => $permisosGrupo)
                        <div class="col-md-4">
                            <h5>{{ $grupo }}</h5>
                            <ul>
                                @foreach ($permisosGrupo as $permiso)
                                    <div class="form-check">
                                        <input type="checkbox" name="permisos[]" value="{{ $permiso->id }}" id="permiso_{{ $permiso->id }}" class="form-check-input" @if ($rol->hasPermissionTo($permiso->name)) checked @endif>
                                        <label for="permiso_{{ $permiso->id }}" class="form-check-label"> {{ $permiso->name }} </label>
                                    </div>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
                

                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-primary float-right">Cancelar</a>
                            <button type="submit" class="btn btn-success float-right mr-2">Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
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