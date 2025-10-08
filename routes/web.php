<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\PreceptorController;
use App\Http\Controllers\HorarioController;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');


Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::resource('/cursos', CursoController::class);
    Route::resource('/docentes', DocenteController::class);
    Route::resource('/preceptores', PreceptorController::class);
    Route::resource('/horarios', HorarioController::class);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    // Resource routes for Docentes, Preceptores, and Horarios
    Route::resource('docentes', DocenteController::class);
    Route::resource('preceptores', PreceptorController::class);
    Route::resource('horarios', HorarioController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
