@extends('adminlte::page')

@section('title', 'Registrar Residuos')

@section('content_header')
    <h1>Registrar Residuos de la Recolección</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('collections.update-waste', $collection) }}" method="POST" id="waste-form">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Información de la Recolección</label>
                            <p><strong>Usuario:</strong> {{ $collection->user->name }}</p>
                            <p><strong>Empresa:</strong> {{ $collection->company->name }}</p>
                            <p><strong>Fecha Programada:</strong> {{ $collection->fecha_programada }}</p>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Registro de Residuos</h3>
                        <button type="button" class="btn btn-sm btn-success float-right" id="add-waste">
                            <i class="fas fa-plus"></i> Agregar tipo de residuo
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="waste-items">
                            <div class="waste-item row mb-3">
                                <div class="col-md-6">
                                    <select name="tipos[]" class="form-control" required>
                                        <option value="">Seleccione tipo de residuo</option>
                                        @foreach(App\Models\Collection::getTiposResiduos() as $key => $tipo)
                                            <option value="{{ $key }}">{{ $tipo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input type="number" name="pesos[]" class="form-control" step="0.01" min="0" placeholder="Peso" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">kg</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger remove-waste">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea name="observaciones" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar Registro
                        </button>
                        <a href="{{ route('collections.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .waste-item {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 10px;
    }
</style>
@stop

@section('js')
<script>
$(function() {
    // Agregar nuevo ítem de residuo
    $('#add-waste').click(function() {
        const newItem = $('#waste-items .waste-item').first().clone();
        newItem.find('input').val('');
        newItem.find('select').val('');
        $('#waste-items').append(newItem);
    });

    // Eliminar ítem de residuo
    $(document).on('click', '.remove-waste', function() {
        if ($('#waste-items .waste-item').length > 1) {
            $(this).closest('.waste-item').remove();
        } else {
            alert('Debe haber al menos un tipo de residuo');
        }
    });

    // Validación del formulario
    $('#waste-form').submit(function(e) {
        let isValid = true;
        const tipos = new Set();

        $('.waste-item').each(function() {
            const tipo = $(this).find('select').val();
            const peso = $(this).find('input[type="number"]').val();

            if (!tipo || !peso) {
                isValid = false;
                return false;
            }

            if (tipos.has(tipo)) {
                alert('No puede haber tipos de residuo duplicados');
                isValid = false;
                return false;
            }

            tipos.add(tipo);
        });

        if (!isValid) {
            e.preventDefault();
        }
    });
});
</script>
@stop