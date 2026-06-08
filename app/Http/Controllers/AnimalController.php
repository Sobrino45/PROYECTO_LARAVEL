<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use Illuminate\Support\Facades\Session;

class AnimalController extends Controller
{
    public function index()
    {
        // Extraer todos los animales usando Eloquent
        $animales = Animal::all();

        // Calcular la especie más numerosa
        $masNumerosa = Animal::orderBy('cantidad', 'desc')->first();

        // Lógica de sesión
        if ($masNumerosa) {
            $maxSesion = Session::get('especie_mas_numerosa');
            
            if (!$maxSesion || $masNumerosa->cantidad > $maxSesion['cantidad']) {
                Session::put('especie_mas_numerosa', [
                    'especie' => $masNumerosa->especie,
                    'cantidad' => $masNumerosa->cantidad
                ]);
            }
        }

        return view('animales.index', compact('animales'));
    }

    public function addUnits(Request $request, $id)
    {
        // Validar que se reciba un número mayor a 0
        $request->validate([
            'unidades' => 'required|numeric|min:1'
        ]);

        // Sumar unidades usando Eloquent
        $animal = Animal::findOrFail($id);
        $animal->cantidad += $request->unidades;
        $animal->save();

        return redirect()->route('animales.index');
    }
}