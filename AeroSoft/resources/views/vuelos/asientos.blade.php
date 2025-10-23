<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container text-center">
        <h2>Selecciona tu asiento ✈️</h2>
        <p>{{ $vuelo->Origen }} → {{ $vuelo->Destino }} | {{ $vuelo->Fecha_Salida }} - {{ $vuelo->Hora_Salida }}</p>

        {{-- Mensaje de error si el asiento ya fue ocupado --}}
        @if (session('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
        @endif

        <div class="asientos-container">
            @foreach ($asientos as $a)
                @php
                    $clickable = $a->Disponible ? true : false;
                @endphp

                <div class="asiento">
                    @if ($clickable)
                        <a href="{{ route('vuelos.reservar', ['id' => $vuelo->id_vuelo, 'asiento' => $a->asiento->Asiento]) }}">
                            {{ $a->asiento->Asiento }}
                        </a>
                    @else
                        <span class="ocupado">
                            {{ $a->asiento->Asiento }}
                        </span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>