<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\Especie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

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

    public function create(Request $request)
    {
        // Obtener especies de la base de datos para el select
        $especies = Especie::orderBy('nombre')->get();
        
        // Leer la cookie (si existe)
        $ultimaEspecie = $request->cookie('ultima_especie_elegida');

        return view('animales.create', compact('especies', 'ultimaEspecie'));
    }

    public function store(Request $request)
    {
        // Validar el formulario
        $request->validate([
            'especie' => 'required|string|max:30',
            'cantidad' => 'required|numeric|min:1',
            'comida' => 'required|string|max:30'
        ]);

        // Comprobar si ya existe un animal con ese nombre de especie
        $animalExistente = Animal::where('especie', $request->especie)->first();

        if ($animalExistente) {
            // Si existe, sumar la cantidad
            $animalExistente->cantidad += $request->cantidad;
            $animalExistente->save();
        } else {
            // Si no existe, crear un registro nuevo
            Animal::create([
                'especie' => $request->especie,
                'cantidad' => $request->cantidad,
                'comida' => $request->comida
            ]);
        }

        // Crear cookie válida por 1 mes (43200 minutos)
        Cookie::queue('ultima_especie_elegida', $request->especie, 43200);

        return redirect()->route('animales.index');
    }
}