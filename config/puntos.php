
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Estrategia de Cálculo de Puntos
    |--------------------------------------------------------------------------
    |
    | Define qué estrategia usar para calcular puntos.
    | Opciones: 'simple', 'configurable'
    |
    */
    'estrategia' => env('PUNTOS_ESTRATEGIA', 'simple'),

    /*
    |--------------------------------------------------------------------------
    | Multiplicador de Puntos
    |--------------------------------------------------------------------------
    |
    | Multiplicador aplicado al peso en kg para calcular puntos.
    | Usado por ConfigurablePuntosCalculator.
    |
    */
    'multiplicador' => env('PUNTOS_MULTIPLICADOR', 1.0),

    /*
    |--------------------------------------------------------------------------
    | Bonus de Puntos
    |--------------------------------------------------------------------------
    |
    | Puntos adicionales otorgados en cada recolección.
    | Usado por ConfigurablePuntosCalculator.
    |
    */
    'bonus' => env('PUNTOS_BONUS', 0),

    /*
    |--------------------------------------------------------------------------
    | Puntos Mínimos por Recolección
    |--------------------------------------------------------------------------
    |
    | Cantidad mínima de puntos que se otorgan por recolección,
    | independientemente del peso.
    |
    */
    'minimo_por_recoleccion' => env('PUNTOS_MINIMO', 1),
];
