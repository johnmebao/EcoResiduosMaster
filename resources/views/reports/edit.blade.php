@extends('layouts.adminlte')
@section('title', 'Editar reporte')
@section('content')
<div class="container-fluid">
    <h1>Editar reporte</h1>
    <form action="{{ route('reports.update', 1) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="usuario_id">Usuario</label>
            <input type="number" name="usuario_id" class="form-control" value="1" required>
        </div>
        <div class="form-group">
            <label for="tipo">Tipo</label>
            <input type="text" name="tipo" class="form-control" value="General" required>
        </div>
        <div class="form-group">
            <label for="filtros">Filtros</label>
            <textarea name="filtros" class="form-control">Demo filtro</textarea>
        </div>
        <div class="form-group">
            <label for="archivo_path">Archivo</label>
            <input type="text" name="archivo_path" class="form-control" value="reporte.pdf">
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
