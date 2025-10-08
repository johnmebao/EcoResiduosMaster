<?php


namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public $timestamps = true;
    public function __construct()
    {
        $this->middleware('auth');
        // Opcional: agregar middleware de permisos si solo admin puede gestionar settings
        // $this->middleware('role:admin');
    }

    /**
     * Mostrar listado de todas las configuraciones
     */
    public function index()
    {
        $settings = Setting::orderBy('key')->get();
        return view('settings.index', compact('settings'));
    }

    /**
     * Mostrar formulario para crear nueva configuración
     */
    public function create()
    {
        return view('settings.create');
    }

    /**
     * Guardar nueva configuración en la base de datos
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required|string|max:255|unique:settings,key',
            'value' => 'required',
            'description' => 'nullable|string|max:500',
        ], [
            'key.required' => 'La clave es obligatoria.',
            'key.unique' => 'Esta clave ya existe en el sistema.',
            'value.required' => 'El valor es obligatorio.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Setting::create([
                'key' => $request->key,
                'value' => $request->value,
                'description' => $request->description,
            ]);

            return redirect()->route('settings.index')
                ->with('success', 'Configuración creada exitosamente.');
        } catch (\Exception $e) {
            \Log::error('Error al crear configuración: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al crear la configuración: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Mostrar una configuración específica
     */
    public function show(Setting $setting)
    {
        return view('settings.show', compact('setting'));
    }

    /**
     * Mostrar formulario para editar configuración existente
     */
    public function edit($id)
    {
        $setting = Setting::findOrFail($id);
        return view('settings.edit', compact('setting'));
    }


     /**
     * Actualizar configuración existente
     */
    public function update(Request $request, Setting $setting)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required|string|max:255|unique:settings,key,' . $setting->id,
            'value' => 'required',
            'description' => 'nullable|string|max:500',
        ], [
            'key.required' => 'La clave es obligatoria.',
            'key.unique' => 'Esta clave ya existe en el sistema.',
            'value.required' => 'El valor es obligatorio.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $setting->update([
                'key' => $request->key,
                'value' => $request->value,
                'description' => $request->description,
            ]);

            return redirect()->route('settings.index')
                ->with('success', 'Configuración actualizada exitosamente.');
        } catch (\Exception $e) {
            \Log::error('Error al actualizar configuración: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al actualizar la configuración: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Eliminar configuración
     */
    public function destroy(Setting $setting)
    {
        try {
            $key = $setting->key;
            $setting->delete();

            return redirect()->route('settings.index')
                ->with('success', "Configuración '{$key}' eliminada exitosamente.");
        } catch (\Exception $e) {
            \Log::error('Error al eliminar configuración: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al eliminar la configuración: ' . $e->getMessage());
        }
    }
}
