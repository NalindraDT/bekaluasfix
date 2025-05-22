<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\ProdiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Dosen routes
Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
Route::get('/kelas/create', [KelasController::class, 'create'])->name('kelas.create');
Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
Route::get('/kelas/{nidn}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
Route::put('/kelas/{nidn}', [KelasController::class, 'update'])->name('kelas.update');
Route::delete('/kelas/{nidn}', [KelasController::class, 'destroy'])->name('kelas.destroy');

// Mahasiswa routes
Route::get('/prodi', [ProdiController::class, 'index'])->name('prodi.index');
Route::get('/prodi/create', [ProdiController::class, 'create'])->name('prodi.create');
Route::post('/prodi', [ProdiController::class, 'store'])->name('prodi.store');
Route::get('/prodi/{nim}/edit', [ProdiController::class, 'edit'])->name('prodi.edit');
Route::put('/prodi/{nim}', [ProdiController::class, 'update'])->name('prodi.update');
Route::delete('/prodi/{nim}', [ProdiController::class, 'destroy'])->name('prodi.destroy');
