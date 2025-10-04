<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\User;
use App\Models\Company;
use App\Models\Point;
use App\Models\Setting;
use App\Models\Localidad;
use App\Models\Ruta;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\CollectionDetail;
use App\Jobs\EnviarNotificacionRecoleccion;

class CollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('role:Recolector')->only(['registerWaste', 'updateWaste']);
    }

    public function index()
    {
        $collections = Collection::with(['user', 'company'])
            ->latest()
            ->get();
        return view('collections.index', compact('collections'));
    }

    public function create()
    {
        $users = User::all();
        $companies = Company::all();
        $localidades = Localidad::where('activo', true)->orderBy('nombre')->get();
        $rutas = Ruta::where('activo', true)->with(['localidad', 'company'])->get();
        return view('collections.create', compact('users', 'companies', 'localidades', 'rutas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'company_id' => 'required|exists:companies,id',
            'localidad_id' => 'nullable|exists:localidads,id',
            'ruta_id' => 'nullable|exists:rutas,id',
            'tipo_residuo' => 'required|string',
            'fecha_programada' => 'required|date',
            'peso_kg' => 'nullable|numeric|min:0',
            'estado' => 'required|string',
            'notas' => 'nullable|string',
        ]);

        // Si no se envía peso_kg, lo dejamos en null
        if (!isset($validated['peso_kg'])) {
            $validated['peso_kg'] = null;
        }

        // Marcar como programada si tiene fecha
        if (isset($validated['fecha_programada'])) {
            $validated['programada'] = true;
        }

        $collection = Collection::create($validated);

        // Enviar email de confirmación de forma asíncrona
        if ($collection->programada && $collection->user) {
            EnviarNotificacionRecoleccion::dispatch($collection, 'confirmacion');
        }

        return redirect()->route('collections.index')->with('success', 'Recolección creada exitosamente. Se ha enviado un email de confirmación.');
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
            'notas' => 'nullable|string',
        ]);

        $collection->update($validated);

        return redirect()->route('collections.index')->with('success', 'Recolección actualizada exitosamente');
    }

    public function destroy(Collection $collection)
    {
        $collection->delete();
        return redirect()
            ->route('collections.index')
            ->with('alert', [
                'type' => 'success',
                'title' => '¡Eliminado!',
                'text' => 'La recolección ha sido eliminada exitosamente',
            ]);
    }

    public function registerWaste($id)
    {
        $collection = Collection::all()->find($id);
        // Obtener los tipos de residuos y los detalles existentes
        $tiposResiduos = Collection::getTiposResiduos();
        $details = $collection->details;

        // Verificar que el usuario sea un recolector
        if (!auth()->user()->hasRole('Recolector')) {
            return redirect()->route('collections.index')->with('error', 'No tienes permiso para registrar residuos.');
        }

        // Verificar que la recolección esté pendiente
        if ($collection->estado !== 'pendiente') {
            return redirect()->route('collections.index')->with('error', 'Solo se pueden registrar residuos en recolecciones pendientes.');
        }

        //return view('collections.register-waste', compact('collection'));

        return view('collections.register-waste', compact('collection', 'tiposResiduos', 'details'));

        // echo "Funcionalidad en desarrollo";
    }

    public function updateWaste(Request $request, $id)
    {
        $collection = Collection::findOrFail($id);
        //$puntosPorKg = Point::findOrFail($id); // Asumiendo que hay un registro con ID 1

        $setting = Setting::first();

        \Log::info('Iniciando updateWaste para collection_id: ' . $collection->id);
        \Log::info('Datos recibidos:', $request->all());

        // Validación de datos
        $request->validate([
            'tipos.*' => 'required|string',
            'pesos.*' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string',
        ]);

        try {
            \DB::beginTransaction();
            \Log::info('Iniciando transacción');
            \Log::info('Collection ID: ' . $collection->id);

            $pesoTotal = 0;

            // Crear nuevos detalles
            foreach ($request->tipos as $index => $tipo) {
                $peso = $request->pesos[$index];

                \Log::info("Creando detalle para collection_id {$collection->id}: Tipo: {$tipo}, Peso: {$peso}");

                // Usar la relación para crear el detalle
                $detalle = $collection->details()->create([
                    'collection_id' => $collection->id,
                    'tipo_residuo' => $tipo,
                    'peso_kg' => $peso,
                    'observaciones' => $request->observaciones,
                ]);

                if (!$detalle) {
                    throw new \Exception('Error al guardar el detalle de la colección');
                }

                $pesoTotal += $peso;
            }

            \Log::info("Actualizando colección {$collection->id}. Peso total: {$pesoTotal}");

            // Actualizar el estado, peso total y tipos de residuos de la colección
            $collection->estado = 'completado';
            $collection->peso_kg = $pesoTotal;
            // Concatenar todos los tipos de residuos
            $collection->tipo_residuo = implode(', ', array_unique($request->tipos));

            /* $puntos = $setting->value * $pesoTotal; // Asumiendo que 'value' es el campo que contiene los puntos por kg
              // Asignar puntos al usuario
            $puntosPorKg = new Point();
            $puntosPorKg->usuario_id = $collection->user_id;
            $puntosPorKg->puntos = $puntos;
            $puntosPorKg->save(); */

            // Asegúrate antes de esto de tener $pesoTotal y $pointsPerKg (valor numérico)
            $pointsPerKg = Setting::First()->value;
            $puntos = $pointsPerKg * $pesoTotal;
            \Log::info("Calculando puntos desde el Setting: {$pointsPerKg} puntos/kg * {$pesoTotal} kg = {$puntos} puntos");

            // Buscar el registro Point del usuario; si no existe, lo crea y suma los puntos
            $point = Point::firstOrNew(['usuario_id' => $collection->user_id]); // busca por usuario
            $point->puntos = ($point->puntos ?? 0) + $puntos;
            $point->save();

            if (Point::where('usuario_id', $collection->user_id)->exists()) {
                $point->puntos = $point->puntos + $puntos;
            } else {
                Point::create([
                    'usuario_id' => $collection->user_id,
                    'puntos' => $puntos,
                ]);
            }

            

            if (!$collection->save()) {
                throw new \Exception('Error al actualizar la colección principal');
            }

            \DB::commit();
            \Log::info('Transacción completada exitosamente');

            return redirect()
                ->route('collections.index')
                ->with('success', 'Residuos registrados exitosamente')
                ->with('alert', [
                    'type' => 'success',
                    'title' => '¡Éxito!',
                    'text' => 'Los residuos han sido registrados exitosamente',
                ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error en updateWaste: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return redirect()
                ->back()
                ->with('error', 'Error al registrar los residuos: ' . $e->getMessage())
                ->withInput();
        }
    }
}
