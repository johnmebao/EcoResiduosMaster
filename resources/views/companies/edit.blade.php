@extends('layouts.adminlte')
@section('title', 'Editar empresa recolectora')
@section('content')
<div class="container-fluid">
    <h1>Editar empresa recolectora</h1>
    <form action="{{ route('companies.update', 1) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="Empresa demo" required>
        </div>
        <div class="form-group">
            <label for="tipo_residuos">Tipo de residuos</label>
            <input type="text" name="tipo_residuos" class="form-control" value="Orgánico, Inorgánico" required>
        </div>
        <div class="form-group">
            <label for="contacto">Contacto</label>
            <input type="text" name="contacto" class="form-control" value="demo@email.com" required>
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('companies.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
