<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Lista</h1>

    <form action="{{ route('admin_lista') }}" method="get">
        <label for="Buscar">Buscar</label><input type="text" name="Buscar" value="{{ request('Buscar') }}">
        <button type="submit">Buscar</button>
        <select name="genero">
            <option>todos</option>
            <option value="1" {{ request('rol') == 1 ? 'selected': '' }}>Hombre</option>
            <option value="2" {{ request('rol') == 2 ? 'selected': '' }}>Mujer</option>
            <option value="3" {{ request('rol') == 3 ? 'selected': '' }}>Otros</option>
        </select>
        <button type="submit">Filtrar</button>
        <a href="{{ route('admin_lista') }}"><button type="button">Limpiar</button></a>
    </form>

    <table border="5">
        <thead>
            <tr>
                <th>Nombres</th>
                <th>Primer Apellido</th>
                <th>Segundo Apellido</th>
                <th>Genero</th>
                <th>Tipo de documento</th>
                <th>Numero de documento</th>
                <th>celular</th>
                <th>Correo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($user as $u)
            <tr>
                <th>{{ $u->Nombres }}</th>
                <th>{{ $u->Primer_Apellido }}</th>
                <th>{{ $u->Segundo_Apellido }}</th>
                <th>{{ $u->Genero->Genero }}</th>
                <th>{{ $u->TD->Documento }}</th>
                <th>{{ $u->N_Documento }}</th>
                <th>{{ $u->Celular }}</th>
                <th>{{ $u->Correo }}</th>
                <th>{{ $u->Activida ? 'Activado' : 'desactivado' }}</th>
            @empty
            <th colspan="9"></th>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>