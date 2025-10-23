<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completar Reserva - AeroSoft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Completar Reserva</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <h5>Resumen de tu selección:</h5>
                            <p class="mb-1"><strong>Vuelo:</strong> {{ $vuelo->Origen }} → {{ $vuelo->Destino }}</p>
                            <p class="mb-1"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($vuelo->Fecha_Salida)->format('d/m/Y') }} a las {{ $vuelo->Hora_Salida }}</p>
                            <p class="mb-1"><strong>Tipo de Tiquete:</strong> {{ $tipoTiquete->tipo_tiquete }}</p>
                            <p class="mb-0"><strong>Precio Total:</strong> ${{ number_format($precioFinal, 0, ',', '.') }}</p>
                        </div>

                        <form action="{{ route('vuelos.guardarReserva') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_vuelo" value="{{ $vuelo->id_vuelo }}">
                            <input type="hidden" name="id_tipo_tiquete" value="{{ $tipoTiquete->id_tipo_tiquete }}">
                            <input type="hidden" name="asiento_id" value="{{ request('asiento_id') }}">

                            <h5 class="mb-3">Datos Personales</h5>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Nombres *</label>
                                    <input type="text" name="Nombres_Cliente" class="form-control" value="{{ old('Nombres_Cliente') }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Primer Apellido *</label>
                                    <input type="text" name="Primer_Apellido_Cliente" class="form-control" value="{{ old('Primer_Apellido_Cliente') }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Segundo Apellido *</label>
                                    <input type="text" name="Segundo_Apellido_Cliente" class="form-control" value="{{ old('Segundo_Apellido_Cliente') }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Fecha de Nacimiento *</label>
                                    <input type="date" name="Fecha_Nacimiento" class="form-control" value="{{ old('Fecha_Nacimiento') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Género *</label>
                                    <select name="id_genero" class="form-control" required>
                                        <option value="">Selecciona tu género</option>
                                        @foreach($generos as $genero)
                                            <option value="{{ $genero->id_genero }}" 
                                                {{ old('id_genero') == $genero->id_genero ? 'selected' : '' }}>
                                                {{ $genero->Genero }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tipo de Documento *</label>
                                    <select name="id_td" class="form-control" required>
                                        <option value="">Selecciona tipo de documento</option>
                                        @foreach($documentos as $documento)
                                            <option value="{{ $documento->id_td }}" 
                                                {{ old('id_td') == $documento->id_td ? 'selected' : '' }}>
                                                {{ $documento->Documento }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Número de Documento *</label>
                                    <input type="text" name="N_Documento" class="form-control" value="{{ old('N_Documento') }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Correo Electrónico *</label>
                                    <input type="email" name="Correo" class="form-control" value="{{ old('Correo') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Celular</label>
                                    <input type="tel" name="Celular" class="form-control"  value="{{ old('Celular') }}" placeholder="Ej: 3001234567">
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    Confirmar Reserva - ${{ number_format($precioFinal, 0, ',', '.') }}
                                </button>
                                <a href="{{ route('vuelos.asientos', $vuelo->id_vuelo) }}?tipo_tiquete={{ $tipoTiquete->id_tipo_tiquete }}" 
                                    class="btn btn-outline-secondary">
                                    ← Volver a selección de asientos
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