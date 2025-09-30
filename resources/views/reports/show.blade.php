@extends('layouts.adminlte')
@section('title', 'Detalle reporte')
@section('content')
<div class="container-fluid">
    <h1>Detalle reporte</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Usuario:</strong> Usuario demo</p>
            <p><strong>Tipo:</strong> General</p>
            <p><strong>Archivo:</strong> reporte.pdf</p>
            <p><strong>Filtros:</strong> Demo filtro</p>
            <a href="{{ route('reports.edit', 1) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('reports.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>
@endsection
