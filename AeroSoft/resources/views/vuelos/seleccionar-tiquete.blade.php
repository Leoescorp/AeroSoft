<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Tipo de Tiquete - AeroSoft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Seleccionar Tipo de Tiquete</h2>
            <a href="javascript:history.back()" class="btn btn-outline-secondary">← Volver</a>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Detalles del Vuelo</h5>
            </div>
            <div class="card-body">
                <h5>{{ $vuelo->Origen }} → {{ $vuelo->Destino }}</h5>
                <p class="mb-1"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($vuelo->Fecha_Salida)->format('d/m/Y') }}</p>
                <p class="mb-1"><strong>Hora:</strong> {{ $vuelo->Hora_Salida }}</p>
                <p class="mb-0"><strong>Duración:</strong> {{ $vuelo->Duracion }}</p>
            </div>
        </div>

        <div class="row">
            @foreach($tiposTiquete as $tipo)
            @php
                $precioFinal = $vuelo->calcularPrecioFinal($tipo->id_tipo_tiquete);
            @endphp
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header text-white 
                        @if($tipo->id_tipo_tiquete == 1) bg-secondary
                        @elseif($tipo->id_tipo_tiquete == 2) bg-primary
                        @elseif($tipo->id_tipo_tiquete == 3) bg-warning
                        @elseif($tipo->id_tipo_tiquete == 4) bg-info
                        @else bg-success @endif">
                        <h5 class="card-title mb-0">{{ $tipo->tipo_tiquete }}</h5>
                    </div>
                    <div class="card-body">
                        <h3 class="text-primary">${{ number_format($precioFinal, 0, ',', '.') }}</h3>
                        <p class="text-muted">
                            <small>Precio base: ${{ number_format($vuelo->Precio, 0, ',', '.') }}</small><br>
                            <small>+{{ $tipo->Porcentaje }}% adicional</small>
                        </p>
                        
                        <h6>Beneficios incluidos:</h6>
                        <ul class="list-unstyled">
                            @foreach(explode(',', $tipo->Beneficios) as $beneficio)
                            <li>{{ trim($beneficio) }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('vuelos.asientos', $vuelo->id_vuelo) }}" method="GET">
                            <input type="hidden" name="tipo_tiquete" value="{{ $tipo->id_tipo_tiquete }}">
                            <button type="submit" class="btn btn-primary w-100">Seleccionar y Elegir Asiento</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>