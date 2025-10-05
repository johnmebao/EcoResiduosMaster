@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop
@section('content')
    {{-- <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Reportes</h1>
            <a href="{{ route('reports.create') }}" class="btn btn-primary">Nuevo reporte</a>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Tipo</th>
                    <th>Archivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($reports as $report) --}}
                <tr>
                    <td>1</td>
                    <td>Usuario demo</td>
                    <td>General</td>
                    <td>reporte.pdf</td>
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
    </div> --}}
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Empresa</th>
      <th scope="col">Dirr</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>John</td>
      <td>Doe</td>
      <td>@social</td>
    </tr>
  </tbody>
</table>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
