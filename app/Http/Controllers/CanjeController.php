<?php

namespace App\Http\Controllers;

use App\Models\Tienda;
use App\Models\Canje;
use App\Services\CanjeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CanjeController extends Controller
{
    protected $canjeService;

    public function __construct(CanjeService $canjeService)
    {
        $this->canjeService = $canjeService;
    }

    /**
     * Mostrar historial de canjes del usuario
     */
    public function index()
    {
        $canjes = $this->canjeService->obtenerHistorialUsuario(Auth::id());
        return view('canjes.index', compact('canjes'));
    }

    /**
     * Mostrar tiendas disponibles para canjear
     */
    public function create()
    {
        $tiendas = Tienda::activas()->orderBy('puntos_requeridos')->get();

        $puntosDisponibles = Auth::user()->point->available_points ?? 0;
        
        return view('canjes.create', compact('tiendas', 'puntosDisponibles'));
    }


     /*  public function create()
    {
        $tiendas = Tienda::activas()->orderBy('puntos_requeridos')->get();
        
        // Obtener puntos disponibles del usuario autenticado
        $user = Auth::user();
        $puntosDisponibles = $user->puntos_disponibles;
        
        return view('canjes.create', compact('tiendas', 'puntosDisponibles'));
    } */

    /**
     * Procesar canje
     */
    public function store(Request $request)
    {
        $request->validate([
            'tienda_id' => 'required|exists:tiendas,id',
        ]);

        $resultado = $this->canjeService->procesarCanje(
            Auth::id(),
            $request->tienda_id
        );

        if ($resultado['success']) {
            return redirect()->route('canjes.show', $resultado['canje']->id)
                ->with('success', $resultado['message']);
        }

        return back()->with('error', $resultado['message']);
    }

    /**
     * Mostrar detalle de canje con código
     */
    public function show(Canje $canje)
    {
        // Verificar que el canje pertenece al usuario autenticado
        if ($canje->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        return view('canjes.show', compact('canje'));
    }
}
