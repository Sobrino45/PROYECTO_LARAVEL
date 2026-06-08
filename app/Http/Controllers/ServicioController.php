<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;

class ServicioController extends Controller
{
    // Método GET para consultar
    public function getAnimales(Request $request)
    {
        if (!$request->has('cantidad')) {
            return response()->json(['error' => 'Falta parametro cantidad'], 400);
        }

        $animales = Animal::where('cantidad', '>', $request->cantidad)->get();

        if ($animales->isEmpty()) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        return response()->json($animales, 200);
    }

    // Método PUT para actualizar comida
    public function updateComida(Request $request)
    {
        if (!$request->has('especie') || !$request->has('comida')) {
            return response()->json(['error' => 'Falta parametro'], 400);
        }

        $animal = Animal::where('especie', $request->especie)->first();

        if (!$animal) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $animal->comida = $request->comida;
        $animal->save();

        return response()->json(['codigo' => 200, 'mensaje' => 'Actualizacion correcta'], 200);
    }
}