<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimalController;

Route::get('/', [AnimalController::class, 'index'])->name('animales.index');
Route::post('/animales/{id}/add-units', [AnimalController::class, 'addUnits'])->name('animales.addUnits');

Route::get('/animales/create', [AnimalController::class, 'create'])->name('animales.create');
Route::post('/animales', [AnimalController::class, 'store'])->name('animales.store');

Route::get('/buscar', [AnimalController::class, 'search'])->name('animales.search');
Route::get('/exportar-csv', [AnimalController::class, 'exportCsv'])->name('animales.export');