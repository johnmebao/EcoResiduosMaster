@extends('layouts.adminlte')
@section('title', 'Editar recolección')
@section('content')
<div class="container-fluid">
    <h1>Editar recolección</h1>
    <form action="{{ route('collections.update', 1) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="user_id">Usuario</label>
            <input type="number" name="user_id" class="form-control" value="1" required>
        </div>
        <div class="form-group">
            <label for="company_id">Empresa</label>
            <input type="number" name="company_id" class="form-control" value="1" required>
        </div>
        <div class="form-group">
            <label for="tipo_residuo">Tipo residuo</label>
            <input type="text" name="tipo_residuo" class="form-control" value="Orgánico" required>
        </div>
        <div class="form-group">
            <label for="fecha_programada">Fecha programada</label>
            <input type="date" name="fecha_programada" class="form-control" value="2025-09-30">
        </div>
        <div class="form-group">
            <label for="peso_kg">Peso (kg)</label>
            <input type="number" step="0.01" name="peso_kg" class="form-control" value="10.5">
        </div>
        <div class="form-group">
            <label for="estado">Estado</label>
            <input type="text" name="estado" class="form-control" value="pendiente" required>
        </div>
        <div class="form-group">
            <label for="notas">Notas</label>
            <textarea name="notas" class="form-control">Demo nota</textarea>
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('collections.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
