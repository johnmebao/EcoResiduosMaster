<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Services\PuntosService;

class CollectionDetail extends Model
{
    use HasFactory;

    protected $table = 'collection_details';

    protected $fillable = [
        'collection_id',
        'tipo_residuo',
        'peso_kg',
        'requisitos_separacion',
        'observaciones',
        'observaciones_separacion'
    ];

    protected $casts = [
        'requisitos_separacion' => 'boolean',
        'peso_kg' => 'decimal:2',
    ];

    /**
     * Boot method para eventos del modelo
     */
    protected static function boot()
    {
        parent::boot();

        // Evento: Después de crear un registro de peso
        static::created(function ($pesoRegistro) {
            // Procesar puntos automáticamente si cumple requisitos
            if ($pesoRegistro->requisitos_separacion && $pesoRegistro->tipo_residuo === 'INORGANICO') {
                $puntosService = app(PuntosService::class);
                $puntosService->procesarPuntos($pesoRegistro);
            }
        });

        // Evento: Después de actualizar un registro de peso
        static::updated(function ($pesoRegistro) {
            // Si se actualizó requisitos_separacion a true, procesar puntos
            if ($pesoRegistro->wasChanged('requisitos_separacion') && $pesoRegistro->requisitos_separacion) {
                if ($pesoRegistro->tipo_residuo === 'INORGANICO') {
                    $puntosService = app(PuntosService::class);
                    $puntosService->procesarPuntos($pesoRegistro);
                }
            }
        });
    }

    // Relación con la recolección
    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    /**
     * Verificar si puede generar puntos
     */
    public function puedeGenerarPuntos()
    {
        return $this->requisitos_separacion 
            && $this->tipo_residuo === 'INORGANICO'
            && $this->peso_kg > 0;
    }
}