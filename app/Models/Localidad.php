
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Relación: Una localidad tiene muchas rutas
     */
    public function rutas()
    {
        return $this->hasMany(Ruta::class);
    }

    /**
     * Relación: Una localidad tiene muchas recolecciones
     */
    public function collections()
    {
        return $this->hasMany(Collection::class);
    }
}
