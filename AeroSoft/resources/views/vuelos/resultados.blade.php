<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda - AeroSoft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Resultados de Búsqueda</h2>
            <a href="{{ route('vuelos.index') }}" class="btn btn-outline-primary">Nueva Búsqueda</a>
        </div>

        @if(isset($vuelosEncontrados) && $vuelosEncontrados)
            @if(isset($vuelos) && $vuelos->count() > 0)
                @foreach($vuelos as $vuelo)
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="card-title">
                                    {{ $vuelo->Origen }} → {{ $vuelo->Destino }}
                                    <span class="badge bg-success">{{ $vuelo->tipoTiquete->tipo_tiquete }}</span>
                                </h5>
                                <p class="card-text">
                                    <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($vuelo->Fecha_Salida)->format('d/m/Y') }}<br>
                                    <strong>Hora:</strong> {{ $vuelo->Hora_Salida }}<br>
                                    <strong>Duración:</strong> {{ $vuelo->Duracion }}<br>
                                    <strong>Avión:</strong> {{ $vuelo->N_Avion }} ({{ $vuelo->tipoAvion->Tipo_Avion }})
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <h4 class="text-primary">${{ number_format($vuelo->Precio, 0, ',', '.') }}</h4>
                                <p class="text-muted">Precio base</p>
                                <a href="{{ route('vuelos.seleccionar-tiquete', $vuelo->id_vuelo) }}" 
                                    class="btn btn-primary btn-lg">Seleccionar Vuelo</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @elseif(isset($vuelosIdaVuelta) && $vuelosIdaVuelta->count() > 0)
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
                                        {{ \Carbon\Carbon::parse($combo->vueloIda->Fecha_Salida)->format('d/m/Y') }} 
                                        {{ $combo->vueloIda->Hora_Salida }}<br>
                                        {{ $combo->vueloIda->N_Avion }} • {{ $combo->vueloIda->tipoTiquete->tipo_tiquete }}
                                    </small>
                                </div>

                                <div class="p-3 bg-light rounded">
                                    <h6>Vuelta: {{ $combo->vueloVuelta->Origen }} → {{ $combo->vueloVuelta->Destino }}</h6>
                                    <small>
                                        {{ \Carbon\Carbon::parse($combo->vueloVuelta->Fecha_Salida)->format('d/m/Y') }} 
                                        {{ $combo->vueloVuelta->Hora_Salida }}<br>
                                        {{ $combo->vueloVuelta->N_Avion }} • {{ $combo->vueloVuelta->tipoTiquete->tipo_tiquete }}
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <h4 class="text-primary">${{ number_format($combo->precio_total, 0, ',', '.') }}</h4>
                                <p class="text-muted">Precio total</p>
                                <a href="{{ route('vuelos.seleccionar-tiquete', $combo->vueloIda->id_vuelo) }}" 
                                    class="btn btn-primary btn-lg">Seleccionar Paquete</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        @else
            <div class="alert alert-warning text-center">
                <h4>No se encontraron vuelos disponibles</h4>
                <p>No hay vuelos disponibles con los filtros seleccionados en las fechas especificadas.</p>
                <p class="mb-3">Por favor, intenta con otras fechas o rutas.</p>
                <a href="{{ route('vuelos.index') }}" class="btn btn-primary">Realizar nueva búsqueda</a>
            </div>
        @endif
    </div>
</body>
</html>