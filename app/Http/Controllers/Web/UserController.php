<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Listar usuarios
        return view('users.index');
    }

    public function show($id)
    {
        // Mostrar detalle de usuario
        return view('users.show', compact('id'));
    }
}
