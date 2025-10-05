<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'estado_solicitud',
        'fecha_solicitud',
        'fecha_aprobacion',
        'aprobado_por',
        'motivo_rechazo',
        'notas',
    ];

    protected $casts = [
        'programada' => 'boolean',
        'fecha_programada' => 'date',
        'fecha_solicitud' => 'datetime',
        'fecha_aprobacion' => 'datetime',
        'peso_kg' => 'decimal:2',
    ];

    // Constantes para tipos de residuo
    const TIPO_ORGANICO = 'FO';
    const TIPO_INORGANICO = 'INORGANICO';
    const TIPO_PELIGROSO = 'PELIGROSO';

    // Constantes para estados de solicitud
    const ESTADO_SOLICITADO = 'solicitado';
    const ESTADO_APROBADO = 'aprobado';
    const ESTADO_RECHAZADO = 'rechazado';
    const ESTADO_PROGRAMADO = 'programado';
    const ESTADO_COMPLETADO = 'completado';

    // Método para obtener tipos de residuos disponibles
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

    // Método para obtener estados disponibles
    public static function getEstados()
    {
        return [
            'pendiente' => 'Pendiente',
            'en_proceso' => 'En Proceso',
            'completado' => 'Completado',
            'cancelado' => 'Cancelado'
        ];
    }

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

    /**
     * Relación: Usuario que aprobó la solicitud
     */
    public function aprobador()
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }

    /**
     * Scope: Filtrar por tipo de residuo orgánico
     */
    public function scopeOrganicos($query)
    {
        return $query->where('tipo_residuo', self::TIPO_ORGANICO);
    }

    /**
     * Scope: Filtrar por tipo de residuo inorgánico
     */
    public function scopeInorganicos($query)
    {
        return $query->where('tipo_residuo', self::TIPO_INORGANICO);
    }

    /**
     * Scope: Filtrar por tipo de residuo peligroso
     */
    public function scopePeligrosos($query)
    {
        return $query->where('tipo_residuo', self::TIPO_PELIGROSO);
    }

    /**
     * Scope: Filtrar por estado de solicitud
     */
    public function scopeEstadoSolicitud($query, $estado)
    {
        return $query->where('estado_solicitud', $estado);
    }

    /**
     * Scope: Solicitudes pendientes de aprobación
     */
    public function scopeSolicitudesPendientes($query)
    {
        return $query->where('estado_solicitud', self::ESTADO_SOLICITADO);
    }

    /**
     * Verificar si el usuario tiene una solicitud de peligrosos activa en el mes
     */
    public static function tieneSolicitudPeligrososMesActual($userId)
    {
        return self::where('user_id', $userId)
            ->where('tipo_residuo', self::TIPO_PELIGROSO)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereIn('estado_solicitud', [
                self::ESTADO_SOLICITADO,
                self::ESTADO_APROBADO,
                self::ESTADO_PROGRAMADO
            ])
            ->exists();
    }

    /**
     * Verificar si existe una recolección duplicada
     */
    public static function existeDuplicado($userId, $tipoResiduo, $fechaProgramada)
    {
        return self::where('user_id', $userId)
            ->where('tipo_residuo', $tipoResiduo)
            ->whereDate('fecha_programada', $fechaProgramada)
            ->whereIn('estado', ['pendiente', 'programada'])
            ->exists();
    }
}
