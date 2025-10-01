<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::latest()->get();
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo_residuos' => 'required|array',
            'tipo_residuos.*' => 'required|string',
            'contacto' => 'required|string|max:255'
        ]);

        // Convertir array de tipos de residuos a string
        $validated['tipo_residuos'] = implode(',', $validated['tipo_residuos']);

        Company::create($validated);

        return redirect()
            ->route('companies.index')
            ->with('success', 'Empresa creada exitosamente');
    }

    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo_residuos' => 'required|array',
            'tipo_residuos.*' => 'required|string',
            'contacto' => 'required|string|max:255'
        ]);

        // Convertir array de tipos de residuos a string
        $validated['tipo_residuos'] = implode(',', $validated['tipo_residuos']);

        $company->update($validated);

        return redirect()
            ->route('companies.index')
            ->with('success', 'Empresa actualizada exitosamente');
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()
            ->route('companies.index')
            ->with('success', 'Empresa eliminada exitosamente');
    }
}
