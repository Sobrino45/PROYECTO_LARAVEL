@extends('layouts.app')

@section('content')
    <h2>Dar de Alta Nueva Especie Animal</h2>
    <a href="{{ route('animales.index') }}" class="btn">Volver al listado</a>
    <br><br>

    <form action="{{ route('animales.store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 15px;">
            <label for="especie">Especie:</label><br>
            <select name="especie" id="especie" required style="padding: 5px; width: 200px;">
                <option value="">-- Selecciona --</option>
                @foreach($especies as $esp)
                    <option value="{{ $esp->nombre }}" {{ $ultimaEspecie == $esp->nombre ? 'selected' : '' }}>
                        {{ $esp->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="cantidad">Cantidad:</label><br>
            <input type="number" name="cantidad" id="cantidad" min="1" required style="padding: 5px; width: 186px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="comida">Comida:</label><br>
            <input type="text" name="comida" id="comida" required style="padding: 5px; width: 186px;">
        </div>
        
        <button type="submit" class="btn btn-green">Guardar Animal</button>
    </form>
@endsection