
<?php

namespace App\Http\Controllers;

use App\Models\Localidad;
use Illuminate\Http\Request;

class LocalidadController extends Controller
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
        $localidades = Localidad::withCount('rutas')->orderBy('nombre')->paginate(15);
        return view('admin.localidades.index', compact('localidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.localidades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:localidads,nombre',
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
        ]);

        Localidad::create($validated);

        return redirect()->route('localidades.index')
            ->with('success', 'Localidad creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Localidad $localidad)
    {
        $localidad->load(['rutas.company', 'collections']);
        return view('admin.localidades.show', compact('localidad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Localidad $localidad)
    {
        return view('admin.localidades.edit', compact('localidad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Localidad $localidad)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:localidads,nombre,' . $localidad->id,
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
        ]);

        $localidad->update($validated);

        return redirect()->route('localidades.index')
            ->with('success', 'Localidad actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Localidad $localidad)
    {
        // Verificar si tiene rutas asociadas
        if ($localidad->rutas()->count() > 0) {
            return redirect()->route('localidades.index')
                ->with('error', 'No se puede eliminar la localidad porque tiene rutas asociadas.');
        }

        $localidad->delete();

        return redirect()->route('localidades.index')
            ->with('success', 'Localidad eliminada exitosamente.');
    }
}
