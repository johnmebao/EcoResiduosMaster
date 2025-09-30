<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Web\CollectionController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\CompanyController;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Web\SettingController;

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



