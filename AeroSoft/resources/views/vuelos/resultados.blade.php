<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <div class="container">
    <h2 class="text-center mb-4">Resultados de la búsqueda</h2>

    @if ($vuelos->count() > 0)
        @foreach ($vuelos as $v)
        <div class="card mb-3">
            <div class="card-body">
                <h4>{{ $v->Origen }} ✈ {{ $v->Destino }}</h4>
                <p>Salida: {{ $v->Fecha_Salida }} {{ $v->Hora_Salida }}</p>
                <p>Avión: {{ $v->N_Avion }} ({{ $v->tipoAvion->Tipo_Avion }})</p>
                <p>Tiquete: {{ $v->tipoTiquete->tipo_tiquete }}</p>
                <p><strong>${{ number_format($v->Precio, 0, ',', '.') }}</strong></p>
                <a href="{{ route('vuelos.asientos', $v->id_vuelo) }}" class="btn btn-success">Seleccionar vuelo</a>
            </div>
        </div>
        @endforeach
    @else
        <p class="text-center">❌ No se encontraron vuelos con esos filtros.</p>
    @endif
</div>
</body>
</html>