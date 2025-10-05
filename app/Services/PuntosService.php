<?php

namespace App\Services;

use App\Models\Point;
use App\Contracts\PuntosCalculatorInterface;
use App\Services\PuntosCalculators\SimplePuntosCalculator;
use App\Services\PuntosCalculators\ConfigurablePuntosCalculator;
use Illuminate\Support\Facades\Log;

class PuntosService
{
    protected $calculator;

    public function __construct()
    {
        $this->setCalculator();
    }

    /**
     * Establecer la estrategia de cálculo según configuración
     */
    protected function setCalculator(): void
    {
        $estrategia = config('puntos.estrategia', 'simple');

        $this->calculator = match($estrategia) {
            'configurable' => new ConfigurablePuntosCalculator(),
            default => new SimplePuntosCalculator(),
        };
    }

    /**
     * Cambiar la estrategia de cálculo dinámicamente
     */
    public function cambiarEstrategia(string $estrategia): void
    {
        $this->calculator = match($estrategia) {
            'configurable' => new ConfigurablePuntosCalculator(),
            'simple' => new SimplePuntosCalculator(),
            default => new SimplePuntosCalculator(),
        };
    }

    /**
     * Establecer un calculador personalizado
     */
    public function setCalculadorPersonalizado(PuntosCalculatorInterface $calculator): void
    {
        $this->calculator = $calculator;
    }

    /**
     * Calcular puntos basados en el peso
     */
    public function calcularPuntos(float $pesoKg): float
    {
        if ($pesoKg <= 0) {
            return 0;
        }

        $puntos = $this->calculator->calcular($pesoKg);
        
        // Aplicar mínimo por recolección si está configurado
        $minimo = config('puntos.minimo_por_recoleccion', 1);
        
        return max($puntos, $minimo);
    }

    /**
     * Asignar puntos a un usuario
     */
    public function asignarPuntos(int $userId, float $pesoKg): Point
    {
        try {
            $puntos = $this->calcularPuntos($pesoKg);

            // Obtener o crear registro de puntos
            $point = Point::firstOrCreate(
                ['user_id' => $userId],
                ['total_points' => 0, 'available_points' => 0]
            );

            // Incrementar puntos
            $point->total_points += $puntos;
            $point->available_points += $puntos;
            $point->save();

            Log::info("Puntos asignados", [
                'user_id' => $userId,
                'peso_kg' => $pesoKg,
                'puntos_agregados' => $puntos,
                'puntos_totales' => $point->total_points,
                'puntos_disponibles' => $point->available_points,
            ]);

            return $point;

        } catch (\Exception $e) {
            Log::error("Error al asignar puntos", [
                'user_id' => $userId,
                'peso_kg' => $pesoKg,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Descontar puntos de un usuario (para canjes)
     */
    public function descontarPuntos(int $userId, int $puntos): bool
    {
        try {
            $point = Point::where('user_id', $userId)->first();

            if (!$point || $point->available_points < $puntos) {
                return false;
            }

            $point->available_points -= $puntos;
            $point->save();

            Log::info("Puntos descontados", [
                'user_id' => $userId,
                'puntos_descontados' => $puntos,
                'puntos_disponibles' => $point->available_points,
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error("Error al descontar puntos", [
                'user_id' => $userId,
                'puntos' => $puntos,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Obtener puntos disponibles de un usuario
     */
    public function obtenerPuntosDisponibles(int $userId): int
    {
        $point = Point::where('user_id', $userId)->first();
        return $point ? $point->available_points : 0;
    }
}
