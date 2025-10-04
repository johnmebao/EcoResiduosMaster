<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Programar envío de recordatorios diarios
// Se ejecuta todos los días a las 8:00 AM
Schedule::command('recolecciones:enviar-recordatorios')->dailyAt('08:00');

// Programar generación de recolecciones de orgánicos semanales
// Se ejecuta todos los lunes a las 6:00 AM para generar la semana siguiente
Schedule::command('recolecciones:generar-organicos-semanales --semanas=1')->weeklyOn(1, '06:00');
