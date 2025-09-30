<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Listar reportes
        return view('reports.index');
    }

    public function create()
    {
        // Formulario para crear reporte
        return view('reports.create');
    }

    public function store(Request $request)
    {
        // Guardar nuevo reporte
        // ... lógica ...
        return redirect()->route('reports.index');
    }
}
