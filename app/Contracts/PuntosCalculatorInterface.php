<?php

namespace App\Contracts;

interface PuntosCalculatorInterface
{
    /**
     * Calcular puntos basados en el peso en kilogramos
     *
     * @param float $pesoKg Peso en kilogramos
     * @return float Puntos calculados
     */
    public function calcular(float $pesoKg): float;
}
