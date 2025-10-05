<?php

namespace App\Repositories;

use App\Models\Collection;
use Illuminate\Support\Facades\DB;

class RecoleccionRepository
{
    /**
     * Buscar recolecciones por usuario
     */
    public function findByUser(int $userId)
    {
        return Collection::where('user_id', $userId)
            ->with(['tipoResiduo', 'empresa', 'localidad', 'ruta', 'detail'])
            ->orderBy('fecha_recoleccion', 'desc')
            ->get();
    }

    /**
     * Buscar recolecciones por localidad
     */
    public function findByLocalidad(int $localidadId, array $filters = [])
    {
        $query = Collection::where('localidad_id', $localidadId)
            ->with(['tipoResiduo', 'empresa', 'user', 'detail']);

        if (isset($filters['fecha_inicio'])) {
            $query->where('fecha_recoleccion', '>=', $filters['fecha_inicio']);
        }

        if (isset($filters['fecha_fin'])) {
            $query->where('fecha_recoleccion', '<=', $filters['fecha_fin']);
        }

        if (isset($filters['tipo_residuo_id'])) {
            $query->where('tipo_residuo_id', $filters['tipo_residuo_id']);
        }

        return $query->orderBy('fecha_recoleccion', 'desc')->get();
    }

    /**
     * Buscar recolecciones por empresa
     */
    public function findByEmpresa(int $empresaId, array $filters = [])
    {
        $query = Collection::where('empresa_id', $empresaId)
            ->with(['tipoResiduo', 'localidad', 'user', 'detail']);

        if (isset($filters['fecha_inicio'])) {
            $query->where('fecha_recoleccion', '>=', $filters['fecha_inicio']);
        }

        if (isset($filters['fecha_fin'])) {
            $query->where('fecha_recoleccion', '<=', $filters['fecha_fin']);
        }

        if (isset($filters['tipo_residuo_id'])) {
            $query->where('tipo_residuo_id', $filters['tipo_residuo_id']);
        }

        return $query->orderBy('fecha_recoleccion', 'desc')->get();
    }

    /**
     * Obtener estadísticas por localidad
     */
    public function getEstadisticasPorLocalidad(int $localidadId, array $filters = [])
    {
        $query = Collection::where('localidad_id', $localidadId)
            ->join('collection_details', 'collections.id', '=', 'collection_details.collection_id')
            ->join('tipos_residuo', 'collections.tipo_residuo_id', '=', 'tipos_residuo.id')
            ->select(
                'tipos_residuo.nombre as tipo_residuo',
                DB::raw('COUNT(collections.id) as total_recolecciones'),
                DB::raw('SUM(collection_details.peso_kg) as total_kg')
            )
            ->groupBy('tipos_residuo.id', 'tipos_residuo.nombre');

        if (isset($filters['fecha_inicio'])) {
            $query->where('collections.fecha_recoleccion', '>=', $filters['fecha_inicio']);
        }

        if (isset($filters['fecha_fin'])) {
            $query->where('collections.fecha_recoleccion', '<=', $filters['fecha_fin']);
        }

        return $query->get();
    }

    /**
     * Obtener estadísticas por empresa
     */
    public function getEstadisticasPorEmpresa(int $empresaId, array $filters = [])
    {
        $query = Collection::where('empresa_id', $empresaId)
            ->join('collection_details', 'collections.id', '=', 'collection_details.collection_id')
            ->join('tipos_residuo', 'collections.tipo_residuo_id', '=', 'tipos_residuo.id')
            ->select(
                'tipos_residuo.nombre as tipo_residuo',
                DB::raw('COUNT(collections.id) as total_recolecciones'),
                DB::raw('SUM(collection_details.peso_kg) as total_kg')
            )
            ->groupBy('tipos_residuo.id', 'tipos_residuo.nombre');

        if (isset($filters['fecha_inicio'])) {
            $query->where('collections.fecha_recoleccion', '>=', $filters['fecha_inicio']);
        }

        if (isset($filters['fecha_fin'])) {
            $query->where('collections.fecha_recoleccion', '<=', $filters['fecha_fin']);
        }

        if (isset($filters['tipo_residuo_id'])) {
            $query->where('collections.tipo_residuo_id', $filters['tipo_residuo_id']);
        }

        return $query->get();
    }

    /**
     * Obtener recolecciones pendientes de aprobación
     */
    public function getPendientesAprobacion()
    {
        return Collection::where('estado_solicitud', 'pendiente')
            ->with(['user', 'tipoResiduo', 'localidad', 'detail'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Obtener recolecciones del día
     */
    public function getRecoleccionesDelDia()
    {
        return Collection::whereDate('fecha_recoleccion', today())
            ->where('estado', 'programada')
            ->with(['user', 'tipoResiduo', 'empresa', 'localidad'])
            ->get();
    }
}
