
@extends('adminlte::page')

@section('title', 'Nueva Configuración')

@section('content_header')
    <h1>
        <i class="fas fa-plus-circle"></i> Nueva Configuración
    </h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-cog"></i> Crear Nueva Configuración del Sistema
                        </h3>
                    </div>
                    
                    <form action="{{ route('settings.store') }}" method="POST">
                        @csrf
                        
                        <div class="card-body">
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <!-- Campo: Clave -->
                            <div class="form-group">
                                <label for="key">
                                    Clave <span class="text-danger">*</span>
                                    <i class="fas fa-question-circle" 
                                       data-toggle="tooltip" 
                                       title="Identificador único de la configuración (ej: puntos_por_kg)"></i>
                                </label>
                                <input type="text" 
                                       name="key" 
                                       id="key"
                                       class="form-control @error('key') is-invalid @enderror" 
                                       value="{{ old('key') }}"
                                       placeholder="Ej: puntos_por_kg"
                                       required>
                                @error('key')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">
                                    Use snake_case sin espacios (ej: puntos_por_kg, factor_conversion)
                                </small>
                            </div>

                            <!-- Campo: Valor -->
                            <div class="form-group">
                                <label for="value">
                                    Valor <span class="text-danger">*</span>
                                    <i class="fas fa-question-circle" 
                                       data-toggle="tooltip" 
                                       title="Valor de la configuración (puede ser número, texto o JSON)"></i>
                                </label>
                                <textarea name="value" 
                                          id="value"
                                          class="form-control @error('value') is-invalid @enderror" 
                                          rows="4"
                                          placeholder="Ej: 10 (para puntos por kg) o {&quot;factor&quot;:1.5} (para JSON)"
                                          required>{{ old('value') }}</textarea>
                                @error('value')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">
                                    Para valores numéricos simples use solo el número. Para configuraciones complejas use formato JSON.
                                </small>
                            </div>

                            <!-- Campo: Descripción -->
                            <div class="form-group">
                                <label for="description">
                                    Descripción
                                    <i class="fas fa-question-circle" 
                                       data-toggle="tooltip" 
                                       title="Descripción clara del propósito de esta configuración"></i>
                                </label>
                                <input type="text" 
                                       name="description" 
                                       id="description"
                                       class="form-control @error('description') is-invalid @enderror" 
                                       value="{{ old('description') }}"
                                       placeholder="Ej: Puntos otorgados por cada kilogramo de residuo recolectado"
                                       maxlength="500">
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Ejemplos de configuraciones comunes -->
                            <div class="alert alert-info">
                                <h5><i class="icon fas fa-info"></i> Ejemplos de Configuraciones Comunes:</h5>
                                <ul class="mb-0">
                                    <li><strong>puntos_por_kg:</strong> 10 (puntos por kilogramo)</li>
                                    <li><strong>puntos_minimos_canje:</strong> 50 (puntos mínimos para canjear)</li>
                                    <li><strong>factor_conversion:</strong> 1.5 (factor multiplicador)</li>
                                    <li><strong>puntos_bienvenida:</strong> 100 (puntos al registrarse)</li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Guardar Configuración
                            </button>
                            <a href="{{ route('settings.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .form-group label {
            font-weight: 600;
        }
        .text-danger {
            font-weight: bold;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Activar tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Validación en tiempo real para la clave (solo snake_case)
            $('#key').on('input', function() {
                let value = $(this).val();
                // Reemplazar espacios y caracteres especiales con guión bajo
                value = value.toLowerCase().replace(/[^a-z0-9_]/g, '_');
                $(this).val(value);
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
@stop
