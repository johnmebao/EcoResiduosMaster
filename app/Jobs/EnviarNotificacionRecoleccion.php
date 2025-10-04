
<?php

namespace App\Jobs;

use App\Mail\RecoleccionConfirmada;
use App\Models\Collection;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EnviarNotificacionRecoleccion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Collection $recoleccion;
    public string $tipoNotificacion;

    /**
     * Create a new job instance.
     */
    public function __construct(Collection $recoleccion, string $tipoNotificacion = 'confirmacion')
    {
        $this->recoleccion = $recoleccion;
        $this->tipoNotificacion = $tipoNotificacion;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $usuario = $this->recoleccion->user;

        if (!$usuario || !$usuario->email) {
            return;
        }

        switch ($this->tipoNotificacion) {
            case 'confirmacion':
                Mail::to($usuario->email)->send(new RecoleccionConfirmada($this->recoleccion));
                break;
            case 'recordatorio':
                Mail::to($usuario->email)->send(new \App\Mail\RecordatorioRecoleccion($this->recoleccion));
                break;
            case 'dia_recoleccion':
                Mail::to($usuario->email)->send(new \App\Mail\NotificacionDiaRecoleccion($this->recoleccion));
                break;
        }
    }
}
