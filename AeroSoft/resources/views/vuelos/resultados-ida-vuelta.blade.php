<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados Ida y Vuelta - AeroSoft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>✈️ Resultados - Vuelos Ida y Vuelta</h2>
            <a href="{{ route('vuelos.index') }}" class="btn btn-outline-primary">← Nueva Búsqueda</a>
        </div>

        @if($vuelosIdaVuelta->count() > 0)
            @foreach($vuelosIdaVuelta as $combo)
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title">
                                {{ $combo->vueloIda->Origen }} ↔ {{ $combo->vueloIda->Destino }}
                                <span class="badge bg-info">Ida y Vuelta</span>
                            </h5>
                            
                            <div class="mb-3 p-3 bg-light rounded">
                                <h6>Ida: {{ $combo->vueloIda->Origen }} → {{ $combo->vueloIda->Destino }}</h6>
                                <small>
                                    <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($combo->vueloIda->Fecha_Salida)->format('d/m/Y') }}<br>
                                    <strong>Hora:</strong> {{ $combo->vueloIda->Hora_Salida }}<br>
                                    <strong>Duración:</strong> {{ $combo->vueloIda->Duracion }}<br>
                                    <strong>Avión:</strong> {{ $combo->vueloIda->N_Avion }} ({{ $combo->vueloIda->tipoAvion->Tipo_Avion }})<br>
                                    <strong>Clase:</strong> {{ $combo->vueloIda->tipoTiquete->tipo_tiquete }}
                                </small>
                            </div>

                            <div class="p-3 bg-light rounded">
                                <h6>Vuelta: {{ $combo->vueloVuelta->Origen }} → {{ $combo->vueloVuelta->Destino }}</h6>
                                <small>
                                    <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($combo->vueloVuelta->Fecha_Salida)->format('d/m/Y') }}<br>
                                    <strong>Hora:</strong> {{ $combo->vueloVuelta->Hora_Salida }}<br>
                                    <strong>Duración:</strong> {{ $combo->vueloVuelta->Duracion }}<br>
                                    <strong>Avión:</strong> {{ $combo->vueloVuelta->N_Avion }} ({{ $combo->vueloVuelta->tipoAvion->Tipo_Avion }})<br>
                                    <strong>Clase:</strong> {{ $combo->vueloVuelta->tipoTiquete->tipo_tiquete }}
                                </small>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <h4 class="text-primary">${{ number_format($combo->precio_total, 0, ',', '.') }}</h4>
                            <p class="text-muted">Precio total del paquete</p>
                            <p class="small text-muted">
                                Incluye: <br>
                                • Vuelo de ida: ${{ number_format($combo->vueloIda->Precio, 0, ',', '.') }}<br>
                                • Vuelo de vuelta: ${{ number_format($combo->vueloVuelta->Precio, 0, ',', '.') }}
                            </p>
                            <a href="{{ route('vuelos.seleccionar-tiquete', $combo->vueloIda->id_vuelo) }}" 
                            class="btn btn-primary btn-lg w-100 mb-2">Seleccionar Paquete</a>
                            <small class="text-muted">* Seleccionarás asientos para ambos vuelos</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="alert alert-warning text-center">
                <h4>No se encontraron vuelos de ida y vuelta</h4>
                <p>No hay paquetes disponibles con las fechas seleccionadas.</p>
                <a href="{{ route('vuelos.index') }}" class="btn btn-primary">Realizar nueva búsqueda</a>
            </div>
        @endif

        <div class="alert alert-info">
            <h6>Información importante:</h6>
            <ul class="mb-0">
                <li>Al seleccionar un paquete de ida y vuelta, podrás elegir asientos para ambos vuelos</li>
                <li>El precio mostrado es el total del paquete completo</li>
                <li>Podrás seleccionar diferentes tipos de tiquete para cada vuelo si lo deseas</li>
            </ul>
        </div>
    </div>
</body>
</html>