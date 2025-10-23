<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Asiento - AeroSoft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .distribucion-asientos {
            max-width: 600px;
            margin: 0 auto;
        }
        .zona-asientos {
            margin-bottom: 30px;
            padding: 15px;
            border-radius: 10px;
            background-color: #f8f9fa;
        }
        .zona-vip {
            border-left: 4px solid #dc3545;
            background-color: #fff5f5;
        }
        .zona-premium {
            border-left: 4px solid #fd7e14;
            background-color: #fff9f0;
        }
        .zona-basico {
            border-left: 4px solid #20c997;
            background-color: #f0fff4;
        }
        .header-zona {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #dee2e6;
        }
        .asientos-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 10px;
        }
        .asiento {
            text-align: center;
            padding: 12px;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: bold;
        }
        .asiento.disponible {
            background-color: #d4edda;
            border-color: #28a745;
            color: #155724;
        }
        .asiento.disponible:hover {
            background-color: #c3e6cb;
            transform: scale(1.05);
        }
        .asiento.ocupado {
            background-color: #f8d7da;
            border-color: #dc3545;
            color: #721c24;
            cursor: not-allowed;
        }
        .asiento.no-permitido {
            background-color: #e9ecef;
            border-color: #6c757d;
            color: #6c757d;
            cursor: not-allowed;
            opacity: 0.6;
        }
        .asiento a {
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .leyenda-zonas {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin: 20px 0;
        }
        .item-leyenda {
            padding: 10px;
            border-radius: 8px;
            text-align: center;
        }
        .leyenda-vip {
            background-color: #fff5f5;
            border-left: 4px solid #dc3545;
        }
        .leyenda-premium {
            background-color: #fff9f0;
            border-left: 4px solid #fd7e14;
        }
        .leyenda-basico {
            background-color: #f0fff4;
            border-left: 4px solid #20c997;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>💺 Seleccionar Asiento - {{ $tipoTiquete->tipo_tiquete }}</h2>
            <a href="{{ route('vuelos.seleccionar-tiquete', $vuelo->id_vuelo) }}" class="btn btn-outline-secondary">← Cambiar Tipo de Tiquete</a>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <h5>{{ $vuelo->Origen }} → {{ $vuelo->Destino }}</h5>
                <p class="mb-1"><strong>Tipo de Tiquete:</strong> {{ $tipoTiquete->tipo_tiquete }}</p>
                <p class="mb-1"><strong>Precio Final:</strong> ${{ number_format($precioFinal, 0, ',', '.') }}</p>
                <p class="mb-0"><strong>Zona Permitida:</strong> 
                    @if($tipoTiquete->id_tipo_tiquete == 1)
                        Atrás (Filas 16-30)
                    @elseif($tipoTiquete->id_tipo_tiquete == 2)
                        Medio (Filas 8-15)
                    @else
                        Adelante (Filas 1-7)
                    @endif
                </p>
            </div>
        </div>

        <div class="distribucion-asientos">
            <div class="zona-asientos zona-vip">
                <div class="header-zona">
                    <h5 class="mb-0">Zona VIP - Adelante</h5>
                    <span class="badge bg-danger">Filas 1-7</span>
                </div>
                <div class="asientos-container">
                    @foreach($asientos as $asientoVuelo)
                        @php
                            $numeroAsiento = $asientoVuelo->asiento->Asiento;
                            preg_match('/(\d+)/', $numeroAsiento, $matches);
                            $fila = count($matches) === 2 ? (int)$matches[1] : 0;
                            $enZonaPermitida = $fila >= 1 && $fila <= 7;
                            $esSeleccionable = $enZonaPermitida && $asientoVuelo->Disponible;
                        @endphp
                        @if($fila >= 1 && $fila <= 7)
                            <div class="asiento {{ $esSeleccionable ? 'disponible' : ($asientoVuelo->Disponible ? 'no-permitido' : 'ocupado') }}">
                                @if($esSeleccionable)
                                    <a href="{{ route('vuelos.reservar', [
                                        'id' => $vuelo->id_vuelo,
                                        'tipo_tiquete' => $tipoTiquete->id_tipo_tiquete,
                                        'asiento_id' => $asientoVuelo->id_asiento
                                    ]) }}" title="Asiento {{ $asientoVuelo->asiento->Asiento }}">
                                        {{ $asientoVuelo->asiento->Asiento }}
                                    </a>
                                @elseif(!$asientoVuelo->Disponible)
                                    <span title="Asiento ocupado">
                                        {{ $asientoVuelo->asiento->Asiento }}
                                    </span>
                                @else
                                    <span title="No disponible para {{ $tipoTiquete->tipo_tiquete }}">
                                        {{ $asientoVuelo->asiento->Asiento }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="zona-asientos zona-premium">
                <div class="header-zona">
                    <h5 class="mb-0">Zona Premium - Medio</h5>
                    <span class="badge bg-warning">Filas 8-15</span>
                </div>
                <div class="asientos-container">
                    @foreach($asientos as $asientoVuelo)
                        @php
                            $numeroAsiento = $asientoVuelo->asiento->Asiento;
                            preg_match('/(\d+)/', $numeroAsiento, $matches);
                            $fila = count($matches) === 2 ? (int)$matches[1] : 0;
                            $enZonaPermitida = $fila >= 8 && $fila <= 15;
                            $esSeleccionable = $enZonaPermitida && $asientoVuelo->Disponible;
                        @endphp
                        @if($fila >= 8 && $fila <= 15)
                            <div class="asiento {{ $esSeleccionable ? 'disponible' : ($asientoVuelo->Disponible ? 'no-permitido' : 'ocupado') }}">
                                @if($esSeleccionable)
                                    <a href="{{ route('vuelos.reservar', [
                                        'id' => $vuelo->id_vuelo,
                                        'tipo_tiquete' => $tipoTiquete->id_tipo_tiquete,
                                        'asiento_id' => $asientoVuelo->id_asiento
                                    ]) }}" title="Asiento {{ $asientoVuelo->asiento->Asiento }}">
                                        {{ $asientoVuelo->asiento->Asiento }}
                                    </a>
                                @elseif(!$asientoVuelo->Disponible)
                                    <span title="Asiento ocupado">
                                        {{ $asientoVuelo->asiento->Asiento }}
                                    </span>
                                @else
                                    <span title="No disponible para {{ $tipoTiquete->tipo_tiquete }}">
                                        {{ $asientoVuelo->asiento->Asiento }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Zona Básico (Filas 16-30) -->
            <div class="zona-asientos zona-basico">
                <div class="header-zona">
                    <h5 class="mb-0">Zona Básico - Atrás</h5>
                    <span class="badge bg-success">Filas 16-30</span>
                </div>
                <div class="asientos-container">
                    @foreach($asientos as $asientoVuelo)
                        @php
                            $numeroAsiento = $asientoVuelo->asiento->Asiento;
                            preg_match('/(\d+)/', $numeroAsiento, $matches);
                            $fila = count($matches) === 2 ? (int)$matches[1] : 0;
                            $enZonaPermitida = $fila >= 16 && $fila <= 30;
                            $esSeleccionable = $enZonaPermitida && $asientoVuelo->Disponible;
                        @endphp
                        @if($fila >= 16 && $fila <= 30)
                            <div class="asiento {{ $esSeleccionable ? 'disponible' : ($asientoVuelo->Disponible ? 'no-permitido' : 'ocupado') }}">
                                @if($esSeleccionable)
                                    <a href="{{ route('vuelos.reservar', [
                                        'id' => $vuelo->id_vuelo,
                                        'tipo_tiquete' => $tipoTiquete->id_tipo_tiquete,
                                        'asiento_id' => $asientoVuelo->id_asiento
                                    ]) }}" title="Asiento {{ $asientoVuelo->asiento->Asiento }}">
                                        {{ $asientoVuelo->asiento->Asiento }}
                                    </a>
                                @elseif(!$asientoVuelo->Disponible)
                                    <span title="Asiento ocupado">
                                        {{ $asientoVuelo->asiento->Asiento }}
                                    </span>
                                @else
                                    <span title="No disponible para {{ $tipoTiquete->tipo_tiquete }}">
                                        {{ $asientoVuelo->asiento->Asiento }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <div class="leyenda-zonas">
            <div class="item-leyenda leyenda-vip">
                <h6>Zona VIP</h6>
                <small>Filas 1-7</small>
                <br>
                <small><strong>Tiquetes: VIP y Primera Clase</strong></small>
            </div>
            <div class="item-leyenda leyenda-premium">
                <h6>Zona Premium</h6>
                <small>Filas 8-15</small>
                <br>
                <small><strong>Tiquetes: Premium</strong></small>
            </div>
            <div class="item-leyenda leyenda-basico">
                <h6>Zona Básico</h6>
                <small>Filas 16-30</small>
                <br>
                <small><strong>Tiquetes: Básico</strong></small>
            </div>
        </div>

        <div class="text-center mt-4">
            <div class="d-inline-block me-4">
                <div class="d-inline-block asiento disponible me-2"></div>
                <span>Disponible</span>
            </div>
            <div class="d-inline-block me-4">
                <div class="d-inline-block asiento ocupado me-2"></div>
                <span>Ocupado</span>
            </div>
            <div class="d-inline-block">
                <div class="d-inline-block asiento no-permitido me-2"></div>
                <span>No permitido</span>
            </div>
        </div>
    </div>
</body>
</html>