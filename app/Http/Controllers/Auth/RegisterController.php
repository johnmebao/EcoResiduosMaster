<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Persona;
use App\Models\Point;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'telefono' => ['required', 'string', 'max:100', 'unique:personals,telefono'],
            'direccion' => ['required', 'string', 'max:100'],
            'documento' => ['required', 'string', 'max:100', 'unique:personals,documento'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        try {
            DB::beginTransaction();
            
            // 1) crear usuario y guardarlo en $user
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            // 2) asignar rol (usando Spatie)
            $user->assignRole('Usuario');

            // 3) crear la persona en la tabla personals
            try {
                $persona = new Persona();
                $persona->nombres = $data['name'];
                $persona->email = $data['email'];
                $persona->telefono = $data['telefono'];
                $persona->direccion = $data['direccion'];
                $persona->documento = $data['documento'];
                $persona->usuario_id = $user->id;
                
                $persona->save();
                Log::info('Persona creada con ID: ' . $persona->id);
            } catch (\Exception $e) {
                Log::error('Error al crear persona: ' . $e->getMessage());
                throw $e;
            }

            // 4) Crear registro inicial de puntos
            try {
                Point::create([
                    'usuario_id' => $user->id,
                    'puntos' => 0,
                    'puntos_canjeados' => 0
                ]);
                Log::info('Registro de puntos creado para usuario: ' . $user->id);
            } catch (\Exception $e) {
                Log::error('Error al crear puntos iniciales: ' . $e->getMessage());
                throw $e;
            }

            DB::commit();
            return $user;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en registro de usuario: ' . $e->getMessage());
            throw $e;
        }
    }
}
