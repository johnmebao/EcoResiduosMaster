
@extends('adminlte::page')

@section('title', 'Editar Recolección')

@section('content_header')
    <h1><i class="fas fa-edit"></i> Editar Recolección #{{ $collection->id }}</h1>
@stop

@section('content')
<div class="container-fluid">
    <x-adminlte-card theme="warning" theme-mode="outline" icon="fas fa-edit" title="Formulario de Edición">
        <form action="{{ route('collections.update', $collection) }}" method="POST" id="collection-form">
            @csrf
            @method('PUT')
            
            <div class="row">
                {{-- Usuario --}}
                <div class="col-md-6">
                    <x-adminlte-select2 name="user_id" label="Usuario" label-class="text-primary" 
                        data-placeholder="Seleccione un usuario..." required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-primary">
                                <i class="fas fa-user"></i>
                            </div>
                        </x-slot>
                        <option value="">Seleccione un usuario</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $collection->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </x-adminlte-select2>
                </div>

                {{-- Empresa --}}
                <div class="col-md-6">
                    <x-adminlte-select2 name="company_id" label="Empresa" label-class="text-primary"
                        data-placeholder="Seleccione una empresa..." required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-primary">
                                <i class="fas fa-building"></i>
                            </div>
                        </x-slot>
                        <option value="">Seleccione una empresa</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ $collection->company_id == $company->id ? 'selected' : '' }}>
                                {{ $company->nombre }}
                            </option>
                        @endforeach
                    </x-adminlte-select2>
                </div>
            </div>

            <div class="row">
                {{-- Localidad --}}
                <div class="col-md-6">
                    <x-adminlte-select2 name="localidad_id" label="Localidad" label-class="text-info"
                        data-placeholder="Seleccione una localidad...">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-info">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                        </x-slot>
                        <option value="">Seleccione una localidad</option>
                        @foreach($localidades as $localidad)
                            <option value="{{ $localidad->id }}" {{ $collection->localidad_id == $localidad->id ? 'selected' : '' }}>
                                {{ $localidad->nombre }}
                            </option>
                        @endforeach
                    </x-adminlte-select2>
                </div>

                {{-- Ruta --}}
                <div class="col-md-6">
                    <x-adminlte-select2 name="ruta_id" label="Ruta" label-class="text-info"
                        data-placeholder="Seleccione una ruta...">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-info">
                                <i class="fas fa-route"></i>
                            </div>
                        </x-slot>
                        <option value="">Seleccione una ruta</option>
                        @foreach($rutas as $ruta)
                            <option value="{{ $ruta->id }}" {{ $collection->ruta_id == $ruta->id ? 'selected' : '' }}>
                                {{ $ruta->nombre }} - {{ $ruta->localidad->nombre ?? 'Sin localidad' }}
                            </option>
                        @endforeach
                    </x-adminlte-select2>
                </div>
            </div>

            <div class="row">
                {{-- Tipo de Residuo --}}
                <div class="col-md-6">
                    <x-adminlte-select name="tipo_residuo" label="Tipo de Residuo" label-class="text-success" required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-success">
                                <i class="fas fa-trash-alt"></i>
                            </div>
                        </x-slot>
                        <option value="">Seleccione un tipo</option>
                        @foreach(App\Models\Collection::getTiposResiduos() as $key => $tipo)
                            <option value="{{ $key }}" {{ $collection->tipo_residuo == $key ? 'selected' : '' }}>
                                {{ $tipo }}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                </div>

                {{-- Fecha Programada --}}
                <div class="col-md-6">
                    <x-adminlte-input-date name="fecha_programada" label="Fecha Programada" 
                        label-class="text-warning" value="{{ $collection->fecha_programada->format('Y-m-d') }}" required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-warning">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                </div>
            </div>

            <div class="row">
                {{-- Turno --}}
                <div class="col-md-4">
                    <x-adminlte-input name="turno_num" label="Número de Turno" type="number" 
                        label-class="text-secondary" value="{{ $collection->turno_num }}" min="1">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-secondary">
                                <i class="fas fa-hashtag"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>

                {{-- Peso --}}
                <div class="col-md-4">
                    <x-adminlte-input name="peso_kg" label="Peso (kg)" type="number" step="0.01"
                        label-class="text-secondary" value="{{ $collection->peso_kg }}" min="0">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-secondary">
                                <i class="fas fa-weight"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>

                {{-- Estado --}}
                <div class="col-md-4">
                    <x-adminlte-select name="estado" label="Estado" label-class="text-danger" required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-danger">
                                <i class="fas fa-flag"></i>
                            </div>
                        </x-slot>
                        <option value="">Seleccione un estado</option>
                        @foreach(App\Models\Collection::getEstados() as $key => $estado)
                            <option value="{{ $key }}" {{ $collection->estado == $key ? 'selected' : '' }}>
                                {{ $estado }}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                </div>
            </div>

            {{-- Sección para Residuos Peligrosos --}}
            <div id="peligrosos-section" style="display: {{ $collection->tipo_residuo === 'PELIGROSO' ? 'block' : 'none' }};">
                <hr>
                <h5 class="text-danger"><i class="fas fa-exclamation-triangle"></i> Información de Residuos Peligrosos</h5>
                
                <div class="row">
                    {{-- Estado de Solicitud --}}
                    <div class="col-md-6">
                        <x-adminlte-select name="estado_solicitud" label="Estado de Solicitud" label-class="text-danger">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-danger">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                            </x-slot>
                            <option value="">Seleccione un estado</option>
                            @foreach(App\Models\Collection::getEstadosSolicitud() as $key => $estado)
                                <option value="{{ $key }}" {{ $collection->estado_solicitud == $key ? 'selected' : '' }}>
                                    {{ $estado }}
                                </option>
                            @endforeach
                        </x-adminlte-select>
                    </div>

                    {{-- Fecha de Solicitud --}}
                    <div class="col-md-6">
                        <x-adminlte-input-date name="fecha_solicitud" label="Fecha de Solicitud" 
                            label-class="text-danger" value="{{ $collection->fecha_solicitud ? $collection->fecha_solicitud->format('Y-m-d') : '' }}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-danger">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-date>
                    </div>
                </div>

                <div class="row">
                    {{-- Fecha de Aprobación --}}
                    <div class="col-md-6">
                        <x-adminlte-input-date name="fecha_aprobacion" label="Fecha de Aprobación" 
                            label-class="text-success" value="{{ $collection->fecha_aprobacion ? $collection->fecha_aprobacion->format('Y-m-d') : '' }}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-success">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-date>
                    </div>

                    {{-- Aprobado Por --}}
                    <div class="col-md-6">
                        <x-adminlte-select2 name="aprobado_por" label="Aprobado Por" label-class="text-success"
                            data-placeholder="Seleccione un usuario...">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-success">
                                    <i class="fas fa-user-check"></i>
                                </div>
                            </x-slot>
                            <option value="">Seleccione un usuario</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $collection->aprobado_por == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                </div>

                {{-- Motivo de Rechazo --}}
                <div class="row">
                    <div class="col-md-12">
                        <x-adminlte-textarea name="motivo_rechazo" label="Motivo de Rechazo" 
                            rows="3" label-class="text-danger" placeholder="Ingrese el motivo del rechazo...">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-danger">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                            </x-slot>
                            {{ $collection->motivo_rechazo }}
                        </x-adminlte-textarea>
                    </div>
                </div>
            </div>

            {{-- Notas --}}
            <div class="row">
                <div class="col-md-12">
                    <x-adminlte-textarea name="notas" label="Notas" rows="3" 
                        label-class="text-info" placeholder="Ingrese notas adicionales...">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-info">
                                <i class="fas fa-sticky-note"></i>
                            </div>
                        </x-slot>
                        {{ $collection->notas }}
                    </x-adminlte-textarea>
                </div>
            </div>

            {{-- Botones --}}
            <div class="row">
                <div class="col-md-12">
                    <x-adminlte-button type="submit" label="Actualizar Recolección" theme="warning" icon="fas fa-save"/>
                    <x-adminlte-button label="Cancelar" theme="secondary" icon="fas fa-times" 
                        onclick="window.location='{{ route('collections.index') }}'"/>
                </div>
            </div>
        </form>
    </x-adminlte-card>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .input-group-text {
            min-width: 45px;
            justify-content: center;
        }
    </style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Mostrar/ocultar sección de residuos peligrosos
    $('select[name="tipo_residuo"]').on('change', function() {
        if ($(this).val() === 'PELIGROSO') {
            $('#peligrosos-section').slideDown();
        } else {
            $('#peligrosos-section').slideUp();
        }
    });

    // Validación del formulario
    $('#collection-form').submit(function(e) {
        e.preventDefault();
        const form = this;

        Swal.fire({
            title: '¿Confirmar actualización?',
            text: "Se actualizarán los datos de esta recolección",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-check"></i> Sí, actualizar',
            cancelButtonText: '<i class="fas fa-times"></i> Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // Mostrar errores de validación
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Errores de validación',
            html: '<ul style="text-align: left;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            confirmButtonColor: '#dc3545'
        });
    @endif

    // Mostrar mensaje de éxito
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
