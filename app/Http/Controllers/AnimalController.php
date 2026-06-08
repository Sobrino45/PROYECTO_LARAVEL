<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\Especie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class AnimalController extends Controller
{
    public function index()
    {
        $animales = Animal::all();
        $masNumerosa = Animal::orderBy('cantidad', 'desc')->first();

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
        $request->validate([
            'unidades' => 'required|numeric|min:1'
        ]);

        $animal = Animal::findOrFail($id);
        $animal->cantidad += $request->unidades;
        $animal->save();

        return redirect()->route('animales.index');
    }

    public function create(Request $request)
    {
        $especies = Especie::orderBy('nombre')->get();
        $ultimaEspecie = $request->cookie('ultima_especie_elegida');

        return view('animales.create', compact('especies', 'ultimaEspecie'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'especie' => 'required|string|max:30',
            'cantidad' => 'required|numeric|min:1',
            'comida' => 'required|string|max:30'
        ]);

        $animalExistente = Animal::where('especie', $request->especie)->first();

        if ($animalExistente) {
            $animalExistente->cantidad += $request->cantidad;
            $animalExistente->save();
        } else {
            Animal::create([
                'especie' => $request->especie,
                'cantidad' => $request->cantidad,
                'comida' => $request->comida
            ]);
        }

        Cookie::queue('ultima_especie_elegida', $request->especie, 43200);

        return redirect()->route('animales.index');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $animales = collect();

        if ($query) {
            // Filtrado LIKE (case-insensitive por defecto en MySQL)
            $animales = Animal::where('especie', 'LIKE', '%' . $query . '%')->get();
        }

        return view('animales.search', compact('animales', 'query'));
    }

    public function exportCsv(Request $request)
    {
        $query = $request->input('q');
        $animales = Animal::where('especie', 'LIKE', '%' . $query . '%')->get();

        $csvData = "";
        foreach ($animales as $animal) {
            $csvData .= $animal->especie . "," . $animal->cantidad . "\n";
        }

        // Formato requerido: dia.mes.año.hora.minuto.csv
        $fileName = date('d.m.Y.H.i') . '.csv';
        
        // Guardar en la carpeta Model dentro de storage/app
        Storage::disk('local')->put('Model/' . $fileName, $csvData);

        return Storage::download('Model/' . $fileName);
    }
}