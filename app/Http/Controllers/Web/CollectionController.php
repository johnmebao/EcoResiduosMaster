<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index()
    {
        // Listar recolecciones
        return view('collections.index');
    }

    public function show($id)
    {
        // Mostrar detalle de recolección
        return view('collections.show', compact('id'));
    }

    public function create()
    {
        // Formulario para crear recolección
        return view('collections.create');
    }

    public function store(Request $request)
    {
        // Guardar nueva recolección
        // ... lógica ...
        return redirect()->route('collections.index');
    }

    public function markCompleted($id)
    {
        // Marcar recolección como completada
        // ... lógica ...
        return redirect()->route('collections.index');
    }
}
