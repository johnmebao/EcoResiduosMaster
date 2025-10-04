<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Http\Requests\StoreRecoleccionPeligrososRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SolicitudPeligrososController extends Controller
{
    /**
     * Display a listing of the resource.
     * Listar solicitudes del usuario autenticado
     */
    public function index()
    {
        $solicitudes = Collection::where('user_id', Auth::id())
            ->peligrosos()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('solicitudes-peligrosos.index', compact('solicitudes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Verificar si el usuario ya tiene una solicitud activa este mes
        if (Collection::tieneSolicitudPeligrososMesActual(Auth::id())) {
            return redirect()->route('solicitudes-peligrosos.index')
                ->with('error', 'Ya tiene una solicitud de residuos peligrosos activa este mes.');
        }

        return view('solicitudes-peligrosos.create');
    }

    /**
     * Store a newly created resource in storage.
     * Crear nueva solicitud de recolección de peligrosos
     */
    public function store(StoreRecoleccionPeligrososRequest $request)
    {
        try {
            $solicitud = Collection::create([
                'user_id' => $request->user_id,
                'company_id' => $request->company_id,
                'localidad_id' => $request->localidad_id,
                'tipo_residuo' => Collection::TIPO_PELIGROSO,
                'programada' => false,
                'estado' => 'pendiente',
                'estado_solicitud' => Collection::ESTADO_SOLICITADO,
                'fecha_solicitud' => now(),
                'notas' => $request->notas . "\n\nDescripción: " . $request->descripcion_residuos . 
                          ($request->cantidad_estimada ? "\nCantidad estimada: " . $request->cantidad_estimada : ''),
            ]);

            Log::info('Solicitud de recolección de peligrosos creada', [
                'solicitud_id' => $solicitud->id,
                'user_id' => $request->user_id
            ]);

            return redirect()->route('solicitudes-peligrosos.index')
                ->with('success', 'Solicitud de recolección de residuos peligrosos enviada exitosamente. Será revisada por un administrador.');

        } catch (\Exception $e) {
            Log::error('Error al crear solicitud de peligrosos', [
                'error' => $e->getMessage(),
                'user_id' => $request->user_id
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear la solicitud. Por favor intente nuevamente.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $solicitud = Collection::where('id', $id)
            ->where('user_id', Auth::id())
            ->peligrosos()
            ->firstOrFail();

        return view('solicitudes-peligrosos.show', compact('solicitud'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $solicitud = Collection::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('estado_solicitud', Collection::ESTADO_SOLICITADO)
            ->peligrosos()
            ->firstOrFail();

        return view('solicitudes-peligrosos.edit', compact('solicitud'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $solicitud = Collection::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('estado_solicitud', Collection::ESTADO_SOLICITADO)
            ->peligrosos()
            ->firstOrFail();

        $request->validate([
            'notas' => 'nullable|string|max:1000',
        ]);

        $solicitud->update([
            'notas' => $request->notas,
        ]);

        return redirect()->route('solicitudes-peligrosos.show', $solicitud->id)
            ->with('success', 'Solicitud actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     * Cancelar solicitud (solo si está en estado solicitado)
     */
    public function destroy(string $id)
    {
        $solicitud = Collection::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('estado_solicitud', Collection::ESTADO_SOLICITADO)
            ->peligrosos()
            ->firstOrFail();

        $solicitud->update([
            'estado' => 'cancelada',
            'estado_solicitud' => Collection::ESTADO_RECHAZADO,
            'motivo_rechazo' => 'Cancelada por el usuario',
        ]);

        Log::info('Solicitud de peligrosos cancelada por usuario', [
            'solicitud_id' => $solicitud->id,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('solicitudes-peligrosos.index')
            ->with('success', 'Solicitud cancelada exitosamente.');
    }

    /**
     * Listar todas las solicitudes pendientes (para administradores)
     */
    public function pendientes()
    {
        $solicitudes = Collection::peligrosos()
            ->solicitudesPendientes()
            ->with(['user', 'localidad', 'company'])
            ->orderBy('fecha_solicitud', 'asc')
            ->paginate(15);

        return view('admin.solicitudes-peligrosos.pendientes', compact('solicitudes'));
    }

    /**
     * Aprobar solicitud (solo administradores)
     */
    public function aprobar(Request $request, string $id)
    {
        $solicitud = Collection::peligrosos()
            ->where('id', $id)
            ->where('estado_solicitud', Collection::ESTADO_SOLICITADO)
            ->firstOrFail();

        $solicitud->update([
            'estado_solicitud' => Collection::ESTADO_APROBADO,
            'fecha_aprobacion' => now(),
            'aprobado_por' => Auth::id(),
        ]);

        Log::info('Solicitud de peligrosos aprobada', [
            'solicitud_id' => $solicitud->id,
            'aprobado_por' => Auth::id()
        ]);

        return redirect()->back()
            ->with('success', 'Solicitud aprobada exitosamente. Ahora puede programar la recolección.');
    }

    /**
     * Rechazar solicitud (solo administradores)
     */
    public function rechazar(Request $request, string $id)
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|max:500',
        ]);

        $solicitud = Collection::peligrosos()
            ->where('id', $id)
            ->where('estado_solicitud', Collection::ESTADO_SOLICITADO)
            ->firstOrFail();

        $solicitud->update([
            'estado' => 'cancelada',
            'estado_solicitud' => Collection::ESTADO_RECHAZADO,
            'motivo_rechazo' => $request->motivo_rechazo,
            'aprobado_por' => Auth::id(),
        ]);

        Log::info('Solicitud de peligrosos rechazada', [
            'solicitud_id' => $solicitud->id,
            'rechazado_por' => Auth::id(),
            'motivo' => $request->motivo_rechazo
        ]);

        return redirect()->back()
            ->with('success', 'Solicitud rechazada.');
    }

    /**
     * Programar recolección después de aprobar (solo administradores)
     */
    public function programar(Request $request, string $id)
    {
        $request->validate([
            'fecha_programada' => 'required|date|after_or_equal:today',
            'ruta_id' => 'required|exists:rutas,id',
        ]);

        $solicitud = Collection::peligrosos()
            ->where('id', $id)
            ->where('estado_solicitud', Collection::ESTADO_APROBADO)
            ->firstOrFail();

        $solicitud->update([
            'programada' => true,
            'fecha_programada' => $request->fecha_programada,
            'ruta_id' => $request->ruta_id,
            'estado' => 'programada',
            'estado_solicitud' => Collection::ESTADO_PROGRAMADO,
        ]);

        Log::info('Recolección de peligrosos programada', [
            'solicitud_id' => $solicitud->id,
            'fecha_programada' => $request->fecha_programada,
            'programado_por' => Auth::id()
        ]);

        return redirect()->back()
            ->with('success', 'Recolección programada exitosamente para el ' . $request->fecha_programada);
    }
}
