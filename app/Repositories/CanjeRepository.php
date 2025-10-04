
<?php

namespace App\Repositories;

use App\Models\Canje;
use Illuminate\Support\Facades\DB;

class CanjeRepository
{
    /**
     * Buscar canjes por usuario
     */
    public function findByUser(int $userId)
    {
        return Canje::where('user_id', $userId)
            ->with('tienda')
            ->orderBy('fecha_canje', 'desc')
            ->get();
    }

    /**
     * Obtener estadísticas de canjes
     */
    public function getEstadisticasCanjes(int $userId = null)
    {
        $query = Canje::join('tiendas', 'canjes.tienda_id', '=', 'tiendas.id')
            ->select(
                'tiendas.nombre as tienda',
                DB::raw('COUNT(canjes.id) as total_canjes'),
                DB::raw('SUM(canjes.puntos_canjeados) as total_puntos_canjeados'),
                DB::raw('AVG(canjes.descuento_obtenido) as promedio_descuento')
            )
            ->groupBy('tiendas.id', 'tiendas.nombre');

        if ($userId) {
            $query->where('canjes.user_id', $userId);
        }

        return $query->get();
    }

    /**
     * Obtener canjes pendientes
     */
    public function getPendientes(int $userId = null)
    {
        $query = Canje::where('estado', 'pendiente')
            ->with('tienda');

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query->orderBy('fecha_canje', 'desc')->get();
    }

    /**
     * Obtener canjes por código
     */
    public function findByCodigo(string $codigo)
    {
        return Canje::where('codigo_canje', $codigo)
            ->with(['user', 'tienda'])
            ->first();
    }

    /**
     * Obtener total de puntos canjeados por usuario
     */
    public function getTotalPuntosCanjeados(int $userId): int
    {
        return Canje::where('user_id', $userId)
            ->sum('puntos_canjeados');
    }
}
