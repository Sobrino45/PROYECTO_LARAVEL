<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\ServicioController;

Route::get('/', [AnimalController::class, 'index'])->name('animales.index');
Route::post('/animales/{id}/add-units', [AnimalController::class, 'addUnits'])->name('animales.addUnits');

Route::get('/animales/create', [AnimalController::class, 'create'])->name('animales.create');
Route::post('/animales', [AnimalController::class, 'store'])->name('animales.store');

Route::get('/buscar', [AnimalController::class, 'search'])->name('animales.search');
Route::get('/exportar-csv', [AnimalController::class, 'exportCsv'])->name('animales.export');

Route::get('/servicio', [ServicioController::class, 'getAnimales']);
Route::put('/servicio', [ServicioController::class, 'updateComida']);