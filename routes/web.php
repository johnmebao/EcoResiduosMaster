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
use App\Http\Controllers\SolicitudPeligrososController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\CanjeController;
use App\Http\Controllers\ReporteController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

// Dashboard
Route::get('/admin/dashboard', function() {return view('dashboard');})->name('admin.dashboard')->middleware('auth');

// Collections - Protegidas con autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index')->middleware('auth','can:collections.index');
    Route::get('/collections/create', [CollectionController::class, 'create'])->name('collections.create')->middleware('auth','can:collections.create');
    Route::post('/collections', [CollectionController::class, 'store'])->name('collections.store')->middleware('auth','can:collections.store');
    Route::get('/collections/{id}/show', [CollectionController::class, 'show'])->name('collections.show')->middleware('auth','can:collections.show');
    Route::get('/collections/{id}/edit', [CollectionController::class, 'edit'])->name('collections.edit')->middleware('auth','can:collections.edit');
    Route::post('/collections/{id}/mark-completed', [CollectionController::class, 'markCompleted'])->name('collections.markCompleted')->middleware('auth','can:collections.markCompleted');
    Route::get('collections/{id}/register-waste', [CollectionController::class, 'registerWaste'])->name('collections.register-waste')->middleware('auth','can:collections.register-waste');
    Route::put('collections/{id}/update-waste', [CollectionController::class, 'updateWaste'])->name('collections.update-waste')->middleware('auth','can:collections.update-waste');
    
    // Rutas específicas para tipos de recolección (FASE 2)
    Route::post('/collections/organicos', [CollectionController::class, 'storeOrganicos'])->name('collections.store-organicos')->middleware('auth','can:collections.store-organicos');
    Route::post('/collections/inorganicos', [CollectionController::class, 'storeInorganicos'])->name('collections.store-inorganicos')->middleware('auth','can:collections.store-inorganicos');
});

// Solicitudes de Recolección de Residuos Peligrosos - Protegidas con autenticación
Route::middleware(['auth'])->group(function () {
    Route::resource('solicitudes-peligrosos', SolicitudPeligrososController::class);
});

// Gestión de Solicitudes de Peligrosos - Solo Administradores
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/solicitudes-peligrosos/pendientes', [SolicitudPeligrososController::class, 'pendientes'])->name('admin.solicitudes-peligrosos.pendientes')->middleware('auth','can:admin.solicitudes-peligrosos.pendientes');
    Route::post('/admin/solicitudes-peligrosos/{id}/aprobar', [SolicitudPeligrososController::class, 'aprobar'])->name('admin.solicitudes-peligrosos.aprobar')->middleware('auth','can:admin.solicitudes-peligrosos.aprobar');
    Route::post('/admin/solicitudes-peligrosos/{id}/rechazar', [SolicitudPeligrososController::class, 'rechazar'])->name('admin.solicitudes-peligrosos.rechazar')->middleware('auth','can:admin.solicitudes-peligrosos.rechazar');
    Route::post('/admin/solicitudes-peligrosos/{id}/programar', [SolicitudPeligrososController::class, 'programar'])->name('admin.solicitudes-peligrosos.programar')->middleware('auth','can:admin.solicitudes-peligrosos.programar');
});

// Rutas para la gestión de puntos de reciclaje
Route::get('/recycling-points', [PointController::class, 'index'])->name('recycling-points.index')->middleware('auth','can:recycling-points.index');


// Users - Protegidas con autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('auth','can:users.index');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show')->middleware('auth','can:users.show');
});

// RUTAS PARA LA GESTIÓN DE PERSONAL - Protegidas con autenticación y rol Administrador
Route::middleware(['auth'])->group(function () {
    Route::get('/personas', [PersonaController::class, 'index'])->name('personas.index')->middleware('auth','can:personas.index');
    Route::get('/personas/create', [PersonaController::class, 'create'])->name('personas.create')->middleware('auth','can:personas.create');
    Route::post('/personas/create', [PersonaController::class, 'store'])->name('personas.store')->middleware('auth','can:personas.store');
    Route::get('/personas/edit/{id}', [PersonaController::class, 'edit'])->name('personas.edit')->middleware('auth','can:personas.edit');
    Route::put('/personas/{id}', [PersonaController::class, 'update'])->name('personas.update')->middleware('auth','can:personas.update');
    Route::delete('/personas/delete/{id}', [PersonaController::class, 'destroy'])->name('personas.destroy')->middleware('auth','can:personas.destroy');
});

