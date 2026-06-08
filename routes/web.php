<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimalController;

Route::get('/', [AnimalController::class, 'index'])->name('animales.index');
Route::post('/animales/{id}/add-units', [AnimalController::class, 'addUnits'])->name('animales.addUnits');