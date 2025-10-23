<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Asiento - AeroSoft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <style>
        .distribucion-asientos {
            max-width: 800px;
            margin: 0 auto;
        }
        .zona-asientos {
            margin-bottom: 30px;
            padding: 20px;
            border-radius: 15px;
            background-color: #f8f9fa;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
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
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #dee2e6;
        }
        .asientos-container {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 12px;
            margin-bottom: 15px;
        }
        .asiento {
            text-align: center;
            padding: 15px;
            border: 2px solid #dee2e6;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: bold;
            background-color: white;
        }
        .asiento.disponible {
            background-color: #d4edda;
            border-color: #28a745;
            color: #155724;
        }
        .asiento.disponible:hover {
            background-color: #c3e6cb;
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
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
            gap: 20px;
            margin: 30px 0;
        }
        .item-leyenda {
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .leyenda-vip {
            border-left: 4px solid #dc3545;
        }
        .leyenda-premium {
            border-left: 4px solid #fd7e14;
        }
        .leyenda-basico {
            border-left: 4px solid #20c997;
        }
        .badge-zona {
            font-size: 0.8rem;
            padding: 0.5rem 1rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="{{ route('vuelos.index') }}">Aero<span class="text-primary">Soft</span></a>
            <button class="btn btn-outline-light ms-auto px-4">Cerrar sesión</button>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">💺 Seleccionar Asiento - {{ $tipoTiquete->tipo_tiquete }}</h2>
            <a href="{{ route('vuelos.seleccionar-tiquete', $vuelo->id_vuelo) }}" class="btn btn-outline-secondary">← Cambiar Tipo de Tiquete</a>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card mb-4 shadow-sm">
            <div class="card-body text-center">
                <h5 class="text-primary">{{ $vuelo->Origen }} → {{ $vuelo->Destino }}</h5>
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
            <!-- Zona VIP -->
            <div class="zona-asientos zona-vip">
                <div class="header-zona">
                    <h5 class="mb-0">Zona VIP - Adelante</h5>
                    <span class="badge bg-danger badge-zona">Filas 1-7</span>
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

            <!-- Zona Premium -->
            <div class="zona-asientos zona-premium">
                <div class="header-zona">
                    <h5 class="mb-0">Zona Premium - Medio</h5>
                    <span class="badge bg-warning badge-zona">Filas 8-15</span>
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

            <!-- Zona Básico -->
            <div class="zona-asientos zona-basico">
                <div class="header-zona">
                    <h5 class="mb-0">Zona Básico - Atrás</h5>
                    <span class="badge bg-success badge-zona">Filas 16-30</span>
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

    <!-- Footer -->
    <footer class="text-center py-4 bg-dark text-light mt-5">
        <p class="mb-0">© 2025 AeroSoft. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>