// RUTAS PARA LA GESTION DE ROLES - Protegidas con autenticación y rol Administrador
Route::middleware(['auth' ])->group(function () {
    Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles.index')->middleware('auth','can:admin.roles.index');
    Route::get('/admin/roles/create', [RoleController::class, 'create'])->name('admin.roles.create')->middleware('auth','can:admin.roles.create');
    Route::post('/admin/roles/create', [RoleController::class, 'store'])->name('admin.roles.store')->middleware('auth','can:admin.roles.store');
    Route::get('/admin/roles/edit/{id}', [RoleController::class, 'edit'])->name('admin.roles.edit')->middleware('auth','can:admin.roles.edit');
    Route::put('/admin/roles/{id}', [RoleController::class, 'update'])->name('admin.roles.update')->middleware('auth','can:admin.roles.update');
    Route::delete('/admin/roles/delete/{id}', [RoleController::class, 'destroy'])->name('admin.roles.destroy')->middleware('auth','can:admin.roles.destroy');
    Route::get('/admin/roles/permisos/{id}', [RoleController::class, 'permiso'])->name('admin.roles.permiso')->middleware('auth','can:admin.roles.permiso');
    Route::put('/admin/roles/permisos/{id}', [RoleController::class, 'actualizar_permiso'])->name('admin.roles.actualizar_permiso')->middleware('auth','can:admin.roles.actualizar_permiso');
});

// RUTAS PARA LOCALIDADES Y RUTAS - Protegidas con autenticación y rol Administrador
Route::middleware(['auth'])->group(function () {
    Route::resource('localidades', LocalidadController::class);
    Route::resource('rutas', RutaController::class);
});

// Companies - Protegidas con autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index')->middleware('auth','can:companies.index');
    Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create')->middleware('auth','can:companies.create');
    Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store')->middleware('auth','can:companies.store');
    Route::get('/companies/{id}/edit', [CompanyController::class, 'edit'])->name('companies.edit')->middleware('auth','can:companies.edit');
    Route::put('/companies/{id}', [CompanyController::class, 'update'])->name('companies.update')->middleware('auth','can:companies.update');
    Route::get('/companies/{id}', [CompanyController::class, 'show'])->name('companies.show')->middleware('auth','can:companies.show');
    Route::get('/companies/{id}/delete', [CompanyController::class, 'destroy'])->name('companies.destroy')->middleware('auth','can:companies.destroy');
});

// Reports - Protegidas con autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index')->middleware('auth','can:reports.index');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create')->middleware('auth','can:reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store')->middleware('auth','can:reports.store');
});

// Settings - Protegidas con autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index')->middleware('auth','can:settings.index');
    Route::get('/settings/create', [SettingController::class, 'create'])->name('settings.create')->middleware('auth','can:settings.create');
    Route::post('/settings', [SettingController::class, 'store'])->name('settings.store')->middleware('auth','can:settings.store');
    Route::get('/settings/edit/{id}', [SettingController::class, 'edit'])->name('settings.edit')->middleware('auth','can:settings.edit');
    Route::put('/settings/{id}', [SettingController::class, 'update'])->name('settings.update')->middleware('auth','can:settings.update');
});

// FASE 3: MÓDULO DE CANJES - Protegidas con autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/canjes', [CanjeController::class, 'index'])->name('canjes.index')->middleware('auth','can:canjes.index');
    Route::get('/canjes/create', [CanjeController::class, 'create'])->name('canjes.create')->middleware('auth','can:canjes.create');
    Route::post('/canjes', [CanjeController::class, 'store'])->name('canjes.store')->middleware('auth','can:canjes.store');
    Route::get('/canjes/{canje}', [CanjeController::class, 'show'])->name('canjes.show')->middleware('auth','can:canjes.show');
});

// FASE 3: GESTIÓN DE TIENDAS - Solo Administradores
Route::middleware(['auth'])->group(function () {
    Route::resource('tiendas', TiendaController::class);
});

// FASE 3: REPORTES ADMINISTRATIVOS AVANZADOS - Solo Administradores
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/reportes/localidad', [ReporteController::class, 'reportePorLocalidad'])->name('admin.reportes.localidad');
    Route::get('/admin/reportes/empresa', [ReporteController::class, 'reportePorEmpresa'])->name('admin.reportes.empresa');
    Route::get('/admin/reportes/exportar-pdf', [ReporteController::class, 'exportarPDF'])->name('admin.reportes.exportar-pdf');
    Route::get('/admin/reportes/exportar-csv', [ReporteController::class, 'exportarCSV'])->name('admin.reportes.exportar-csv');
});
