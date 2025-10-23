<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vuelo;
use App\Models\Ciudad;
use App\Models\Reserva;
use App\Models\TipoTiquete;
use App\Models\VueloAsiento;
use App\Models\Busqueda;
use App\Models\VueloRegreso;
use App\Models\generos;
use App\Models\documentos;
use Illuminate\Support\Facades\DB;

class VueloController extends Controller
{
    public function index() {
        $ciudades = Ciudad::all();
        $tiposTiquete = TipoTiquete::all();
        return view('vuelos.index', compact('ciudades', 'tiposTiquete'));
    }

    public function buscar(Request $request) {
        $request->validate([
            'tipo_vuelo' => 'required|in:solo_ida,ida_vuelta',
            'origen' => 'required|string',
            'destino' => 'required|string|different:origen',
            'fecha_ida' => 'required|date|after_or_equal:today',
            'fecha_vuelta' => 'required_if:tipo_vuelo,ida_vuelta|date|after:fecha_ida',
            'num_tiquetes' => 'required|integer|min:1|max:5'
        ]);

        $busqueda = Busqueda::create([
            'tipo_vuelo' => $request->tipo_vuelo,
            'Origen' => $request->origen,
            'Destino' => $request->destino,
            'Fecha_ida' => $request->fecha_ida,
            'Fecha_ida_vuelta' => $request->tipo_vuelo === 'ida_vuelta' ? $request->fecha_vuelta : null,
            'Pasajeros' => $request->num_tiquetes,
            'num_tiquetes' => $request->num_tiquetes
        ]);

        if ($request->tipo_vuelo === 'solo_ida') {
            $vuelos = Vuelo::with(['tipoAvion', 'tipoTiquete'])
                ->where('Origen', $request->origen)
                ->where('Destino', $request->destino)
                ->where('Fecha_Salida', $request->fecha_ida)
                ->where('Estado', 1)
                ->get();

            $vuelosEncontrados = $vuelos->count() > 0;
            return view('vuelos.resultados', compact('vuelos', 'busqueda', 'vuelosEncontrados'));
        } else {
            $vuelosIdaVuelta = VueloRegreso::with([
                'vueloIda.tipoAvion', 
                'vueloIda.tipoTiquete',
                'vueloVuelta.tipoAvion',
                'vueloVuelta.tipoTiquete'
            ])
            ->whereHas('vueloIda', function($query) use ($request) {
                $query->where('Origen', $request->origen)
                    ->where('Destino', $request->destino)
                    ->where('Fecha_Salida', $request->fecha_ida)
                    ->where('Estado', 1);
            })
            ->whereHas('vueloVuelta', function($query) use ($request) {
                $query->where('Origen', $request->destino)
                    ->where('Destino', $request->origen)
                    ->where('Fecha_Salida', $request->fecha_vuelta)
                    ->where('Estado', 1);
            })
            ->get();

            $vuelosEncontrados = $vuelosIdaVuelta->count() > 0;
            return view('vuelos.resultados-ida-vuelta', compact('vuelosIdaVuelta', 'busqueda', 'vuelosEncontrados'));
        }
    }

    public function seleccionarTiquete($id) {
        $vuelo = Vuelo::with(['tipoAvion', 'tipoTiquete'])->findOrFail($id);
        $tiposTiquete = TipoTiquete::all();
        return view('vuelos.seleccionar-tiquete', compact('vuelo', 'tiposTiquete'));
    }

    public function asientos($id, Request $request) {
        $vuelo = Vuelo::with(['tipoAvion', 'tipoTiquete'])->findOrFail($id);
        $tipoTiquete = TipoTiquete::findOrFail($request->tipo_tiquete);
        $precioFinal = $vuelo->calcularPrecioFinal($tipoTiquete->id_tipo_tiquete);
        
        // Obtener todos los asientos
        $asientos = VueloAsiento::with('asiento')
            ->where('id_vuelo', $id)
            ->get();
        
        // Filtrar asientos según el tipo de tiquete
        $asientosFiltrados = $this->filtrarAsientosPorTipo($asientos, $tipoTiquete->id_tipo_tiquete);
        
        return view('vuelos.asientos', compact('vuelo', 'asientos', 'asientosFiltrados', 'tipoTiquete', 'precioFinal'));
    }

    /**
     * Filtra los asientos según el tipo de tiquete
     */
    private function filtrarAsientosPorTipo($asientos, $idTipoTiquete) {
        return $asientos->filter(function($asientoVuelo) use ($idTipoTiquete) {
            $numeroAsiento = $asientoVuelo->asiento->Asiento;
            
            // Extraer número de fila del asiento (ej: "12A" -> fila 12)
            preg_match('/(\d+)/', $numeroAsiento, $matches);
            if (count($matches) === 2) {
                $fila = (int)$matches[1];
                
                // Definir zonas según tipo de tiquete
                switch($idTipoTiquete) {
                    case 1: // Básico - Últimas filas (16-30)
                        return $fila >= 16 && $fila <= 30;
                    case 2: // Premium - Filas medias (8-15)
                        return $fila >= 8 && $fila <= 15;
                    case 3: // VIP - Primeras filas (1-7)
                        return $fila >= 1 && $fila <= 7;
                    case 4: // Primera Clase - Mismo que VIP o ajustar según necesidades
                        return $fila >= 1 && $fila <= 7;
                    default:
                        return true;
                }
            }
            return false;
        });
    }

