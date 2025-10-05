<?php

namespace App\Http\Controllers;

use App\Models\Ruta;
use App\Models\Localidad;
use App\Models\Company;
use Illuminate\Http\Request;

class RutaController extends Controller
{
    /**
     * Constructor - Aplicar middleware de autenticación y roles
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Administrador');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rutas = Ruta::with(['localidad', 'company'])
            ->orderBy('localidad_id')
            ->orderBy('dia_semana')
            ->paginate(15);
        
        return view('admin.rutas.index', compact('rutas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $localidades = Localidad::where('activo', true)->orderBy('nombre')->get();
        $empresas = Company::orderBy('name')->get();
        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        
        return view('admin.rutas.create', compact('localidades', 'empresas', 'diasSemana'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'localidad_id' => 'required|exists:localidads,id',
            'company_id' => 'required|exists:companies,id',
            'dia_semana' => 'required|string|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'capacidad_max' => 'required|integer|min:1|max:200',
            'activo' => 'boolean',
        ]);

        Ruta::create($validated);

        return redirect()->route('rutas.index')
            ->with('success', 'Ruta creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ruta $ruta)
    {
        $ruta->load(['localidad', 'company', 'collections.user']);
        return view('admin.rutas.show', compact('ruta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ruta $ruta)
    {
        $localidades = Localidad::where('activo', true)->orderBy('nombre')->get();
        $empresas = Company::orderBy('name')->get();
        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        
        return view('admin.rutas.edit', compact('ruta', 'localidades', 'empresas', 'diasSemana'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ruta $ruta)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'localidad_id' => 'required|exists:localidads,id',
            'company_id' => 'required|exists:companies,id',
            'dia_semana' => 'required|string|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'capacidad_max' => 'required|integer|min:1|max:200',
            'activo' => 'boolean',
        ]);

        $ruta->update($validated);

        return redirect()->route('rutas.index')
            ->with('success', 'Ruta actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ruta $ruta)
    {
        // Verificar si tiene recolecciones asociadas
        if ($ruta->collections()->count() > 0) {
            return redirect()->route('rutas.index')
                ->with('error', 'No se puede eliminar la ruta porque tiene recolecciones asociadas.');
        }

        $ruta->delete();

        return redirect()->route('rutas.index')
            ->with('success', 'Ruta eliminada exitosamente.');
    }
}
