<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AeroSoft - Buscar Vuelos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
            margin-bottom: 40px;
        }
        .search-card {
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: none;
            border-radius: 15px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold">AeroSoft</h1>
                    <p class="lead">Encuentra los mejores vuelos al mejor precio</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card search-card">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Buscar Vuelos</h2>

                        <form action="{{ route('vuelos.buscar') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tipo de Vuelo:</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_vuelo" id="solo_ida" value="solo_ida" checked>
                                    <label class="form-check-label" for="solo_ida">Solo Ida</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_vuelo" id="ida_vuelta" value="ida_vuelta">
                                    <label class="form-check-label" for="ida_vuelta">Ida y Vuelta</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Origen:</label>
                                    <select name="origen" class="form-control" required>
                                        <option value="">Selecciona ciudad de origen</option>
                                        @foreach ($ciudades as $ciudad)
                                            <option value="{{ $ciudad->nombre }}" {{ old('origen') == $ciudad->nombre ? 'selected' : '' }}>
                                                {{ $ciudad->nombre }} ({{ $ciudad->codigo }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Destino:</label>
                                    <select name="destino" class="form-control" required>
                                        <option value="">Selecciona ciudad de destino</option>
                                        @foreach ($ciudades as $ciudad)
                                            <option value="{{ $ciudad->nombre }}" {{ old('destino') == $ciudad->nombre ? 'selected' : '' }}>
                                                {{ $ciudad->nombre }} ({{ $ciudad->codigo }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Fecha de Ida:</label>
                                    <input type="date" name="fecha_ida" class="form-control" 
                                            min="{{ date('Y-m-d') }}" 
                                            value="{{ old('fecha_ida', date('Y-m-d')) }}" 
                                            required>
                                </div>

                                <div class="col-md-6 mb-3" id="fecha_vuelta_container" style="display: none;">
                                    <label class="form-label fw-bold">Fecha de Vuelta:</label>
                                    <input type="date" name="fecha_vuelta" class="form-control" 
                                            min="{{ date('Y-m-d') }}" 
                                            value="{{ old('fecha_vuelta') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Número de Tiquetes:</label>
                                <select name="num_tiquetes" class="form-control" required>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('num_tiquetes', 1) == $i ? 'selected' : '' }}>
                                            {{ $i }} tiquete{{ $i > 1 ? 's' : '' }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 btn-lg">🔍 Buscar Vuelos</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mostrar/ocultar fecha de vuelta según tipo de vuelo
        document.addEventListener('DOMContentLoaded', function() {
            const tipoVueloRadios = document.querySelectorAll('input[name="tipo_vuelo"]');
            const fechaVueltaContainer = document.getElementById('fecha_vuelta_container');
            const fechaVueltaInput = document.querySelector('input[name="fecha_vuelta"]');

            function toggleFechaVuelta() {
                const tipoVuelo = document.querySelector('input[name="tipo_vuelo"]:checked').value;
                if (tipoVuelo === 'ida_vuelta') {
                    fechaVueltaContainer.style.display = 'block';
                    fechaVueltaInput.required = true;
                } else {
                    fechaVueltaContainer.style.display = 'none';
                    fechaVueltaInput.required = false;
                }
            }

            tipoVueloRadios.forEach(radio => {
                radio.addEventListener('change', toggleFechaVuelta);
            });

            toggleFechaVuelta(); // Ejecutar al cargar la página
        });
    </script>
</body>
</html>