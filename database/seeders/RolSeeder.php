<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Persona;
use App\Models\Sede;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         
        //CREAR ROLES POR DEFECTO
        // COMANDO PARA EJECUITAR LOS SEEDERS: php artisan migrate:refresh --seed
        $administrador = Role::create(['name' => 'Administrador']);
        $responsable = Role::create(['name' => 'Recolector']);
        $usuario = Role::create(['name' => 'Usuario']);

        // Crear usuarios y roles por defecto
        User::create(['name' => 'John Medina Bilbao', 'email' => 'medinabao@gmail.com', 'password' => bcrypt('medina25')])->assignRole('Administrador');  
        Persona::create(['usuario_id' => 1, 'nombres' => 'John Medina Bilbao','documento' => '12345678', 'telefono' => '987654321', 'direccion' => 'Av. Siempre Viva 742', 'email' => 'john@example.com']);
        //Sede::create(['nombre' => 'SEDE PRINCIPAL', 'telefono' => '987654321',]);

        // Assign permissions to roles
        Permission::create(['name' => 'admin.configuracion.index'])->assignRole($administrador);
        Permission::create(['name' => 'admin.configuracion.store'])->assignRole($administrador);
        Permission::create(['name' => 'admin.sedes.index'])->assignRole($administrador);
        Permission::create(['name' => 'admin.sedes.create'])->assignRole($administrador);
        Permission::create(['name' => 'admin.sedes.store'])->assignRole($administrador);
        Permission::create(['name' => 'admin.sedes.edit'])->assignRole($administrador);
        Permission::create(['name' => 'admin.sedes.update'])->assignRole($administrador);
        Permission::create(['name' => 'admin.sedes.destroy'])->assignRole($administrador);
        Permission::create(['name' => 'admin.roles.index'])->assignRole($administrador);
        Permission::create(['name' => 'admin.roles.create'])->assignRole($administrador);
        Permission::create(['name' => 'admin.roles.store'])->assignRole($administrador);
        Permission::create(['name' => 'admin.roles.edit'])->assignRole($administrador);
        Permission::create(['name' => 'admin.roles.update'])->assignRole($administrador);
        Permission::create(['name' => 'admin.roles.destroy'])->assignRole($administrador);
        Permission::create(['name' => 'admin.roles.permiso'])->assignRole($administrador);
        Permission::create(['name' => 'admin.roles.actualizar_permiso'])->assignRole($administrador);
        Permission::create(['name' => 'admin.personal.index'])->assignRole($administrador);
        Permission::create(['name' => 'admin.personal.create'])->assignRole($administrador);
        Permission::create(['name' => 'admin.personal.store'])->assignRole($administrador);
        Permission::create(['name' => 'admin.personal.edit'])->assignRole($administrador);
        Permission::create(['name' => 'admin.personal.update'])->assignRole($administrador);
        Permission::create(['name' => 'admin.personal.destroy'])->assignRole($administrador);
        Permission::create(['name' => 'alerta.configuracion'])->assignRole($administrador);
        Permission::create(['name' => 'alerta.guardar_configuracion'])->assignRole($administrador);
        Permission::create(['name' => 'alerta.boton.mostrar'])->assignRole($administrador);
        Permission::create(['name' => 'alerta.boton.panico'])->assignRole($administrador);

    }
}