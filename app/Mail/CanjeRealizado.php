<?php

namespace App\Mail;

use App\Models\Canje;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CanjeRealizado extends Mailable
{
    use Queueable, SerializesModels;

    public $canje;

    /**
     * Create a new message instance.
     */
    public function __construct(Canje $canje)
    {
        $this->canje = $canje;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Canje Realizado - EcoResiduos')
                    ->view('emails.canje_realizado')
                    ->with([
                        'nombreUsuario' => $this->canje->user->name,
                        'nombreTienda' => $this->canje->tienda->nombre,
                        'puntosCanjeados' => $this->canje->puntos_canjeados,
                        'descuentoObtenido' => $this->canje->descuento_obtenido,
                        'codigoCanje' => $this->canje->codigo_canje,
                        'fechaCanje' => $this->canje->fecha_canje->format('d/m/Y H:i'),
                    ]);
    }
}
