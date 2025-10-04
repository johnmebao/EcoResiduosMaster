
<?php

namespace App\Jobs;

use App\Models\Collection;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProgramarRecordatorios implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     * 
     * Programa recordatorios para recolecciones del día siguiente
     */
    public function handle(): void
    {
        $manana = Carbon::tomorrow();

        // Obtener recolecciones programadas para mañana
        $recolecciones = Collection::where('fecha_programada', $manana->toDateString())
            ->where('estado', 'programada')
            ->with(['user', 'company', 'localidad', 'ruta'])
            ->get();

        foreach ($recolecciones as $recoleccion) {
            // Enviar recordatorio
            EnviarNotificacionRecoleccion::dispatch($recoleccion, 'recordatorio');
        }
    }
}
