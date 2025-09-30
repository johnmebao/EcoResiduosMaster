@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop
@section('content')
    <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Configuraciones</h1>
    <a href="{{ route('settings.create') }}" class="btn btn-primary">Nueva configuración</a>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Key</th>
                <th>Value</th>
                <th>Description</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($settings as $setting) --}}
            <tr>
                <td>1</td>
                <td>points_formula</td>
                <td>{"factor":1.5}</td>
                <td>Fórmula de puntos</td>
                <td>
                    <a href="#" class="btn btn-info btn-sm">Ver</a>
                    <a href="#" class="btn btn-warning btn-sm">Editar</a>
                    <form action="#" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
            {{-- @endforeach --}}
        </tbody>
    </table>
</div>
@stop
@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
