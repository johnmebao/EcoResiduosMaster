@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop
@section('content')
<x-adminlte-card theme="lime" theme-mode="outline">
<div class="container-fluid">
    <h1>Nuevo reporte</h1>
    <form action="{{ route('reports.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="usuario_id">Usuario</label>
            <input type="number" name="usuario_id" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="tipo">Tipo</label>
            <input type="text" name="tipo" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="filtros">Filtros</label>
            <textarea name="filtros" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="archivo_path">Archivo</label>
            <input type="text" name="archivo_path" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</x-adminlte-card>
@stop
@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop