
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'localidad_id',
        'ruta_id',
        'tipo_residuo',
        'programada',
        'fecha_programada',
        'turno_num',
        'peso_kg',
        'estado',
        'notas',
    ];

    protected $casts = [
        'programada' => 'boolean',
        'fecha_programada' => 'date',
        'peso_kg' => 'decimal:2',
    ];

    /**
     * Relación: Una recolección pertenece a un usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Una recolección pertenece a una empresa
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relación: Una recolección pertenece a una localidad
     */
    public function localidad()
    {
        return $this->belongsTo(Localidad::class);
    }

    /**
     * Relación: Una recolección pertenece a una ruta
     */
    public function ruta()
    {
        return $this->belongsTo(Ruta::class);
    }

    /**
     * Relación: Una recolección tiene muchos detalles
     */
    public function details()
    {
        return $this->hasMany(CollectionDetail::class);
    }
}
