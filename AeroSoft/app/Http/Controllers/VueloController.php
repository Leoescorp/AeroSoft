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
        ], [
            'id_vuelo.required' => 'El campo vuelo es obligatorio.',
            'id_vuelo.integer' => 'El campo vuelo debe ser un número entero.',
            
            'id_asiento.required' => 'El campo asiento es obligatorio.',
            'id_asiento.integer' => 'El campo asiento debe ser un número entero.',
            
            'Nombres_Cliente.required' => 'Los nombres del cliente son obligatorios.',
            'Nombres_Cliente.string' => 'Los nombres deben ser texto.',
            'Nombres_Cliente.max' => 'Los nombres no deben superar los 50 caracteres.',
            
            'Primer_Apellido_Cliente.required' => 'El primer apellido es obligatorio.',
            'Primer_Apellido_Cliente.string' => 'El primer apellido debe ser texto.',
            'Primer_Apellido_Cliente.max' => 'El primer apellido no debe superar los 50 caracteres.',
            
            'Segundo_Apellido_Cliente.required' => 'El segundo apellido es obligatorio.',
            'Segundo_Apellido_Cliente.string' => 'El segundo apellido debe ser texto.',
            'Segundo_Apellido_Cliente.max' => 'El segundo apellido no debe superar los 50 caracteres.',
            
            'Fecha_Nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'Fecha_Nacimiento.date' => 'La fecha de nacimiento debe tener un formato válido.',
            
            'id_genero.required' => 'El género es obligatorio.',
            'id_genero.integer' => 'El género debe ser un número entero.',
            
            'id_td.required' => 'El tipo de documento es obligatorio.',
            'id_td.integer' => 'El tipo de documento debe ser un número entero.',
            
            'N_Documento.required' => 'El número de documento es obligatorio.',
            'N_Documento.string' => 'El número de documento debe ser texto.',
            'N_Documento.max' => 'El número de documento no debe superar los 20 caracteres.',
            
            'Correo.required' => 'El correo electrónico es obligatorio.',
            'Correo.email' => 'El correo electrónico debe tener un formato válido.',
        ]);
        DB::transaction(function() use ($request) {
            Reserva::create([
                'id_vuelo' => $request->id_vuelo,
                'id_asiento' => $request->id_asiento,
                'Precio_Final' => 0,
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
