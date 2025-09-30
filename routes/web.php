<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Web\CollectionController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\CompanyController;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Web\SettingController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Dashboard
Route::get('/admin/dashboard', function() {return view('dashboard');})->name('admin.dashboard');

// Collections
Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index');
Route::get('/collections/create', [CollectionController::class, 'create'])->name('collections.create');
Route::post('/collections', [CollectionController::class, 'store'])->name('collections.store');
Route::get('/collections/{id}', [CollectionController::class, 'show'])->name('collections.show');
Route::post('/collections/{id}/mark-completed', [CollectionController::class, 'markCompleted'])->name('collections.markCompleted');

// Users
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

// Personas
//Route::get('/personas', [PersonaController::class, 'index'])->name('personas.index');
//Route::get('/personas/create', [PersonaController::class, 'create'])->name('personas.create');
//Route::post('/personas', [PersonaController::class, 'store'])->name('personas.store');
//Route::get('/personas/{id}', [PersonaController::class, 'show'])->name('personas.show');


// RUTAS PARA LA GESTIÓN DE PERSONAL
Route::get('/personas', [PersonaController::class, 'index'])->name('personas.index');//->middleware('auth', 'can:personas.index');
Route::get('/personas/create', [PersonaController::class, 'create'])->name('personas.create');//->middleware('auth', 'can:personas.create');
Route::post('/personas/create', [PersonaController::class, 'store'])->name('personas.store');//->middleware('auth', 'can:personas.store');
Route::get('/personas/edit/{id}', [PersonaController::class, 'edit'])->name('personas.edit');//->middleware('auth', 'can:personas.edit');
Route::put('/personas/{id}', [PersonaController::class, 'update'])->name('personas.update');//->middleware('auth', 'can:personas.update');
Route::delete('/personas/delete/{id}', [PersonaController::class, 'destroy'])->name('personas.destroy');//->middleware('auth', 'can:personas.destroy');

// RUTAS PARA LA GESTION DE ROLES
Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles.index'); //->middleware('auth', 'can:admin.roles.index');
Route::get('/admin/roles/create', [RoleController::class, 'create'])->name('admin.roles.create'); //->middleware('auth', 'can:admin.roles.create');
Route::post('/admin/roles/create', [RoleController::class, 'store'])->name('admin.roles.store'); //->middleware('auth', 'can:admin.roles.store');
Route::get('/admin/roles/edit/{id}', [RoleController::class, 'edit'])->name('admin.roles.edit'); //->middleware('auth', 'can:admin.roles.edit');
Route::put('/admin/roles/{id}', [RoleController::class, 'update'])->name('admin.roles.update'); //->middleware('auth', 'can:admin.roles.update');
Route::delete('/admin/roles/delete/{id}', [RoleController::class, 'destroy'])->name('admin.roles.destroy'); //->middleware('auth', 'can:admin.roles.destroy');
Route::get('/admin/roles/permisos/{id}', [RoleController::class, 'permiso'])->name('admin.roles.permiso'); //->middleware('auth', 'can:admin.roles.permiso');
Route::put('/admin/roles/permisos/{id}', [RoleController::class, 'actualizar_permiso'])->name('admin.roles.actualizar_permiso'); //->middleware('auth', 'can:admin.roles.actualizar_permiso');




// Companies
Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
Route::get('/companies/{id}', [CompanyController::class, 'show'])->name('companies.show');

// Reports
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');

// Settings
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::get('/settings/create', [SettingController::class, 'create'])->name('settings.create');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



