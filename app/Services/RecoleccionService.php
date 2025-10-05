<?php

namespace App\Services;

use App\Models\Collection;
use App\Models\CollectionDetail;
use App\Models\Ruta;
use App\Repositories\RecoleccionRepository;
use Illuminate\Support\Facades\DB;

class RecoleccionService
{
    protected $recoleccionRepository;
    protected $notificacionService;
    protected $puntosService;

    public function __construct(
        RecoleccionRepository $recoleccionRepository,
        NotificacionService $notificacionService,
        PuntosService $puntosService
    ) {
        $this->recoleccionRepository = $recoleccionRepository;
        $this->notificacionService = $notificacionService;
        $this->puntosService = $puntosService;
    }

    /**
     * Crear recolección de residuos orgánicos (programación automática)
     */
    public function crearRecoleccionOrganica(array $data): Collection
    {
        DB::beginTransaction();
        try {
            // Asignar ruta automáticamente
            $rutaId = $this->asignarRutaAutomatica($data['localidad_id'], 'organicos');

            // Crear recolección
            $collection = Collection::create([
                'user_id' => $data['user_id'],
                'tipo_residuo_id' => $data['tipo_residuo_id'],
                'empresa_id' => $data['empresa_id'],
                'localidad_id' => $data['localidad_id'],
                'ruta_id' => $rutaId,
                'fecha_recoleccion' => $data['fecha_recoleccion'],
                'direccion' => $data['direccion'],
                'estado' => 'programada',
            ]);

            // Crear detalle
            CollectionDetail::create([
                'collection_id' => $collection->id,
                'peso_kg' => $data['peso_kg'] ?? 0,
                'observaciones' => $data['observaciones'] ?? null,
            ]);

            DB::commit();

            // Enviar notificación
            $this->notificacionService->enviarConfirmacion($collection);

            return $collection;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Crear recolección de residuos inorgánicos (programada o por demanda)
     */
    public function crearRecoleccionInorganica(array $data): Collection
    {
        DB::beginTransaction();
        try {
            // Asignar ruta automáticamente
            $rutaId = $this->asignarRutaAutomatica($data['localidad_id'], 'inorganicos');

            // Determinar estado según tipo
            $estado = isset($data['es_demanda']) && $data['es_demanda'] ? 'pendiente' : 'programada';

            // Crear recolección
            $collection = Collection::create([
                'user_id' => $data['user_id'],
                'tipo_residuo_id' => $data['tipo_residuo_id'],
                'empresa_id' => $data['empresa_id'],
                'localidad_id' => $data['localidad_id'],
                'ruta_id' => $rutaId,
                'fecha_recoleccion' => $data['fecha_recoleccion'],
                'direccion' => $data['direccion'],
                'estado' => $estado,
            ]);

            // Crear detalle
            CollectionDetail::create([
                'collection_id' => $collection->id,
                'peso_kg' => $data['peso_kg'] ?? 0,
                'requisitos_separacion' => $data['requisitos_separacion'] ?? null,
                'observaciones' => $data['observaciones'] ?? null,
            ]);

            DB::commit();

            // Enviar notificación
            $this->notificacionService->enviarConfirmacion($collection);

            return $collection;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Crear solicitud de recolección de residuos peligrosos (requiere aprobación)
     */
    public function crearSolicitudPeligrosos(array $data): Collection
    {
        DB::beginTransaction();
        try {
            // Crear recolección con estado de solicitud pendiente
            $collection = Collection::create([
                'user_id' => $data['user_id'],
                'tipo_residuo_id' => $data['tipo_residuo_id'],
                'empresa_id' => $data['empresa_id'],
                'localidad_id' => $data['localidad_id'],
                'fecha_recoleccion' => $data['fecha_recoleccion'],
                'direccion' => $data['direccion'],
                'estado' => 'pendiente',
                'estado_solicitud' => 'pendiente',
            ]);

            // Crear detalle con requisitos especiales
            CollectionDetail::create([
                'collection_id' => $collection->id,
                'peso_kg' => $data['peso_kg'] ?? 0,
                'requisitos_separacion' => $data['requisitos_separacion'],
                'observaciones' => $data['observaciones'] ?? null,
            ]);

            DB::commit();

            // Enviar notificación de solicitud
            $this->notificacionService->enviarNotificacionSolicitud($collection);

            return $collection;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Asignar ruta automáticamente según localidad y tipo de residuo
     */
    public function asignarRutaAutomatica(int $localidadId, string $tipoResiduo): ?int
    {
        // Buscar ruta disponible para la localidad y tipo de residuo
        $ruta = Ruta::where('localidad_id', $localidadId)
            ->where('tipo_residuo', $tipoResiduo)
            ->where('activa', true)
            ->first();

        return $ruta ? $ruta->id : null;
    }

    /**
     * Completar recolección y asignar puntos
     */
    public function completarRecoleccion(int $collectionId, float $pesoKg): bool
    {
        DB::beginTransaction();
        try {
            $collection = Collection::findOrFail($collectionId);
            
            // Actualizar estado
            $collection->estado = 'completada';
            $collection->save();

            // Actualizar peso en detalle
            $detail = CollectionDetail::where('collection_id', $collectionId)->first();
            if ($detail) {
                $detail->peso_kg = $pesoKg;
                $detail->save();
            }

            // Asignar puntos al usuario
            $this->puntosService->asignarPuntos($collection->user_id, $pesoKg);

            DB::commit();

            // Enviar notificación de completado
            $this->notificacionService->enviarNotificacionCompletado($collection);

            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
