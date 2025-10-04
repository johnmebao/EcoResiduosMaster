
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canje extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tienda_id',
        'puntos_canjeados',
        'descuento_obtenido',
        'codigo_canje',
        'estado',
        'fecha_canje',
    ];

    protected $casts = [
        'puntos_canjeados' => 'integer',
        'descuento_obtenido' => 'decimal:2',
        'fecha_canje' => 'datetime',
    ];

    /**
     * Relación con usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con tienda
     */
    public function tienda()
    {
        return $this->belongsTo(Tienda::class);
    }

    /**
     * Scope para canjes pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Scope para canjes usados
     */
    public function scopeUsados($query)
    {
        return $query->where('estado', 'usado');
    }
}
