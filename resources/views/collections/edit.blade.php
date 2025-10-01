@extends('adminlte::page')

@section('title', 'Editar Recolección')

@section('content_header')
@stop

@section('content')
<div class="container-fluid">
    <x-adminlte-card theme="lime" theme-mode="outline">
        <h1>Editar recolección</h1>
        <form action="{{ route('collections.update', $collection) }}" method="POST" id="collection-form">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="user_id">Usuario <span class="text-danger">*</span></label>
                <select name="user_id" class="form-control select2" required>
                    <option value="">Seleccione un usuario</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $collection->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="company_id">Empresa <span class="text-danger">*</span></label>
                <select name="company_id" class="form-control select2" required>
                    <option value="">Seleccione una empresa</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ $collection->company_id == $company->id ? 'selected' : '' }}>
                            {{ $company->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tipo_residuo">Tipo residuo <span class="text-danger">*</span></label>
                <select name="tipo_residuo" class="form-control" required>
                    <option value="">Seleccione un tipo</option>
                    @foreach(App\Models\Collection::getTiposResiduos() as $key => $tipo)
                        <option value="{{ $key }}" {{ $collection->tipo_residuo == $key ? 'selected' : '' }}>
                            {{ $tipo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="fecha_programada">Fecha programada <span class="text-danger">*</span></label>
                <input type="date" name="fecha_programada" class="form-control" 
                       value="{{ $collection->fecha_programada }}" required>
            </div>

            <div class="form-group">
                <label for="estado">Estado <span class="text-danger">*</span></label>
                <select name="estado" class="form-control" required>
                    <option value="">Seleccione un estado</option>
                    @foreach(App\Models\Collection::getEstados() as $key => $estado)
                        <option value="{{ $key }}" {{ $collection->estado == $key ? 'selected' : '' }}>
                            {{ $estado }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="notas">Notas</label>
                <textarea name="notas" class="form-control">{{ $collection->notas }}</textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Actualizar
                </button>
                <a href="{{ route('collections.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </x-adminlte-card>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap4'
    });

    $('#collection-form').submit(function(e) {
        e.preventDefault();
        const form = this;

        Swal.fire({
            title: '¿Está seguro?',
            text: "¿Desea actualizar esta recolección?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor corrija los errores en el formulario'
        });
    @endif

    @if(session('success'))
        Swal.fire({
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

