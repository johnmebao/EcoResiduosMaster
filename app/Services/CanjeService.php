<?php

namespace App\Services;

use App\Models\Canje;
use App\Models\Tienda;
use App\Models\Point;
use App\Repositories\CanjeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CanjeService
{
    protected $canjeRepository;
    protected $notificacionService;

    public function __construct(CanjeRepository $canjeRepository, NotificacionService $notificacionService)
    {
        $this->canjeRepository = $canjeRepository;
        $this->notificacionService = $notificacionService;
    }

    /**
     * Validar si el usuario tiene puntos suficientes
     */
   /*  public function validarPuntosSuficientes(int $userId, int $puntosRequeridos): bool
    {
        $point = Point::where('user_id', $userId)->first();
        
        if (!$point) {
            return false;
        }

        return $point->available_points >= $puntosRequeridos;
    } */



      /**
     * Validar si el usuario tiene puntos suficientes
     */
    public function validarPuntosSuficientes(int $userId, int $puntosRequeridos): bool
    {
        $point = Point::where('usuario_id', $userId)->first();
        
        if (!$point) {
            return false;
        }

        return $point->puntos >= $puntosRequeridos;
    }

    /**
     * Procesar un canje
     */
   /*  public function procesarCanje(int $userId, int $tiendaId): array
    {
        try {
            DB::beginTransaction();

            // Obtener tienda
            $tienda = Tienda::findOrFail($tiendaId);

            if (!$tienda->activo) {
                throw new \Exception('La tienda no está activa');
            }

            // Validar puntos suficientes
            if (!$this->validarPuntosSuficientes($userId, $tienda->puntos_requeridos)) {
                throw new \Exception('No tienes puntos suficientes para este canje');
            }

            // Obtener puntos del usuario
            $point = Point::where('user_id', $userId)->firstOrFail();

            // Descontar puntos
            $point->available_points -= $tienda->puntos_requeridos;
            $point->save();

            // Generar código de canje
            $codigoCanje = $this->generarCodigoCanje();

            // Crear registro de canje
            $canje = Canje::create([
                'user_id' => $userId,
                'tienda_id' => $tiendaId,
                'puntos_canjeados' => $tienda->puntos_requeridos,
                'descuento_obtenido' => $tienda->descuento_porcentaje,
                'codigo_canje' => $codigoCanje,
                'estado' => 'pendiente',
                'fecha_canje' => now(),
            ]);

            DB::commit();

            // Enviar notificación
            $this->notificacionService->enviarNotificacionCanje($canje);

            return [
                'success' => true,
                'canje' => $canje,
                'message' => 'Canje realizado exitosamente',
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    } */


    public function procesarCanje(int $userId, int $tiendaId): array
    {
        try {
            DB::beginTransaction();

            // Obtener tienda
            $tienda = Tienda::findOrFail($tiendaId);

            if (!$tienda->activo) {
                throw new \Exception('La tienda no está activa');
            }

            // Validar puntos suficientes
            if (!$this->validarPuntosSuficientes($userId, $tienda->puntos_requeridos)) {
                throw new \Exception('No tienes puntos suficientes para este canje');
            }

            // Obtener puntos del usuario
            $point = Point::where('usuario_id', $userId)->firstOrFail();

            // Descontar puntos
            $point->puntos -= $tienda->puntos_requeridos;
            $point->save();

            // Generar código de canje
            $codigoCanje = $this->generarCodigoCanje();

            // Crear registro de canje
            $canje = Canje::create([
                'user_id' => $userId,
                'tienda_id' => $tiendaId,
                'puntos_canjeados' => $tienda->puntos_requeridos,
                'descuento_obtenido' => $tienda->descuento_porcentaje,
                'codigo_canje' => $codigoCanje,
                'estado' => 'pendiente',
                'fecha_canje' => now(),
            ]);

            DB::commit();

            // Enviar notificación
            $this->notificacionService->enviarNotificacionCanje($canje);

            return [
                'success' => true,
                'canje' => $canje,
                'message' => 'Canje realizado exitosamente',
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Generar código único de canje
     */
    public function generarCodigoCanje(): string
    {
        do {
            $codigo = 'CANJE-' . strtoupper(Str::random(8));
        } while (Canje::where('codigo_canje', $codigo)->exists());

        return $codigo;
    }

    /**
     * Marcar canje como usado
     */
    public function marcarComoUsado(int $canjeId): bool
    {
        $canje = Canje::findOrFail($canjeId);
        
        if ($canje->estado !== 'pendiente') {
            return false;
        }

        $canje->estado = 'usado';
        $canje->save();

        return true;
    }

    /**
     * Obtener historial de canjes del usuario
     */
    public function obtenerHistorialUsuario(int $userId)
    {
        return $this->canjeRepository->findByUser($userId);
    }
}
