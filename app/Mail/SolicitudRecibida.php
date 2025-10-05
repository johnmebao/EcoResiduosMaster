<?php

namespace App\Mail;

use App\Models\Collection;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitudRecibida extends Mailable
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
        return $this->subject('Solicitud de Recolección Recibida - EcoResiduos')
                    ->view('emails.solicitud_recibida')
                    ->with([
                        'nombreUsuario' => $this->collection->user->name,
                        'tipoResiduo' => $this->collection->tipoResiduo->nombre,
                        'fechaSolicitud' => $this->collection->created_at->format('d/m/Y H:i'),
                        'direccion' => $this->collection->direccion,
                        'estadoSolicitud' => $this->collection->estado_solicitud,
                    ]);
    }
}
