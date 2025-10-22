<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vuelo;
use App\Models\Ciudad;
use App\Models\Reserva;
use App\Models\TipoTiquete;
use App\Models\VueloAsiento;
use Illuminate\Support\Facades\DB;

class VueloController extends Controller
{
    public function index() {
        $ciudades = Ciudad::all();
        $tipos = TipoTiquete::all();
        return view('vuelos.index', compact('ciudades', 'tipos'));
    }

    public function buscar(Request $request) {
        $request->validate([
            'origen' => 'required|string',
            'destino' => 'required|string|different:origen',
            'fecha' => 'required|date',
        ]);
        $query = Vuelo::with(['tipoAvion', 'tipoTiquete'])
            ->where('Origen', $request->origen)
            ->where('Destino', $request->destino)
            ->where('Fecha_Salida', $request->fecha)
            ->where('Estado', 1);

        if ($request->filled('tipo_tiquete')) {
            $query->where('id_tipo_tiquete', $request->tipo_tiquete);
        }
        $vuelos = $query->get();
        return view('vuelos.resultados', compact('vuelos'));
    }

    public function asientos($id) {
        $vuelo = Vuelo::with(['tipoAvion', 'tipoTiquete'])->findOrFail($id);
        $asientos = VueloAsiento::with('asiento')
            ->where('id_vuelo', $id)->get();
        return view('vuelos.asientos', compact('vuelo', 'asientos'));
    }

    public function reservar(Request $request, $id) {
        $vuelo = Vuelo::findOrFail($id);
        $asientoCodigo = $request->asiento;
        $asiento = \App\Models\Asiento::where('Asiento', $asientoCodigo)->firstOrFail();
        $disponible = DB::table('vuelo_asiento')
            ->where('id_vuelo', $id)
            ->where('id_asiento', $asiento->id_asiento)
            ->value('Disponible');
        if (!$disponible) {
            return redirect()->route('vuelos.asientos', $id)
                ->with('error', '❌ El asiento ya fue ocupado.');
        }
        $generos = \App\Models\generos::all();
        $documentos = \App\Models\documentos::all();
        return view('vuelos.reservar', compact('vuelo', 'asiento', 'generos', 'documentos'));
    }

    
    public function guardarReserva(Request $request) {
        $request->validate([
            'id_vuelo' => 'required|integer',
            'id_asiento' => 'required|integer',
            'Nombres_Cliente' => 'required|string|max:50',
            'Primer_Apellido_Cliente' => 'required|string|max:50',
            'Segundo_Apellido_Cliente' => 'required|string|max:50',
            'Fecha_Nacimiento' => 'required|date',
            'id_genero' => 'required|integer',
            'id_td' => 'required|integer',
            'N_Documento' => 'required|string|max:20',
            'Correo' => 'required|email',
        ]);

        DB::transaction(function() use ($request) {
            Reserva::create([
                'id_vuelo' => $request->id_vuelo,
                'id_asiento' => $request->id_asiento,
                'Precio_Final' => 0, // Aquí podrías calcular el precio según tipo de tiquete
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
            ]);
            DB::table('vuelo_asiento')
                ->where('id_vuelo', $request->id_vuelo)
                ->where('id_asiento', $request->id_asiento)
                ->update(['Disponible' => 0]);
        });
        return redirect()->route('vuelos.index')
            ->with('success', '✅ Reserva realizada correctamente.');
    }

}
