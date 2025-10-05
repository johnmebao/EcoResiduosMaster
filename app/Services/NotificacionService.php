<?php

namespace App\Services;

use App\Models\Collection;
use App\Models\Canje;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecoleccionConfirmada;
use App\Mail\RecoleccionRecordatorio;
use App\Mail\RecoleccionCompletada;
use App\Mail\SolicitudRecibida;
use App\Mail\CanjeRealizado;

class NotificacionService
{
    /**
     * Enviar confirmación de recolección
     */
    public function enviarConfirmacion(Collection $collection): void
    {
        try {
            Mail::to($collection->user->email)
                ->send(new RecoleccionConfirmada($collection));
        } catch (\Exception $e) {
            \Log::error('Error enviando confirmación: ' . $e->getMessage());
        }
    }

    /**
     * Enviar recordatorio de recolección
     */
    public function enviarRecordatorio(Collection $collection): void
    {
        try {
            Mail::to($collection->user->email)
                ->send(new RecoleccionRecordatorio($collection));
        } catch (\Exception $e) {
            \Log::error('Error enviando recordatorio: ' . $e->getMessage());
        }
    }

    /**
     * Enviar notificación de recolección del día
     */
    public function enviarNotificacionDia(Collection $collection): void
    {
        $this->enviarRecordatorio($collection);
    }

    /**
     * Enviar notificación de recolección completada
     */
    public function enviarNotificacionCompletado(Collection $collection): void
    {
        try {
            Mail::to($collection->user->email)
                ->send(new RecoleccionCompletada($collection));
        } catch (\Exception $e) {
            \Log::error('Error enviando notificación de completado: ' . $e->getMessage());
        }
    }

    /**
     * Enviar notificación de solicitud recibida (residuos peligrosos)
     */
    public function enviarNotificacionSolicitud(Collection $collection): void
    {
        try {
            Mail::to($collection->user->email)
                ->send(new SolicitudRecibida($collection));
        } catch (\Exception $e) {
            \Log::error('Error enviando notificación de solicitud: ' . $e->getMessage());
        }
    }

    /**
     * Enviar notificación de canje realizado
     */
    public function enviarNotificacionCanje(Canje $canje): void
    {
        try {
            Mail::to($canje->user->email)
                ->send(new CanjeRealizado($canje));
        } catch (\Exception $e) {
            \Log::error('Error enviando notificación de canje: ' . $e->getMessage());
        }
    }

    /**
     * Enviar notificaciones masivas a usuarios
     */
    public function enviarNotificacionMasiva(array $userIds, string $asunto, string $mensaje): void
    {
        $users = User::whereIn('id', $userIds)->get();

        foreach ($users as $user) {
            try {
                Mail::raw($mensaje, function ($mail) use ($user, $asunto) {
                    $mail->to($user->email)
                        ->subject($asunto);
                });
            } catch (\Exception $e) {
                \Log::error("Error enviando notificación masiva a {$user->email}: " . $e->getMessage());
            }
        }
    }
}
