@extends('adminlte::page')

@section('title', 'Error 403')

@section('content_header')
    <h1>Página Prohibida</h1>
@stop

@section('content')
    <p>Lo sentimos, pero no tienes permiso para acceder a esta página.</p>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
