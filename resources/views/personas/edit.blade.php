@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <h1>Actualizar Personal</h1>
@stop

@section('content')
    <x-adminlte-card theme="lime" theme-mode="outline">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Actualizar Persona</h3>

        </div>
        <div class="card-body">
            <form action="{{ route('personas.update', $personal->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <div class="form-group">
                        <label for="">Nombre Rol</label>
                        <select class="form-control" name="rol_id" id="rol_id" required>
                            <option value="">Seleccione un rol</option>
                            @foreach ($roles as $rol)
                                <option value="{{ $rol->id }}" @if(isset($personal->usuario) && $personal->usuario->roles->first() && $personal->usuario->roles->first()->id == $rol->id) selected @endif>{{ $rol->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('rol_id')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="nombres" class="form-label">Nombres</label>
                    <input type="text" value="{{ $personal->nombres }}" class="form-control" id="nombres" name="nombres" required>
                    @error('nombres')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="documento" class="form-label">Documento</label>
                    <input type="text" value="{{ $personal->documento }}" class="form-control" id="documento" name="documento" required>
                    @error('documento')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">  
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" value="{{ $personal->email }}" class="form-control" id="email" name="email" required>
                    @error('email')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <a href="{{ url('personas') }}" class="btn btn-primary float-right">Cancelar</a>
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
