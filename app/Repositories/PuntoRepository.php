<?php

namespace App\Repositories;

use App\Models\Point;
use App\Models\Collection;
use Illuminate\Support\Facades\DB;

class PuntoRepository
{
    /**
     * Obtener total de puntos por usuario
     */
    public function getTotalPuntosByUser(int $userId): array
    {
        $point = Point::where('user_id', $userId)->first();

        if (!$point) {
            return [
                'total_points' => 0,
                'available_points' => 0,
            ];
        }

        return [
            'total_points' => $point->total_points,
            'available_points' => $point->available_points,
        ];
    }

    /**
     * Obtener historial de puntos (recolecciones completadas)
     */
    public function getHistorialPuntos(int $userId)
    {
        return Collection::where('user_id', $userId)
            ->where('estado', 'completada')
            ->join('collection_details', 'collections.id', '=', 'collection_details.collection_id')
            ->join('tipos_residuo', 'collections.tipo_residuo_id', '=', 'tipos_residuo.id')
            ->select(
                'collections.id',
                'collections.fecha_recoleccion',
                'tipos_residuo.nombre as tipo_residuo',
                'collection_details.peso_kg',
                DB::raw('collection_details.peso_kg as puntos_ganados')
            )
            ->orderBy('collections.fecha_recoleccion', 'desc')
            ->get();
    }

    /**
     * Obtener estadísticas de puntos por tipo de residuo
     */
    public function getEstadisticasPorTipo(int $userId)
    {
        return Collection::where('user_id', $userId)
            ->where('estado', 'completada')
            ->join('collection_details', 'collections.id', '=', 'collection_details.collection_id')
            ->join('tipos_residuo', 'collections.tipo_residuo_id', '=', 'tipos_residuo.id')
            ->select(
                'tipos_residuo.nombre as tipo_residuo',
                DB::raw('COUNT(collections.id) as total_recolecciones'),
                DB::raw('SUM(collection_details.peso_kg) as total_kg'),
                DB::raw('SUM(collection_details.peso_kg) as total_puntos')
            )
            ->groupBy('tipos_residuo.id', 'tipos_residuo.nombre')
            ->get();
    }

    /**
     * Obtener ranking de usuarios por puntos
     */
    public function getRankingUsuarios(int $limit = 10)
    {
        return Point::join('users', 'points.user_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.name',
                'points.total_points',
                'points.available_points'
            )
            ->orderBy('points.total_points', 'desc')
            ->limit($limit)
            ->get();
    }
}
