<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        // Listar empresas recolectoras
        return view('companies.index');
    }

    public function create()
    {
        // Formulario para crear empresa
        return view('companies.create');
    }

    public function store(Request $request)
    {
        // Guardar nueva empresa
        // ... lógica ...
        return redirect()->route('companies.index');
    }

    public function show($id)
    {
        // Mostrar detalle de empresa
        return view('companies.show', compact('id'));
    }
}
