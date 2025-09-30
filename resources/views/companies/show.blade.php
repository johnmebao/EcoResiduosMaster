@extends('layouts.adminlte')
@section('title', 'Detalle empresa recolectora')
@section('content')
<div class="container-fluid">
    <h1>Detalle empresa recolectora</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Nombre:</strong> Empresa demo</p>
            <p><strong>Tipo de residuos:</strong> Orgánico, Inorgánico</p>
            <p><strong>Contacto:</strong> demo@email.com</p>
            <a href="{{ route('companies.edit', 1) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('companies.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>
@endsection