    public function reservar(Request $request, $id) {
        $vuelo = Vuelo::findOrFail($id);
        $tipoTiquete = TipoTiquete::findOrFail($request->tipo_tiquete);
        
        // Verificar disponibilidad y que el asiento corresponda al tipo de tiquete
        $asientoValido = VueloAsiento::with('asiento')
            ->where('id_vuelo', $id)
            ->where('id_asiento', $request->asiento_id)
            ->where('Disponible', 1)
            ->first();
            
        if (!$asientoValido) {
            return redirect()->back()->with('error', 'El asiento seleccionado ya no está disponible.');
        }
        
        // Verificar que el asiento corresponde al tipo de tiquete
        $numeroAsiento = $asientoValido->asiento->Asiento;
        preg_match('/(\d+)/', $numeroAsiento, $matches);
        if (count($matches) === 2) {
            $fila = (int)$matches[1];
            $asientoPermitido = $this->validarZonaAsiento($fila, $tipoTiquete->id_tipo_tiquete);
            
            if (!$asientoPermitido) {
                return redirect()->back()->with('error', 'Este asiento no está disponible para tu tipo de tiquete.');
            }
        }
        
        $precioFinal = $vuelo->calcularPrecioFinal($tipoTiquete->id_tipo_tiquete);
        $generos = generos::all();
        $documentos = documentos::all();
        
        return view('vuelos.reservar', compact(
            'vuelo', 
            'tipoTiquete', 
            'precioFinal', 
            'generos', 
            'documentos'
        ));
    }

    /**
     * Valida que la fila del asiento corresponda al tipo de tiquete
     */
    private function validarZonaAsiento($fila, $idTipoTiquete) {
        switch($idTipoTiquete) {
            case 1: // Básico - Últimas filas
                return $fila >= 16 && $fila <= 30;
            case 2: // Premium - Filas medias
                return $fila >= 8 && $fila <= 15;
            case 3: // VIP - Primeras filas
            case 4: // Primera Clase
                return $fila >= 1 && $fila <= 7;
            default:
                return false;
        }
    }

    public function guardarReserva(Request $request) {
        $request->validate([
            'id_vuelo' => 'required|integer|exists:vuelos,id_vuelo',
            'id_tipo_tiquete' => 'required|integer|exists:tipo_tiquete,id_tipo_tiquete',
            'asiento_id' => 'required|integer|exists:asientos,id_asiento',
            'Nombres_Cliente' => 'required|string|max:50',
            'Primer_Apellido_Cliente' => 'required|string|max:50',
            'Segundo_Apellido_Cliente' => 'required|string|max:50',
            'Fecha_Nacimiento' => 'required|date',
            'id_genero' => 'required|integer|exists:generos,id_genero',
            'id_td' => 'required|integer|exists:documentos,id_td',
            'N_Documento' => 'required|string|max:20',
            'Correo' => 'required|email',
            'Celular' => 'nullable|string|max:15',
        ]);

        DB::transaction(function() use ($request) {
            $vuelo = Vuelo::find($request->id_vuelo);
            $precioFinal = $vuelo->calcularPrecioFinal($request->id_tipo_tiquete);

            $reserva = Reserva::create([
                'id_vuelo' => $request->id_vuelo,
                'id_asiento' => $request->asiento_id,
                'id_tipo_tiquete' => $request->id_tipo_tiquete,
                'Precio_Final' => $precioFinal,
                'Nombres_Cliente' => $request->Nombres_Cliente,
                'Primer_Apellido_Cliente' => $request->Primer_Apellido_Cliente,
                'Segundo_Apellido_Cliente' => $request->Segundo_Apellido_Cliente,
                'Fecha_Nacimiento' => $request->Fecha_Nacimiento,
                'id_genero' => $request->id_genero,
                'id_td' => $request->id_td,
                'N_Documento' => $request->N_Documento,
                'Celular' => $request->Celular,
                'Correo' => $request->Correo,
                'Acompañante' => 0,
                'es_acompañante' => 0,
                'orden_pasajero' => 1,
            ]);

            VueloAsiento::where('id_vuelo', $request->id_vuelo)
                ->where('id_asiento', $request->asiento_id)
                ->update(['Disponible' => 0]);
        });

        return redirect()->route('vuelos.confirmacion-pago')
            ->with('success', 'Reserva realizada correctamente. Proceda con el pago.');
    }

    public function confirmacionPago() {
        return view('vuelos.confirmacion-pago');
    }

    public function procesarPago(Request $request) {
        return redirect()->route('vuelos.compra-completada')
            ->with('success', '¡Pago procesado exitosamente!');
    }

    public function compraCompletada() {
        return view('vuelos.compra-completada');
    }
}