<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\administradores;
use App\Models\generos;
use App\Models\documentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function Index() {
        return view('Practica.Admin.Index');
    }

    public function ListaEditor(Request $Datos) {
        $Buscar = $Datos->input('Buscar');
        $genero = $Datos->input('genero');
        $user = administradores::with(['Genero', 'ROL'])
            ->where('id_rol', 2)
            ->when($genero, function ($query) use ($genero) {
                $query->where('id_genero', $genero);
            })
            ->when($Buscar, function ($query) use ($Buscar) {
                $query->where(function ($sub) use ($Buscar) {
                    $sub->where('Nombres', 'like', "%$Buscar%")
                        ->orWhere('Primer_Apellido', 'like', "%$Buscar%")
                        ->orWhere('N_Documento', 'like', "%$Buscar%");
                });
            })
            ->orderBy('id_administrador', 'desc')
            ->get();
        $generos = generos::all();
        return view('Practica.Admin.Lista', compact('user', 'generos', 'genero', 'Buscar'));
    }

    public function Registrar() {
        $generos = generos::all();
        $documentos = documentos::all();
        return view('Practica.Admin.Registrar', compact('generos', 'documentos'));
    }

    public function Registro(Request $Datos) {
        $Datos->validate([
            'Nombres' => 'required|string|min:1|max:50',
            'Primer_Apellido' => 'required|string|min:1|max:50',
            'Segundo_Apellido' => 'required|string|min:1|max:50',
            'Fecha_Nacimiento' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'id_genero' => 'required|exists:generos,id_genero',
            'id_td' => 'required|exists:documentos,id_td',
            'N_Documento' => 'required|min:8|max:10|unique:administradores,N_Documento',
            'Celular' => 'required|digits:10|unique:administradores,Celular',
            'Correo' => 'required|email|unique:administradores,Correo',
            'Password' => [
                'required',
                'confirmed',
                'regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{8,16}$/'
            ]
        ], [
            'Nombres.required' => 'El campo nombres es obligatorio.',
            'Primer_Apellido.required' => 'El primer apellido es obligatorio.',
            'Segundo_Apellido.required' => 'El segundo apellido es obligatorio.',
            'Fecha_Nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'Fecha_Nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'Fecha_Nacimiento.before_or_equal' => 'Debes tener al menos 18 años.',
            'id_genero.required' => 'El género es obligatorio.',
            'id_genero.exists' => 'El género seleccionado no es válido.',
            'id_td.required' => 'El tipo de documento es obligatorio.',
            'id_td.exists' => 'El tipo de documento seleccionado no es válido.',
            'N_Documento.required' => 'El número de documento es obligatorio.',
            'N_Documento.min' => 'El documento debe tener al menos 8 caracteres.',
            'N_Documento.max' => 'El documento no debe exceder los 10 caracteres.',
            'N_Documento.unique' => 'Este número de documento ya está registrado.',
            'Celular.required' => 'El número de celular es obligatorio.',
            'Celular.digits' => 'El celular debe tener exactamente 10 dígitos.',
            'Celular.unique' => 'Este número de celular ya está registrado.',
            'Correo.required' => 'El correo electrónico es obligatorio.',
            'Correo.email' => 'El correo debe tener un formato válido.',
            'Correo.unique' => 'Este correo ya está registrado.',
            'Password.required' => 'La contraseña es obligatoria.',
            'Password.confirmed' => 'Las contraseñas no coinciden.',
            'Password.regex' => 'La contraseña debe tener entre 8 y 16 caracteres, incluir una mayúscula, una minúscula, un número y un carácter especial.'
        ]);
        administradores::create([
            'Nombres' => $Datos->Nombres,
            'Primer_Apellido' => $Datos->Primer_Apellido,
            'Segundo_Apellido' => $Datos->Segundo_Apellido,
            'Fecha_Nacimiento' => $Datos->Fecha_Nacimiento,
            'id_genero' => $Datos->id_genero,
            'id_td' => $Datos->id_td,
            'N_Documento' => $Datos->N_Documento,
            'id_rol' => 2,
            'Celular' => $Datos->Celular,
            'Correo' => $Datos->Correo,
            'Password' => Hash::make($Datos->Password),
            'Activida' => 1
        ]);
        return redirect()->route('admin.lista')->with('Mensaje', 'Editor registrado correctamente.');
    }

    public function Editar($id) {
        $id = Crypt::decrypt($id);
        $editor = administradores::findOrFail($id);
        $generos = generos::all();
        $documentos = documentos::all();
        return view('Practica.Admin.Editar', compact('editor', 'generos', 'documentos'));
    }

    public function Actualizar(Request $Datos) {
        $id = Crypt::decrypt($Datos->id);
        $Datos->validate([
            'Nombres' => 'required|string|min:1|max:50',
            'Primer_Apellido' => 'required|string|min:1|max:50',
            'Segundo_Apellido' => 'required|string|min:1|max:50',
            'Fecha_Nacimiento' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'id_genero' => 'required|exists:generos,id_genero',
            'id_td' => 'required|exists:documentos,id_td',
            'N_Documento' => 'required|min:8|max:10|unique:administradores,N_Documento,' . $id . ',id_administrador',
            'Celular' => 'required|digits:10|unique:administradores,Celular,' . $id . ',id_administrador',
            'Correo' => 'required|email|unique:administradores,Correo,' . $id . ',id_administrador',
            'Password' => [
                'nullable',
                'confirmed',
                'regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{8,16}$/'
            ]
        ], [
            'Nombres.required' => 'El campo nombres es obligatorio.',
            'Primer_Apellido.required' => 'El primer apellido es obligatorio.',
            'Segundo_Apellido.required' => 'El segundo apellido es obligatorio.',
            'Fecha_Nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'Fecha_Nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'Fecha_Nacimiento.before_or_equal' => 'Debes tener al menos 18 años.',
            'id_genero.required' => 'El género es obligatorio.',
            'id_genero.exists' => 'El género seleccionado no es válido.',
            'id_td.required' => 'El tipo de documento es obligatorio.',
            'id_td.exists' => 'El tipo de documento seleccionado no es válido.',
            'N_Documento.required' => 'El número de documento es obligatorio.',
            'N_Documento.min' => 'El documento debe tener al menos 8 caracteres.',
            'N_Documento.max' => 'El documento no debe exceder los 10 caracteres.',
            'N_Documento.unique' => 'Este número de documento ya está registrado.',
            'Celular.required' => 'El número de celular es obligatorio.',
            'Celular.digits' => 'El celular debe tener exactamente 10 dígitos.',
            'Celular.unique' => 'Este número de celular ya está registrado.',
            'Correo.required' => 'El correo electrónico es obligatorio.',
            'Correo.email' => 'El correo debe tener un formato válido.',
            'Correo.unique' => 'Este correo ya está registrado.',
            'Password.required' => 'La contraseña es obligatoria.',
            'Password.confirmed' => 'Las contraseñas no coinciden.',
            'Password.regex' => 'La contraseña debe tener entre 8 y 16 caracteres, incluir una mayúscula, una minúscula, un número y un carácter especial.'
        ]);
        $Editor = administradores::findOrFail($id);
        $datosActualizar = [
            'Nombres' => $Datos->Nombres,
            'Primer_Apellido' => $Datos->Primer_Apellido,
            'Segundo_Apellido' => $Datos->Segundo_Apellido,
            'Fecha_Nacimiento' => $Datos->Fecha_Nacimiento,
            'id_genero' => $Datos->id_genero,
            'id_td' => $Datos->id_td,
            'N_Documento' => $Datos->N_Documento,
            'Celular' => $Datos->Celular,
            'Correo' => $Datos->Correo,
        ];
        if ($Datos->filled('Password')) {
            $datosActualizar['Password'] = Hash::make($Datos->Password);
        }
        $Editor->update($datosActualizar);
        return redirect()->route('admin.lista')->with('Mensaje', 'Editor actualizado correctamente.');
    }

    public function CambiarEstado($id) {
        $id = Crypt::decrypt($id);
        $editor = administradores::findOrFail($id);
        $editor->Activida = !$editor->Activida;
        $editor->save();
        $estado = $editor->Activida ? 'activada' : 'desactivada';
        return redirect()->route('admin.lista')->with('Mensaje', "Cuenta {$estado} correctamente.");
    }
}