@extends('layouts.adminlte')
@section('title', 'Editar configuración')
@section('content')
<div class="container-fluid">
    <h1>Editar configuración</h1>
    <form action="{{ route('settings.update', 1) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="key">Key</label>
            <input type="text" name="key" class="form-control" value="points_formula" required>
        </div>
        <div class="form-group">
            <label for="value">Value</label>
            <textarea name="value" class="form-control" required>{"factor":1.5}</textarea>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" name="description" class="form-control" value="Fórmula de puntos">
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('settings.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
