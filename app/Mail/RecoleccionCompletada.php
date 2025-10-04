
<?php

namespace App\Mail;

use App\Models\Collection;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecoleccionCompletada extends Mailable
{
    use Queueable, SerializesModels;

    public $collection;

    /**
     * Create a new message instance.
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $pesoKg = $this->collection->detail ? $this->collection->detail->peso_kg : 0;
        
        return $this->subject('Recolección Completada - EcoResiduos')
                    ->view('emails.recoleccion_completada')
                    ->with([
                        'nombreUsuario' => $this->collection->user->name,
                        'tipoResiduo' => $this->collection->tipoResiduo->nombre,
                        'fechaRecoleccion' => $this->collection->fecha_recoleccion->format('d/m/Y'),
                        'pesoKg' => $pesoKg,
                        'puntosGanados' => $pesoKg, // Simplificado, usar PuntosService en producción
                    ]);
    }
}
