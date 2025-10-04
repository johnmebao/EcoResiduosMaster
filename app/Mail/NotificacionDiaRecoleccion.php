
<?php

namespace App\Mail;

use App\Models\Collection;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionDiaRecoleccion extends Mailable
{
    use Queueable, SerializesModels;

    public Collection $recoleccion;

    /**
     * Create a new message instance.
     */
    public function __construct(Collection $recoleccion)
    {
        $this->recoleccion = $recoleccion;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Hoy es tu Recolección - EcoResiduos',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.notificacion-dia-recoleccion',
            with: [
                'recoleccion' => $this->recoleccion,
                'usuario' => $this->recoleccion->user,
                'empresa' => $this->recoleccion->company,
                'localidad' => $this->recoleccion->localidad,
                'ruta' => $this->recoleccion->ruta,
                'turno' => $this->recoleccion->turno_num,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
