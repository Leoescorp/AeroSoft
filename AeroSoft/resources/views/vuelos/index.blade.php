<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AeroSoft - Buscar Vuelos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="#">Aero<span class="text-primary">Soft</span></a>
            <button class="btn btn-outline-light ms-auto px-4">Login</button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero py-5 text-center">
        <div class="container">
            <h1 class="fw-bold display-5">Aerolínea <span class="text-primary">AeroSoft</span></h1>
            <p class="text-muted mb-4">Encuentra los mejores vuelos al mejor precio</p>
            <img src="{{ asset('img/avion.png') }}" alt="Avión" class="hero-img img-fluid"> 
        </div>
    </section>

    <!-- Search Section -->
    <section class="filters py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card search-card shadow-sm border-0">
                        <div class="card-body p-5">
                            <h2 class="text-center mb-4 fw-bold">Buscar Vuelos</h2>

                            <form action="{{ route('vuelos.buscar') }}" method="POST">
                                @csrf
                                
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Tipo de Vuelo:</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="tipo_vuelo" id="solo_ida" value="solo_ida" checked>
                                        <label class="form-check-label fw-medium" for="solo_ida">Solo Ida</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="tipo_vuelo" id="ida_vuelta" value="ida_vuelta">
                                        <label class="form-check-label fw-medium" for="ida_vuelta">Ida y Vuelta</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Origen:</label>
                                        <select name="origen" class="form-select" required>
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
                                        <select name="destino" class="form-select" required>
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

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Número de Tiquetes:</label>
                                    <select name="num_tiquetes" class="form-select" required>
                                        @for($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" {{ old('num_tiquetes', 1) == $i ? 'selected' : '' }}>
                                                {{ $i }} tiquete{{ $i > 1 ? 's' : '' }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 btn-lg py-3 fw-bold">🔍 Buscar Vuelos</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-4 bg-dark text-light mt-5">
        <p class="mb-0">© 2025 AeroSoft. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
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

            toggleFechaVuelta();
        });
    </script>
</body>
</html>