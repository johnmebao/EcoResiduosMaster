<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Persona;
use App\Models\Company;
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
        Persona::create(['usuario_id' => 1, 'nombres' => 'John Medina test','documento' => '70786535', 'telefono' => '3046074654', 'direccion' => 'Av. Siempre Viva 743', 'email' => 'test@example.com']);

        Company::create(['nombre' => 'Rio Aseo Total', 'tipo_residuos' => 'Plasticos', 'contacto' => '987654321']);

        // Assign permissions to roles
        Permission::create(['name' => 'collections.index'])->assignRole($administrador);
        Permission::create(['name' => 'collections.create'])->assignRole($administrador);
        Permission::create(['name' => 'collections.store'])->assignRole($administrador);
        Permission::create(['name' => 'collections.show'])->assignRole($administrador);
        Permission::create(['name' => 'collections.edit'])->assignRole($administrador);
        Permission::create(['name' => 'collections.markCompleted'])->assignRole($administrador);
        Permission::create(['name' => 'collections.register-waste'])->assignRole($administrador);
        Permission::create(['name' => 'collections.update-waste'])->assignRole($administrador);
        Permission::create(['name' => 'collections.store-organicos'])->assignRole($administrador);
        Permission::create(['name' => 'collections.store-inorganicos'])->assignRole($administrador);
        Permission::create(['name' => 'admin.solicitudes-peligrosos.pendientes'])->assignRole($administrador);
        Permission::create(['name' => 'admin.solicitudes-peligrosos.aprobar'])->assignRole($administrador);
        Permission::create(['name' => 'admin.solicitudes-peligrosos.rechazar'])->assignRole($administrador);
        Permission::create(['name' => 'admin.solicitudes-peligrosos.programar'])->assignRole($administrador);
        Permission::create(['name' => 'recycling-points.index'])->assignRole($administrador);
        Permission::create(['name' => 'users.index'])->assignRole($administrador);
        Permission::create(['name' => 'users.show'])->assignRole($administrador);
        Permission::create(['name' => 'personas.index'])->assignRole($administrador);
        Permission::create(['name' => 'personas.create'])->assignRole($administrador);
        Permission::create(['name' => 'personas.store'])->assignRole($administrador);
        Permission::create(['name' => 'personas.edit'])->assignRole($administrador);
        Permission::create(['name' => 'personas.update'])->assignRole($administrador);
        Permission::create(['name' => 'personas.destroy'])->assignRole($administrador);
        Permission::create(['name' => 'admin.roles.index'])->assignRole($administrador);
        Permission::create(['name' => 'admin.roles.create'])->assignRole($administrador);
        Permission::create(['name' => 'admin.roles.store'])->assignRole($administrador);
        Permission::create(['name' => 'admin.roles.edit'])->assignRole($administrador);
        Permission::create(['name' => 'admin.roles.update'])->assignRole($administrador);
        Permission::create(['name' => 'admin.roles.destroy'])->assignRole($administrador);
        Permission::create(['name' => 'admin.roles.permiso'])->assignRole($administrador);
        Permission::create(['name' => 'admin.roles.actualizar_permiso'])->assignRole($administrador);
        Permission::create(['name' => 'companies.index'])->assignRole($administrador);
        Permission::create(['name' => 'companies.create'])->assignRole($administrador);
        Permission::create(['name' => 'companies.store'])->assignRole($administrador);
        Permission::create(['name' => 'companies.edit'])->assignRole($administrador);
        Permission::create(['name' => 'companies.update'])->assignRole($administrador);
        Permission::create(['name' => 'companies.destroy'])->assignRole($administrador);
        Permission::create(['name' => 'companies.show'])->assignRole($administrador);
        Permission::create(['name' => 'reports.index'])->assignRole($administrador);
        Permission::create(['name' => 'reports.create'])->assignRole($administrador);
        Permission::create(['name' => 'reports.store'])->assignRole($administrador);
        Permission::create(['name' => 'settings.index'])->assignRole($administrador);
        Permission::create(['name' => 'settings.create'])->assignRole($administrador);
        Permission::create(['name' => 'canjes.index'])->assignRole($administrador);
        Permission::create(['name' => 'canjes.create'])->assignRole($administrador);
        Permission::create(['name' => 'canjes.store'])->assignRole($administrador);
        Permission::create(['name' => 'canjes.show'])->assignRole($administrador);
    }
}