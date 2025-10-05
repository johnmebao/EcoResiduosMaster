<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    // Mapeo de días de la semana (1=Lunes, 7=Domingo)
    const DIAS_SEMANA = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
        7 => 'Domingo',
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

    /**
     * Obtener la próxima fecha de recolección según el día de la semana de la ruta
     * 
     * @return Carbon
     */
    public function getProximaFechaRecoleccion()
    {
        $hoy = Carbon::now();
        $diaRuta = $this->dia_semana; // 1=Lunes, 7=Domingo
        
        // Obtener el día de la semana actual (1=Lunes, 7=Domingo)
        $diaActual = $hoy->dayOfWeekIso;
        
        // Calcular días hasta la próxima recolección
        if ($diaRuta >= $diaActual) {
            // La recolección es este mismo día o más adelante en la semana
            $diasHasta = $diaRuta - $diaActual;
        } else {
            // La recolección es la próxima semana
            $diasHasta = 7 - $diaActual + $diaRuta;
        }
        
        return $hoy->copy()->addDays($diasHasta);
    }

    /**
     * Obtener todas las fechas de recolección para las próximas N semanas
     * 
     * @param int $semanas
     * @return array
     */
    public function getFechasRecoleccionProximasSemanas($semanas = 4)
    {
        $fechas = [];
        $fechaInicial = $this->getProximaFechaRecoleccion();
        
        for ($i = 0; $i < $semanas; $i++) {
            $fechas[] = $fechaInicial->copy()->addWeeks($i);
        }
        
        return $fechas;
    }

    /**
     * Scope: Filtrar rutas activas
     */
    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope: Filtrar por día de la semana
     */
    public function scopePorDiaSemana($query, $dia)
    {
        return $query->where('dia_semana', $dia);
    }

    /**
     * Scope: Filtrar por localidad
     */
    public function scopePorLocalidad($query, $localidadId)
    {
        return $query->where('localidad_id', $localidadId);
    }
}
