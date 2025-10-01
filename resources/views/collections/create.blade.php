@extends('adminlte::page')

@section('title', 'Nueva Recolección')

@section('content_header')
@stop
@section('content')
<x-adminlte-card theme="lime" theme-mode="outline">
    <div class="container-fluid">
        <h1>Nueva recolección</h1>
        <form action="{{ route('collections.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="user_id">Usuario</label>
                <select name="user_id" class="form-control select2" required>
                    <option value="">Seleccione un usuario</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="company_id">Empresa</label>
                <select name="company_id" class="form-control select2" required>
                    <option value="">Seleccione una empresa</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="tipo_residuo">Tipo residuo</label>
                <select name="tipo_residuo" class="form-control" required>
                    <option value="">Seleccione un tipo</option>
                    @foreach(App\Models\Collection::getTiposResiduos() as $key => $tipo)
                        <option value="{{ $key }}">{{ $tipo }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_programada">Fecha programada</label>
                <input type="date" name="fecha_programada" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="estado">Estado</label>
                <select name="estado" class="form-control" required>
                    <option value="">Seleccione un estado</option>
                    @foreach(App\Models\Collection::getEstados() as $key => $estado)
                        <option value="{{ $key }}">{{ $estado }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="notas">Notas</label>
                <textarea name="notas" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="{{ route('collections.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</x-adminlte-card>


@stop
@section('css')
{{-- Add here extra stylesheets --}}
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script>
    console.log("Hi, I'm using the Laravel-AdminLTE package!");
</script>
@stop