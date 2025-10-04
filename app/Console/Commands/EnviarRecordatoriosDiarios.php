<?php

namespace App\Console\Commands;

use App\Jobs\EnviarNotificacionRecoleccion;
use App\Jobs\ProgramarRecordatorios;
use App\Models\Collection;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EnviarRecordatoriosDiarios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recolecciones:enviar-recordatorios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía recordatorios diarios de recolecciones programadas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando envío de recordatorios...');

        // Recordatorios para mañana
        $manana = Carbon::tomorrow();
        $recoleccionesManana = Collection::where('fecha_programada', $manana->toDateString())
            ->where('estado', 'programada')
            ->with(['user', 'company', 'localidad', 'ruta'])
            ->get();

        $this->info("Encontradas {$recoleccionesManana->count()} recolecciones para mañana");

        foreach ($recoleccionesManana as $recoleccion) {
            EnviarNotificacionRecoleccion::dispatch($recoleccion, 'recordatorio');
        }

        // Notificaciones para hoy
        $hoy = Carbon::today();
        $recoleccionesHoy = Collection::where('fecha_programada', $hoy->toDateString())
            ->where('estado', 'programada')
            ->with(['user', 'company', 'localidad', 'ruta'])
            ->get();

        $this->info("Encontradas {$recoleccionesHoy->count()} recolecciones para hoy");

        foreach ($recoleccionesHoy as $recoleccion) {
            EnviarNotificacionRecoleccion::dispatch($recoleccion, 'dia_recoleccion');
        }

        $this->info('Recordatorios enviados exitosamente');

        return Command::SUCCESS;
    }
}
