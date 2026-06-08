@extends('layouts.app')

@section('content')
    <div class="header-info">
        <h3>Especie más numerosa (Sesión)</h3>
        @if(Session::has('especie_mas_numerosa'))
            <p>Especie: <strong>{{ Session::get('especie_mas_numerosa')['especie'] }}</strong> | Cantidad: <strong>{{ Session::get('especie_mas_numerosa')['cantidad'] }}</strong></p>
        @else
            <p>Aún no hay datos en sesión.</p>
        @endif
    </div>

    <h2>Listado de Animales</h2>
    
    <a href="{{ route('animales.create') }}" class="btn">Dar de alta nueva especie</a>
    <a href="{{ route('animales.search') }}" class="btn">Abrir página de consulta</a>
    <br><br>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Especie</th>
                <th>Cantidad</th>
                <th>Tipo de Comida</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($animales as $animal)
                <tr>
                    <td>{{ $animal->id }}</td>
                    <td>{{ $animal->especie }}</td>
                    <td>{{ $animal->cantidad }}</td>
                    <td>{{ $animal->comida }}</td>
                    <td>
                        <form action="{{ route('animales.addUnits', $animal->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="number" name="unidades" min="1" required placeholder="Uds." style="width: 60px;">
                            <button type="submit" class="btn btn-green">Añadir unidades</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection