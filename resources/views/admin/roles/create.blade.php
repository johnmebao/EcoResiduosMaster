@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <h1>Registro Rol</h1>
@stop

@section('content')
    <x-adminlte-card theme="lime" theme-mode="outline">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Nueva Rol</h3>

        </div>
        <div class="card-body">
            <form action="{{ url('/admin/roles/create') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" value="{{ old('name') }}" name="name" required>
                </div>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
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

@stop

@section('js')
    <script>
        
    </script>
@stop
