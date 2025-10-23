<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Completada - AeroSoft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .success-animation {
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-30px);}
            60% {transform: translateY(-15px);}
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card shadow">
                    <div class="card-body py-5">
                        <div class="success-animation mb-4">
                            <span style="font-size: 80px;">🎉</span>
                        </div>
                        
                        <h2 class="text-success mb-3">¡Compra Completada Exitosamente!</h2>
                        
                        <div class="alert alert-success mb-4">
                            <h5>Tu pago ha sido procesado correctamente</h5>
                            <p class="mb-0">Hemos enviado los detalles de tu vuelo a tu correo electrónico.</p>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">📧 Detalles del Envío</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-2">Los tiquetes electrónicos y la información de tu vuelo han sido enviados a tu correo registrado.</p>
                                <p class="mb-0"><strong>Recomendación:</strong> Revisa tu bandeja de entrada y carpeta de spam.</p>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('vuelos.index') }}" class="btn btn-primary btn-lg">
                                Volver al Inicio
                            </a>
                            <a href="#" class="btn btn-outline-success">
                                Descargar Comprobante
                            </a>
                        </div>

                        <div class="mt-4 text-muted">
                            <small>Si tienes alguna pregunta, contacta a nuestro servicio al cliente.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>