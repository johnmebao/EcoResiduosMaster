<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Web\CollectionController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\CompanyController;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Web\SettingController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\LocalidadController;
use App\Http\Controllers\RutaController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

// Dashboard
Route::get('/admin/dashboard', function() {return view('dashboard');})->name('admin.dashboard')->middleware('auth');

// Collections - Protegidas con autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index');
    Route::get('/collections/create', [CollectionController::class, 'create'])->name('collections.create');
    Route::post('/collections', [CollectionController::class, 'store'])->name('collections.store');
    Route::get('/collections/{id}/show', [CollectionController::class, 'show'])->name('collections.show');
    Route::get('/collections/{id}/edit', [CollectionController::class, 'edit'])->name('collections.edit');
    Route::post('/collections/{id}/mark-completed', [CollectionController::class, 'markCompleted'])->name('collections.markCompleted');
    Route::get('collections/{id}/register-waste', [CollectionController::class, 'registerWaste'])->name('collections.register-waste');
    Route::put('collections/{id}/update-waste', [CollectionController::class, 'updateWaste'])->name('collections.update-waste');
});

// Rutas para la gestión de puntos de reciclaje
Route::get('/recycling-points', [PointController::class, 'index'])->name('recycling-points.index')->middleware('auth');


// Users - Protegidas con autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
});

// Personas
//Route::get('/personas', [PersonaController::class, 'index'])->name('personas.index');
//Route::get('/personas/create', [PersonaController::class, 'create'])->name('personas.create');
//Route::post('/personas', [PersonaController::class, 'store'])->name('personas.store');
//Route::get('/personas/{id}', [PersonaController::class, 'show'])->name('personas.show');


// RUTAS PARA LA GESTIÓN DE PERSONAL - Protegidas con autenticación y rol Administrador
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::get('/personas', [PersonaController::class, 'index'])->name('personas.index');
    Route::get('/personas/create', [PersonaController::class, 'create'])->name('personas.create');
    Route::post('/personas/create', [PersonaController::class, 'store'])->name('personas.store');
    Route::get('/personas/edit/{id}', [PersonaController::class, 'edit'])->name('personas.edit');
    Route::put('/personas/{id}', [PersonaController::class, 'update'])->name('personas.update');
    Route::delete('/personas/delete/{id}', [PersonaController::class, 'destroy'])->name('personas.destroy');
});

// RUTAS PARA LA GESTION DE ROLES - Protegidas con autenticación y rol Administrador
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles.index');
    Route::get('/admin/roles/create', [RoleController::class, 'create'])->name('admin.roles.create');
    Route::post('/admin/roles/create', [RoleController::class, 'store'])->name('admin.roles.store');
    Route::get('/admin/roles/edit/{id}', [RoleController::class, 'edit'])->name('admin.roles.edit');
    Route::put('/admin/roles/{id}', [RoleController::class, 'update'])->name('admin.roles.update');
    Route::delete('/admin/roles/delete/{id}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');
    Route::get('/admin/roles/permisos/{id}', [RoleController::class, 'permiso'])->name('admin.roles.permiso');
    Route::put('/admin/roles/permisos/{id}', [RoleController::class, 'actualizar_permiso'])->name('admin.roles.actualizar_permiso');
});

// RUTAS PARA LOCALIDADES Y RUTAS - Protegidas con autenticación y rol Administrador
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::resource('localidades', LocalidadController::class);
    Route::resource('rutas', RutaController::class);
});

// Companies - Protegidas con autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
    Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
    Route::get('/companies/{id}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
    Route::put('/companies/{id}', [CompanyController::class, 'update'])->name('companies.update');
    Route::get('/companies/{id}', [CompanyController::class, 'show'])->name('companies.show');
    Route::get('/companies/{id}/delete', [CompanyController::class, 'destroy'])->name('companies.destroy');
});

// Reports - Protegidas con autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
});

// Settings - Protegidas con autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/settings/create', [SettingController::class, 'create'])->name('settings.create');
});



