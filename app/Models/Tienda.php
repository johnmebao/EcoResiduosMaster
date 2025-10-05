<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'descuento_porcentaje',
        'puntos_requeridos',
        'activo',
    ];

    protected $casts = [
        'descuento_porcentaje' => 'decimal:2',
        'puntos_requeridos' => 'integer',
        'activo' => 'boolean',
    ];

    /**
     * Relación con canjes
     */
    public function canjes()
    {
        return $this->hasMany(Canje::class);
    }

    /**
     * Scope para tiendas activas
     */
    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }
}
