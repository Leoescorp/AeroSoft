<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AeroSoft</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tickets.css') }}">
    

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-success" href="#">Aero<span class="text-primary">Soft</span></a>
        <button class="btn btn-outline-light ms-auto px-4">Login</button>
    </div>
</nav>

<section class="hero py-5 text-center">
    <div class="container">
        <h1 class="fw-bold display-5">Aerolínea <span class="text-primary">AeroSoft</span></h1>
        <p class="text-muted mb-4">Compra a gusto y con cautela</p>
        <img src="{{ asset('img/avion_1.png') }}" alt="Avión" class="hero-img img-fluid"> 
    </div>
</section>

---

<section class="filters py-5 bg-light">
    <div class="container">
        <h5 class="text-secondary mb-4 text-center text-md-start">Filtrar por:</h5>

        <form id="flightForm" class="row g-3 justify-content-center">
            <div class="col-12 col-md-2">
                <label class="form-label">Origen</label>
                <select id="origen" class="form-select">
                    <option>Pereira</option>
                    <option>Bogotá</option>
                    <option>Medellín</option>
                </select>
            </div>
            <div class="col-12 col-md-2">
                <label class="form-label">Destino</label>
                <select id="destino" class="form-select">
                    <option>Cartagena</option>
                    <option>Cali</option>
                    <option>Barranquilla</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label">Fecha ida</label>
                <input id="fechaIda" type="date" class="form-control">
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label">Fecha regreso</label>
                <input id="fechaRegreso" type="date" class="form-control">
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label">Cantidad</label>
                <input id="cantidad" type="number" class="form-control" min="1" value="1">
            </div>
            <div class="col-12 col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
            </div>
        </form>
    </div>
</section>

---

<section class="results py-5">
    <div class="container">
        <div id="resultsContainer" class="d-flex flex-column gap-4">
            <p class="text-center text-muted">Usa el formulario de arriba para buscar vuelos.</p>
        </div>
    </div>
</section>

---

<footer class="text-center py-4 bg-dark text-light mt-5">
    <p class="mb-0">© 2025 AeroSoft. Todos los derechos reservados.</p>
    <p>AeroSoft</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById('flightForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Obtener valores de los campos por sus ID
    const origen = document.getElementById('origen').value;
    const destino = document.getElementById('destino').value;
    const ida = document.getElementById('fechaIda').value;
    const regreso = document.getElementById('fechaRegreso').value;
    const cantidad = parseInt(document.getElementById('cantidad').value);
    const resultsContainer = document.getElementById('resultsContainer');

    // Validaciones básicas
    if (origen === destino) {
        alert("El origen y destino no pueden ser iguales.");
        return;
    }
    if (!ida) {
        alert("Por favor selecciona una fecha de ida.");
        return;
    }
    if (regreso && regreso < ida) {
        alert("La fecha de regreso no puede ser anterior a la de ida.");
        return;
    }
    if (cantidad < 1) {
        alert("La cantidad debe ser al menos 1.");
        return;
    }

    // Limpia resultados previos y muestra un indicador de carga
    resultsContainer.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary mb-3" role="status"></div>
            <p>Buscando vuelos disponibles...</p>
        </div>
    `;

    // Simula búsqueda (delay de 2 segundos)
    setTimeout(() => {
        const vuelos = generarVuelos(origen, destino, ida, regreso, cantidad);
        mostrarVuelos(vuelos, resultsContainer);
    }, 2000);
});

// Función que genera vuelos simulados
function generarVuelos(origen, destino, ida, regreso, cantidad) {
    const horarios = [
        { salida: "6:00am", llegada: "7:30am" },
        { salida: "12:00pm", llegada: "1:45pm" },
        { salida: "5:00pm", llegada: "6:40pm" }
    ];
    return horarios.map((h, i) => ({
        id: i + 1,
        origen,
        destino,
        ida,
        regreso,
        salida: h.salida,
        llegada: h.llegada,
        escala: i === 1 ? "con escala en Bogotá" : "vuelo directo",
        // Cálculo de precio basado en la cantidad de personas
        precio: (150 + i * 50) * cantidad 
    }));
}

// Función que pinta los vuelos en pantalla
function mostrarVuelos(vuelos, container) {
    container.innerHTML = ""; // Limpia el contenedor

    if (vuelos.length === 0) {
        container.innerHTML = `
            <div class="text-center py-5">
                <p class="text-muted">No se encontraron vuelos para los criterios seleccionados.</p>
            </div>
        `;
        return;
    }

    vuelos.forEach(vuelo => {
        const card = document.createElement('div');
        // Clase para la tarjeta de resultado de vuelo
        card.className = "card p-4 shadow-sm d-flex flex-column flex-md-row align-items-center justify-content-between gap-3";
        card.innerHTML = `
            <div class="d-flex align-items-center gap-3 flex-wrap flex-md-nowrap">
                <div class="flight-thumb">
                    <img src="{{ asset('img/avion.png') }}" alt="Avión"> 
                </div>
                <div class="text-center text-md-start">
                    <h6 class="fw-bold mb-1">${vuelo.origen} → ${vuelo.destino}</h6>
                    <p class="text-muted small mb-0">${vuelo.ida}</p>
                    <p class="text-muted small mb-0">
                        <strong>${vuelo.salida} – ${vuelo.llegada}</strong> <span>(${vuelo.escala})</span>
                    </p>
                    <p class="fw-bold text-primary mt-2">$${vuelo.precio.toLocaleString()} COP</p> 
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 justify-content-center">
                <button class="btn btn-dark btn-sm">Revisar información</button>
                <button class="btn btn-danger btn-sm reservar-btn" data-vuelo='${JSON.stringify(vuelo)}'>Reservar</button>

            </div>
        `;
        container.appendChild(card);
        // Delegación de evento para los botones de "Reservar"
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('reservar-btn')) {
        const vuelo = JSON.parse(e.target.getAttribute('data-vuelo'));

        // Guarda la info del vuelo en localStorage
        localStorage.setItem('vueloSeleccionado', JSON.stringify(vuelo));

        // Redirige a la página de opciones de tiquetes
        window.location.href = "{{ route('tickets')}}";
    }
});

    });
}
</script>

</body>
</html>
