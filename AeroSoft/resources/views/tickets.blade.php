<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="{{ asset('css/tickets.css') }}">

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AeroSoft - Selección de Tiquetes</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos personalizados -->
  
    <link rel="stylesheet" href="{{ asset('css/tickets.css') }}">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="{{ url('/') }}">Aero<span class="text-primary">Soft</span></a>
            <button class="btn btn-outline-light ms-auto px-4">Cerrar sesión</button>
        </div>
    </nav>

    <!-- Contenido -->
    <section class="tickets py-5">
        <div class="container">
            <h2 class="fw-bold text-center mb-4">Selecciona tu tipo de tiquete</h2>
            
            <!-- Info del vuelo -->
            <div id="vueloInfo" class="card shadow-sm p-4 mb-5 text-center">
                <h5 class="fw-bold mb-2 text-primary">Detalles del Vuelo</h5>
                <p class="mb-0 text-muted">Cargando información...</p>
            </div>

            <!-- Opciones de tiquete -->
            <div class="row g-4 justify-content-center">
                <div class="col-md-3">
                    <div class="card ticket-card border-success shadow-sm text-center">
                        <div class="card-body">
                            <h5 class="card-title text-success">Económico</h5>
                            <p class="text-muted">Ideal para presupuestos bajos</p>
                            <ul class="list-unstyled small text-start">
                                <li>✔ 1 Equipaje de mano</li>
                                <li>❌ Sin selección de asiento</li>
                                <li>❌ Sin cambios</li>
                            </ul>
                            <p class="fw-bold fs-5 mt-3 text-dark">$<span id="precioEconomico">0</span> COP</p>
                            <button class="btn btn-outline-success select-ticket" data-tipo="Económico">Seleccionar</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card ticket-card border-primary shadow-sm text-center">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Premium</h5>
                            <p class="text-muted">Más comodidad y flexibilidad</p>
                            <ul class="list-unstyled small text-start">
                                <li>✔ 1 Equipaje de mano + 1 facturado</li>
                                <li>✔ Selección de asiento</li>
                                <li>❌ Sin cambios</li>
                            </ul>
                            <p class="fw-bold fs-5 mt-3 text-dark">$<span id="precioPremium">0</span> COP</p>
                            <button class="btn btn-outline-primary select-ticket" data-tipo="Premium">Seleccionar</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card ticket-card border-danger shadow-sm text-center">
                        <div class="card-body">
                            <h5 class="card-title text-danger">VIP</h5>
                            <p class="text-muted">Máximo confort y flexibilidad</p>
                            <ul class="list-unstyled small text-start">
                                <li>✔ Todo incluido</li>
                                <li>✔ Cambios gratuitos</li>
                                <li>✔ Asientos preferenciales</li>
                            </ul>
                            <p class="fw-bold fs-5 mt-3 text-dark">$<span id="precioVIP">0</span> COP</p>
                            <button class="btn btn-outline-danger select-ticket" data-tipo="VIP">Seleccionar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botón para continuar -->
            <div class="text-center mt-5">
                <button id="continuarBtn" class="btn btn-success px-5 py-2" disabled>Continuar con la compra</button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-4 bg-dark text-light mt-5">
        <p class="mb-0">© 2025 AeroSoft. Todos los derechos reservados.</p>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const vuelo = JSON.parse(localStorage.getItem('vueloSeleccionado'));
            const vueloInfo = document.getElementById('vueloInfo');
            const continuarBtn = document.getElementById('continuarBtn');

            if (!vuelo) {
                vueloInfo.innerHTML = "<p class='text-danger'>No hay información del vuelo seleccionada.</p>";
                return;
            }

            // Mostrar detalles del vuelo
            vueloInfo.innerHTML = `
                <h5 class="fw-bold mb-2">${vuelo.origen} → ${vuelo.destino}</h5>
                <p class="text-muted mb-1">${vuelo.ida}${vuelo.regreso ? ' - ' + vuelo.regreso : ''}</p>
                <p class="mb-0"><strong>${vuelo.salida}</strong> - <strong>${vuelo.llegada}</strong> (${vuelo.escala})</p>
                <p class="mt-2 fw-bold text-primary">Precio base: $${vuelo.precio.toLocaleString()} COP</p>
            `;

            // Calcular precios según tipo
            const precioBase = vuelo.precio;
            document.getElementById('precioEconomico').textContent = (precioBase).toLocaleString();
            document.getElementById('precioPremium').textContent = (precioBase * 1.3).toLocaleString();
            document.getElementById('precioVIP').textContent = (precioBase * 1.6).toLocaleString();

            // Manejo de selección
            let tipoSeleccionado = null;
            document.querySelectorAll('.select-ticket').forEach(btn => {
                btn.addEventListener('click', () => {
                    tipoSeleccionado = btn.getAttribute('data-tipo');

                    document.querySelectorAll('.select-ticket').forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');

                    continuarBtn.disabled = false;
                    continuarBtn.textContent = `Continuar con tiquete ${tipoSeleccionado}`;
                });
            });

            // Continuar
            continuarBtn.addEventListener('click', () => {
                vuelo.tipo = tipoSeleccionado;
                localStorage.setItem('vueloSeleccionado', JSON.stringify(vuelo));
                alert(`Has seleccionado el tiquete ${tipoSeleccionado}.`);
                // Aquí podrías redirigir a la vista de pago o confirmación:
                // window.location.href = "{{ url('/confirmacion') }}";
            });
        });
    </script>

</body>
</html>
