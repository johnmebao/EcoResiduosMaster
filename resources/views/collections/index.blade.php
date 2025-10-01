@extends('adminlte::page')

@section('title', 'Recolecciones')

@section('content_header')
@stop

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Recolecciones</h1>
        <div>
            @if(auth()->user()->hasRole('recolector'))
                <a href="{{ route('collections.register-waste') }}" class="btn btn-success mr-2">
                    <i class="fas fa-weight"></i> Registrar Residuos
                </a>
            @endif
            <a href="{{ route('collections.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nueva recolección
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
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
                    @foreach ($collections as $collection)
                    <tr>
                        <td>{{ $collection->id }}</td>
                        <td>{{ $collection->user->name }}</td>
                        <td>{{ $collection->company->name }}</td>
                        <td>{{ $collection->tipo_residuo }}</td>
                        <td>{{ $collection->fecha_programada }}</td>
                        <td>{{ $collection->peso_kg ?? 'No registrado' }}</td>
                        <td>
                            <span class="badge badge-{{ $collection->estado === 'pendiente' ? 'warning' : ($collection->estado === 'completado' ? 'success' : ($collection->estado === 'en_proceso' ? 'info' : 'secondary')) }}">
                                {{ App\Models\Collection::getEstados()[$collection->estado] }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('collections.show', $collection) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('collections.edit', $collection) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if(auth()->user()->can('delete collections'))
                            <form action="{{ route('collections.destroy', $collection) }}" method="POST" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('¿Está seguro de eliminar esta recolección?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@stop

@section('js')
<script>
    $(function () {
        $('table').DataTable({
            "responsive": true,
            "autoWidth": false,
        });
    });
</script>
@stop

