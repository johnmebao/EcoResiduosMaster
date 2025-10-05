<?php

namespace App\Services\PuntosCalculators;
use App\Contracts\PuntosCalculatorInterface;

class ConfigurablePuntosCalculator implements PuntosCalculatorInterface
{
    protected $multiplicador;
    protected $bonus;

    public function __construct()
    {
        $this->multiplicador = config('puntos.multiplicador', 1.0);
        $this->bonus = config('puntos.bonus', 0);
    }

    /**
     * Calcular puntos con fórmula configurable: (peso_kg * multiplicador) + bonus
     *
     * @param float $pesoKg
     * @return float
     */
    public function calcular(float $pesoKg): float
    {
        $puntos = ($pesoKg * $this->multiplicador) + $this->bonus;
        return round($puntos, 2);
    }
}
