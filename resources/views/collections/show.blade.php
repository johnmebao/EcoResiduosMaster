@extends('layouts.adminlte')
@section('title', 'Detalle recolección')
@section('content')
<div class="container-fluid">
    <h1>Detalle recolección</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Usuario:</strong> Usuario demo</p>
            <p><strong>Empresa:</strong> Empresa demo</p>
            <p><strong>Tipo residuo:</strong> Orgánico</p>
            <p><strong>Fecha programada:</strong> 2025-09-30</p>
            <p><strong>Peso (kg):</strong> 10.5</p>
            <p><strong>Estado:</strong> pendiente</p>
            <p><strong>Notas:</strong> Demo nota</p>
            <a href="{{ route('collections.edit', 1) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('collections.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>
@endsection
