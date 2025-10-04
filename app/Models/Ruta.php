
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'localidad_id',
        'company_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'capacidad_max',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
    ];

    /**
     * Relación: Una ruta pertenece a una localidad
     */
    public function localidad()
    {
        return $this->belongsTo(Localidad::class);
    }

    /**
     * Relación: Una ruta pertenece a una empresa
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relación: Una ruta tiene muchas recolecciones
     */
    public function collections()
    {
        return $this->hasMany(Collection::class);
    }
}
