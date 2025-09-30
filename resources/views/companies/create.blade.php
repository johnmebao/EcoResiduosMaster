@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    
@stop
@section('content')
<x-adminlte-card theme="lime" theme-mode="outline">
<div class="container-fluid">
    <h1>Nueva empresa recolectora</h1>
    <form action="{{ route('companies.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="tipo_residuos">Tipo de residuos</label>
            <input type="text" name="tipo_residuos" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="contacto">Contacto</label>
            <input type="text" name="contacto" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('companies.index') }}" class="btn btn-secondary">Cancelar</a>
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
