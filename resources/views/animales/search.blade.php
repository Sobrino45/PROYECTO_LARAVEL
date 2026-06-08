@extends('layouts.app')

@section('content')
    <h2>Consulta de Animales</h2>
    <a href="{{ route('animales.index') }}" class="btn">Volver al listado</a>
    <br><br>

    <form action="{{ route('animales.search') }}" method="GET" style="margin-bottom: 20px;">
        <input type="text" name="q" value="{{ $query }}" placeholder="Buscar por especie..." required style="padding: 5px; width: 250px;">
        <button type="submit" class="btn">Filtrar</button>
    </form>

    @if(isset($query) && count($animales) > 0)
        <table>
            <thead>
                <tr>
                    <th>Especie</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($animales as $animal)
                    <tr>
                        <td>
                            {!! preg_replace('/(' . preg_quote($query, '/') . ')/i', '<span style="color:red;">$1</span>', $animal->especie) !!}
                        </td>
                        <td>{{ $animal->cantidad }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <form action="{{ route('animales.export') }}" method="GET">
            <input type="hidden" name="q" value="{{ $query }}">
            <button type="submit" class="btn btn-green">Volcar a CSV</button>
        </form>
    @elseif(isset($query))
        <p>No se encontraron resultados para "<strong>{{ $query }}</strong>".</p>
    @endif
@endsection