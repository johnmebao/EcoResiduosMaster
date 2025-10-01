<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:recolector')->only(['registerWaste', 'updateWaste']);
    }

    public function index()
    {
        $collections = Collection::with(['user', 'company'])->latest()->get();
        return view('collections.index', compact('collections'));
    }

    public function create()
    {
        $users = User::all();
        $companies = Company::all();
        return view('collections.create', compact('users', 'companies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'company_id' => 'required|exists:companies,id',
            'tipo_residuo' => 'required|string',
            'fecha_programada' => 'required|date',
            'peso_kg' => 'required|numeric|min:0',
            'estado' => 'required|string',
            'notas' => 'nullable|string'
        ]);

        Collection::create($validated);

        return redirect()
            ->route('collections.index')
            ->with('success', 'Recolección creada exitosamente');
    }

    public function show(Collection $collection)
    {
        return view('collections.show', compact('collection'));
    }

    public function edit(Collection $collection)
    {
        $users = User::all();
        $companies = Company::all();
        return view('collections.edit', compact('collection', 'users', 'companies'));
    }

    public function update(Request $request, Collection $collection)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'company_id' => 'required|exists:companies,id',
            'tipo_residuo' => 'required|string',
            'fecha_programada' => 'required|date',
            'peso_kg' => 'required|numeric|min:0',
            'estado' => 'required|string',
            'notas' => 'nullable|string'
        ]);

        $collection->update($validated);

        return redirect()
            ->route('collections.index')
            ->with('success', 'Recolección actualizada exitosamente');
    }

    public function destroy(Collection $collection)
    {
        $collection->delete();
        return redirect()
            ->route('collections.index')
            ->with('success', 'Recolección eliminada exitosamente');
    }

    public function registerWaste(Collection $collection)
    {
        // Verificar que la recolección esté pendiente
        if ($collection->estado !== 'pendiente') {
            return redirect()
                ->route('collections.index')
                ->with('error', 'Solo se pueden registrar residuos en recolecciones pendientes');
        }

        // Obtener los tipos de residuos y los detalles existentes
        $tiposResiduos = Collection::getTiposResiduos();
        $details = $collection->details;

        return view('collections.register-waste', compact('collection', 'tiposResiduos', 'details'));
    }

    public function updateWaste(Request $request, Collection $collection)
    {
        $request->validate([
            'tipos.*' => 'required|string',
            'pesos.*' => 'required|numeric|min:0',
            'observaciones.*' => 'nullable|string'
        ]);

        try {
            \DB::beginTransaction();

            // Eliminar detalles anteriores
            $collection->details()->delete();

            $pesoTotal = 0;

            // Crear nuevos detalles
            foreach ($request->tipos as $index => $tipo) {
                $peso = $request->pesos[$index];
                $observacion = $request->observaciones[$index] ?? null;

                $collection->details()->create([
                    'tipo_residuo' => $tipo,
                    'peso_kg' => $peso,
                    'observaciones' => $observacion
                ]);

                $pesoTotal += $peso;
            }

            // Actualizar la recolección
            $collection->update([
                'peso_kg' => $pesoTotal,
                'estado' => 'completado'
            ]);

            \DB::commit();

            return redirect()
                ->route('collections.index')
                ->with('success', 'Residuos registrados exitosamente');

        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Error al registrar los residuos: ' . $e->getMessage())
                ->withInput();
        }
    }
}
