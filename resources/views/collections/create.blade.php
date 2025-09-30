@extends('adminlte::page')

@section('title', 'Dashboard')

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
                <input type="number" name="user_id" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="company_id">Empresa</label>
                <input type="number" name="company_id" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="tipo_residuo">Tipo residuo</label>
                <input type="text" name="tipo_residuo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="fecha_programada">Fecha programada</label>
                <input type="date" name="fecha_programada" class="form-control">
            </div>
            <div class="form-group">
                <label for="peso_kg">Peso (kg)</label>
                <input type="number" step="0.01" name="peso_kg" class="form-control">
            </div>
            <div class="form-group">
                <label for="estado">Estado</label>
                <input type="text" name="estado" class="form-control" required>
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