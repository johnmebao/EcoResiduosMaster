<?php

namespace App\Services;

use App\Models\CollectionDetail;
use App\Models\Point;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class PuntosService
{
    /**
     * Calcular puntos basados en el peso y tipo de residuo
     * 
     * @param CollectionDetail $pesoRegistro
     * @return float
     */
    public function calcularPuntos(CollectionDetail $pesoRegistro): float
    {
        // Solo calcular puntos si cumple requisitos de separación
        if (!$pesoRegistro->requisitos_separacion) {
            return 0;
        }

        // Solo inorgánicos reciclables generan puntos
        if ($pesoRegistro->tipo_residuo !== 'INORGANICO') {
            return 0;
        }

        // Fórmula básica: 1 kg = 1 punto
        // Preparado para Strategy Pattern en Fase 3
        $puntos = $pesoRegistro->peso_kg * 1;

        return round($puntos, 2);
    }

    /**
     * Asignar puntos a un usuario
     * 
     * @param User $user
     * @param float $puntos
     * @return Point
     */
    public function asignarPuntos(User $user, float $puntos): Point
    {
        try {
            $pointRecord = Point::addPoints($user->id, $puntos);
            
            Log::info("Puntos asignados", [
                'user_id' => $user->id,
                'puntos_agregados' => $puntos,
                'puntos_totales' => $pointRecord->puntos
            ]);

            return $pointRecord;
        } catch (\Exception $e) {
            Log::error("Error al asignar puntos", [
                'user_id' => $user->id,
                'puntos' => $puntos,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Procesar puntos para un registro de peso
     * 
     * @param CollectionDetail $pesoRegistro
     * @return array
     */
    public function procesarPuntos(CollectionDetail $pesoRegistro): array
    {
        $puntos = $this->calcularPuntos($pesoRegistro);
        
        if ($puntos <= 0) {
            return [
                'puntos_calculados' => 0,
                'puntos_asignados' => false,
                'mensaje' => 'No se asignaron puntos: requisitos no cumplidos o tipo de residuo no válido.'
            ];
        }

        $collection = $pesoRegistro->collection;
        $user = $collection->user;
        
        $pointRecord = $this->asignarPuntos($user, $puntos);

        return [
            'puntos_calculados' => $puntos,
            'puntos_asignados' => true,
            'puntos_totales' => $pointRecord->puntos,
            'mensaje' => "Se asignaron {$puntos} puntos exitosamente."
        ];
    }

    /**
     * Validar si un registro de peso puede generar puntos
     * 
     * @param CollectionDetail $pesoRegistro
     * @return bool
     */
    public function puedeGenerarPuntos(CollectionDetail $pesoRegistro): bool
    {
        return $pesoRegistro->requisitos_separacion 
            && $pesoRegistro->tipo_residuo === 'INORGANICO'
            && $pesoRegistro->peso_kg > 0;
    }
}
