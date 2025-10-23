<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Pago - AeroSoft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-success text-white text-center">
                        <h3 class="mb-0">Reserva Confirmada</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="alert alert-success">
                            <h5>¡Reserva realizada exitosamente!</h5>
                            <p class="mb-0">Ahora procede con el pago para completar tu compra.</p>
                        </div>

                        <div class="mb-4">
                            <h5>Métodos de Pago</h5>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="tarjeta" value="tarjeta" checked>
                                <label class="form-check-label" for="tarjeta">
                                    Tarjeta de Crédito/Débito
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="pse" value="pse">
                                <label class="form-check-label" for="pse">
                                    PSE
                                </label>
                            </div>
                        </div>

                        <form action="{{ route('vuelos.procesarPago') }}" method="POST">
                            @csrf
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Proceder con el Pago
                                </button>
                                <a href="{{ route('vuelos.index') }}" class="btn btn-outline-secondary">
                                    ← Volver al Inicio
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>