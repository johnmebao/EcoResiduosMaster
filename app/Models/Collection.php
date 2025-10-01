<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'tipo_residuo',
        'fecha_programada',
        'peso_kg',
        'estado',
        'notas'
    ];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con la empresa
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Lista de tipos de residuos disponibles
    public static function getTiposResiduos()
    {
        return [
            'Orgánico' => 'Orgánico',
            'Plástico' => 'Plástico',
            'Papel' => 'Papel',
            'Vidrio' => 'Vidrio',
            'Metal' => 'Metal',
            'Otros' => 'Otros'
        ];
    }

    // Lista de estados disponibles
    public static function getEstados()
    {
        return [
            'pendiente' => 'Pendiente',
            'en_proceso' => 'En Proceso',
            'completado' => 'Completado',
            'cancelado' => 'Cancelado'
        ];
    }
}
