
@extends('adminlte::page')

@section('title', 'Editar Configuración')

@section('content_header')
    <h1>
        <i class="fas fa-edit"></i> Editar Configuración
    </h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-cog"></i> Modificar Configuración: <strong>{{ $setting->key }}</strong>
                        </h3>
                    </div>
                    
                    <form action="{{ url('settings.update', $setting->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="card-body">
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <!-- Información de la configuración -->
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> 
                                <strong>ID:</strong> {{ $setting->id }} | 
                                {{-- <strong>Creada:</strong> {{ $setting->created_at->format('d/m/Y H:i') }} --}}
                                <strong>Creada:</strong> {{ optional($setting->created_at)->format('d/m/Y H:i') ?? '—' }}
                                <strong>Última actualización:</strong>
                                {{ optional($setting->updated_at)->format('d/m/Y') ?? '—' }}


                            </div>

                            <!-- Campo: Clave -->
                            <div class="form-group">
                                <label for="key">
                                    Clave <span class="text-danger">*</span>
                                    <i class="fas fa-question-circle" 
                                       data-toggle="tooltip" 
                                       title="Identificador único de la configuración"></i>
                                </label>
                                <input type="text" 
                                       name="key" 
                                       id="key"
                                       class="form-control @error('key') is-invalid @enderror" 
                                       value="{{ old('key', $setting->key) }}"
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
                                <input type="text" 
                                        name="value" 
                                          id="value"
                                          class="form-control @error('value') is-invalid @enderror" 
                                          value="{{ old('value', $setting->value) }}"
                                          required>
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
                                       value="{{ old('description', $setting->description) }}"
                                       maxlength="500">
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Advertencia sobre cambios críticos -->
                            <div class="alert alert-warning">
                                <h5><i class="icon fas fa-exclamation-triangle"></i> Advertencia:</h5>
                                <p class="mb-0">
                                    Modificar esta configuración puede afectar el cálculo de puntos y canjes en el sistema. 
                                    Asegúrese de comprender el impacto antes de guardar los cambios.
                                </p>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Actualizar Configuración
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
        .card-header h3 {
            margin: 0;
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

            // Confirmación antes de guardar cambios
            $('form').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Confirmar cambios?',
                    text: 'Esta configuración afecta el cálculo de puntos en el sistema.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, actualizar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert-danger').fadeOut('slow');
            }, 5000);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stop
