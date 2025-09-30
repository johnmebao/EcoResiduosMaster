@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop
@section('content')
<x-adminlte-card theme="lime" theme-mode="outline">
<div class="container-fluid">
    <h1>Nueva configuración</h1>
    <form action="{{ url('settings.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="key">Key</label>
            <input type="text" name="key" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="value">Value</label>
            <textarea name="value" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" name="description" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ url('settings') }}" class="btn btn-secondary">Cancelar</a>
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
