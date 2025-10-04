
<?php

namespace App\Mail;

use App\Models\Collection;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecoleccionRecordatorio extends Mailable
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
        return $this->subject('Recordatorio de Recolección - EcoResiduos')
                    ->view('emails.recoleccion_recordatorio')
                    ->with([
                        'nombreUsuario' => $this->collection->user->name,
                        'tipoResiduo' => $this->collection->tipoResiduo->nombre,
                        'fechaRecoleccion' => $this->collection->fecha_recoleccion->format('d/m/Y'),
                        'direccion' => $this->collection->direccion,
                        'empresa' => $this->collection->empresa->nombre,
                    ]);
    }
}
