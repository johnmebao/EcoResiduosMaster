<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Configuración del sistema
        return view('settings.index');
    }

    public function create()
    {
        // Formulario para crear configuración
        return view('settings.create');
    }
}
