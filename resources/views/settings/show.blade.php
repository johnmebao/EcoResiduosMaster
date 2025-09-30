@extends('layouts.adminlte')
@section('title', 'Detalle configuración')
@section('content')
<div class="container-fluid">
    <h1>Detalle configuración</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Key:</strong> points_formula</p>
            <p><strong>Value:</strong> {"factor":1.5}</p>
            <p><strong>Description:</strong> Fórmula de puntos</p>
            <a href="{{ route('settings.edit', 1) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('settings.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>
@endsection
