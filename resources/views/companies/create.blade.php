@extends('adminlte::page')

@section('title', 'Nueva Empresa Recolectora')

@section('content_header')
@stop

@section('content')
<div class="container-fluid">
    <x-adminlte-card theme="lime" theme-mode="outline">
        <h1>Nueva empresa recolectora</h1>
        <form action="{{ route('companies.store') }}" method="POST" id="company-form">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre <span class="text-danger">*</span></label>
                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" 
                       value="{{ old('nombre') }}" required>
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tipo_residuos">Tipo de residuos <span class="text-danger">*</span></label>
                <select name="tipo_residuos[]" class="form-control select2 @error('tipo_residuos') is-invalid @enderror" 
                        multiple required>
                    @foreach(App\Models\Collection::getTiposResiduos() as $key => $tipo)
                        <option value="{{ $key }}">{{ $tipo }}</option>
                    @endforeach
                </select>
                @error('tipo_residuos')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="contacto">Contacto <span class="text-danger">*</span></label>
                <input type="text" name="contacto" class="form-control @error('contacto') is-invalid @enderror" 
                       value="{{ old('contacto') }}" required>
                @error('contacto')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <a href="{{ route('companies.index') }}" class="btn btn-secondary">
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
        theme: 'bootstrap4',
        placeholder: 'Seleccione los tipos de residuos',
        tags: true
    });

    // Manejo del formulario
    $('#company-form').on('submit', function(e) {
        e.preventDefault();
        const form = this;
        
        Swal.fire({
            title: '¿Está seguro?',
            text: "¿Desea guardar esta empresa recolectora?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // Mostrar errores si existen
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor corrija los errores en el formulario',
        });
    @endif
});
</script>
@stop
