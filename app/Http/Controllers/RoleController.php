<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all roles from the database
        $roles = Role::all();

        // Return the roles as a JSON response
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new role
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:100|unique:roles,name',
        ]);

        // Create a new role with the validated data
        Role::create([
            'name' => $request->name,
        ]);

        // Redirect to the roles index with a success message
        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Find the role by ID
        $role = Role::findOrFail($id);

        // Return the view for editing the role
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $datos = $request->all();
        // return response()->json($datos);

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:100|unique:roles,name,' . $id,
        ]);

        // Find the role by ID and update it with the validated data
        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->guard_name = 'web'; // Assuming the guard name is 'web', adjust if necessary
        $role->save();

        // Redirect to the roles index with a success message
        return redirect()->route('admin.roles.index')->with('success', 'Role actualizado correctamente.');   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the role by ID
        $role = Role::findOrFail($id);

        // Delete the role
        $role->delete();

        // Redirect to the roles index with a success message
        return redirect()->route('admin.roles.index')->with('success', 'Role eliminado correctamente.');    
    }

    //GENERAR permisos para un rol
    public function permiso(string $id)
    {
        // Find the role by ID
        $rol = Role::findOrFail($id);
        $permisos = Permission::all()->groupBy(function ($permiso) {
            if(stripos($permiso->name, 'collections') !== false) { return 'Recolección de Residuos';}
            if(stripos($permiso->name, 'solicitudes') !== false) { return 'Solicitudes';}   
            if(stripos($permiso->name, 'recycling') !== false) { return 'Puntos de Reciclaje';}
            if(stripos($permiso->name, 'users') !== false) { return 'Usuarios';}
            if(stripos($permiso->name, 'personas') !== false) { return 'Personas';}
            if(stripos($permiso->name, 'roles') !== false) { return 'Roles y Permisos';}
            if(stripos($permiso->name, 'companies') !== false) { return 'Empresas';}
            if(stripos($permiso->name, 'reports') !== false) { return 'Reportes';}
            if(stripos($permiso->name, 'settings') !== false) { return 'Configuraciones';}
            if(stripos($permiso->name, 'canjes') !== false) { return 'Canjes';}
            return 'Otros';
        });

        return view('admin.roles.permisos', compact('rol', 'permisos'));
    }    


    public function actualizar_permiso(Request $request, $id)
    {
        // Find the role by ID
        $rol = Role::findOrFail($id);
        // Sincroniza los permisos usando IDs
        $rol->permissions()->sync($request->input('permisos'));

        // Redirect to the roles index with a success message
        return redirect()->route('admin.roles.index')->with('success', 'Permisos actualizados correctamente.');
    }
    
}