
<?php

namespace App\Services\PuntosCalculators;

use App\Contracts\PuntosCalculatorInterface;

class SimplePuntosCalculator implements PuntosCalculatorInterface
{
    /**
     * Calcular puntos con fórmula simple: 1 kg = 1 punto
     *
     * @param float $pesoKg
     * @return float
     */
    public function calcular(float $pesoKg): float
    {
        return round($pesoKg, 2);
    }
}
