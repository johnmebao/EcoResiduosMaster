@extends('adminlte::page')

@section('title', 'Empresas Recolectoras')

@section('content_header')
@stop

@section('content')
<div class="container-fluid">
    <br>
    <x-adminlte-card theme="lime" theme-mode="outline">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Empresas recolectoras</h1>
            <a href="{{ route('companies.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nueva empresa
            </a>
        </div>
    </x-adminlte-card>
    <br>
    <x-adminlte-card theme="lime" theme-mode="outline">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="companies-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Tipo de residuos</th>
                        <th>Contacto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($companies as $company)
                    <tr>
                        <td>{{ $company->id }}</td>
                        <td>{{ $company->nombre }}</td>
                        <td>{{ $company->tipo_residuos }}</td>
                        <td>{{ $company->contacto }}</td>
                        <td>
                            <a href="{{ route('companies.show', $company) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('companies.edit', $company) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('companies.destroy', $company) }}" method="POST" 
                                  style="display:inline-block" 
                                  onsubmit="return confirm('¿Está seguro de eliminar esta empresa?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-adminlte-card>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#companies-table').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        }
    });

    // Mostrar mensaje de éxito si existe
    @if(session('success'))
        Sweetalert2.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
});
</script>
@stop
