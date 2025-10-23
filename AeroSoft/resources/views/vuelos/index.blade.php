<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>AeroSoft</h1>

<div class="container">
    <h2 class="text-center mb-4">🛫 Buscar vuelos</h2>

    <form action="{{ route('vuelos.buscar') }}" method="GET" class="card p-4">
        <div class="mb-3">
            <label>Origen:</label>
            <select name="origen" class="form-control" required>
                <option value="">Selecciona una ciudad</option>
                @foreach ($ciudades as $c)
                    <option value="{{ $c->nombre }}">{{ $c->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Destino:</label>
            <select name="destino" class="form-control" required>
                <option value="">Selecciona una ciudad</option>
                @foreach ($ciudades as $c)
                    <option value="{{ $c->nombre }}">{{ $c->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Fecha de salida:</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tipo de tiquete:</label>
            <select name="tipo_tiquete" class="form-control">
                <option value="">Cualquiera</option>
                @foreach ($tipos as $t)
                    <option value="{{ $t->id_tipo_tiquete }}">{{ $t->tipo_tiquete }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Buscar vuelos</button>
    </form>
</div>
</body>
</html>