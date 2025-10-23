<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h3 class="text-center">🪪 Reserva tu asiento</h3>
        <p class="text-center">
            Vuelo: {{ $vuelo->Origen }} → {{ $vuelo->Destino }} |
            Asiento: <strong>{{ $asiento->Asiento }}</strong>
        </p>

        <form action="{{ route('vuelos.guardarReserva') }}" method="POST" class="card p-4">
            @csrf
            <input type="hidden" name="id_vuelo" value="{{ $vuelo->id_vuelo }}">
            <input type="hidden" name="id_asiento" value="{{ $asiento->id_asiento }}">

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Nombres:</label>
                    <input type="text" name="Nombres_Cliente" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Primer Apellido:</label>
                    <input type="text" name="Primer_Apellido_Cliente" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Segundo Apellido:</label>
                    <input type="text" name="Segundo_Apellido_Cliente" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Fecha de Nacimiento:</label>
                <input type="date" name="Fecha_Nacimiento" class="form-control" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Género:</label>
                    <select name="id_genero" class="form-control" required>
                        <option value="">Selecciona</option>
                        @foreach ($generos as $g)
                            <option value="{{ $g->id_genero }}">{{ $g->Genero }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Tipo de Documento:</label>
                    <select name="id_td" class="form-control" required>
                        <option value="">Selecciona</option>
                        @foreach ($documentos as $d)
                            <option value="{{ $d->id_td }}">{{ $d->Documento }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Número de Documento:</label>
                    <input type="text" name="N_Documento" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Correo:</label>
                    <input type="email" name="Correo" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Celular:</label>
                <input type="text" name="Celular" class="form-control">
            </div>

            <button type="submit" class="btn btn-success w-100">Confirmar Reserva</button>
        </form>
    </div>
</body>
</html>