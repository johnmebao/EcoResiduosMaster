@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Recolecciones</h1>
        <a href="{{ route('collections.create') }}" class="btn btn-primary">Nueva recolección</a>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Empresa</th>
                <th>Tipo residuo</th>
                <th>Fecha programada</th>
                <th>Peso (kg)</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($collections as $collection) --}}
            <tr>
                <td>1</td>
                <td>Usuario demo</td>
                <td>Empresa demo</td>
                <td>Orgánico</td>
                <td>2025-09-30</td>
                <td>10.5</td>
                <td>pendiente</td>
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
@endsection
