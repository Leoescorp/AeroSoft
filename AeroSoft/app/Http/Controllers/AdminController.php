<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Administrador;
use App\Models\administradores;
use App\Models\generos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AdminController extends Controller
{

    public function Index() {
        return view('Practica.Admin.Index');
    }

    public function ListaEditor(Request $Datos) {
        $Buscar = $Datos->input('Buscar');
        $genero = $Datos->input('rol');

        $user = administradores::with(['TD', 'Genero'])
            ->when($genero, function ($query) use ($genero) {
                $query->where('id_genero', $genero);
            })
            ->when($Buscar, function ($query) use ($Buscar) {
                $query->where(function ($sub) use ($Buscar) {
                    $sub->where('Nombres', 'like', "%$Buscar%");
                });
            })
            ->get();
        return view('Practica.Admin.Lista', compact('user', 'genero'));
    }

    public function Registrar() {
        $genero = generos::all();
        return view('Practica.Admin.Registrar', compact('genero'));
    }

    public function Registro(Request $Datos) {
        $Datos->validate([
            'Nombres' => 'required|string|min:1|max:50',
            'Primer_Apellido' => 'required|string|min:1|max:50',
            'Segundo_Apellido' => 'required|string|min:1|max:50',
            'Fecha_Nacimiento' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),'',
            'id_genero' => 'required|exists:generos,id_genero',
            'N_Documento' => 'required|min:8|max:10|unique:administradores,N_Documento',
            'Celular' => 'required|digist:10|unique:adminstradores,Celular',
            'Correo' => 'required|email|unique:usuario,Correo',
            'Password' => [
                'required',
                'confirmed',
                'regex:/^(?=.[0-9])(?=.[a-z])(?=.[A-Z])(?=.\W)(?!.* ).{8,16}$/'
            ]
        ],[
            'Nombres.required' => 'El campo nombres es obligatorio.',
            'Primer_Apellido.required' => 'El primer apellido es obligatorio.',
            'Segundo_Apellido.required' => 'El segundo apellido es obligatorio.',
            'Fecha_Nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'Fecha_Nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'Fecha_Nacimiento.before_or_equal' => 'Debes tener al menos 18 años.',
            'id_genero.required' => 'El género es obligatorio.',
            'id_genero.exists' => 'El género seleccionado no es válido.',
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
        $Admin = new administradores();
        $Admin->Nombre = $Datos->Nombre;
        $Admin->Apellido = $Datos->Apellido;
        $Admin->ID_TD = $Datos->ID_TD;
        $Admin->N_Documento = $Datos->N_Documento;
        $Admin->Correo = $Datos->Correo;
        $Admin->Password = bcrypt($Datos->Password);
        $Admin->save();
        return redirect('Mensaje/Index')->with('Mensaje', "Ya está registrado el nuevo editor.");
    }

    public function Editar($id) {
        $id = Crypt::decrypt($id);
        $genero = generos::all();
        return view('Practica.Admin.Editar', compact('genero'));
    }

    public function Actualizar(Request $Datos) {
        $id = Crypt::decrypt($Datos->id);
        $Datos->validate([
            'Nombres' => 'required|string|min:1|max:50',
            'Primer_Apellido' => 'required|string|min:1|max:50',
            'Segundo_Apellido' => 'required|string|min:1|max:50',
            'Fecha_Nacimiento' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),'',
            'id_genero' => 'required|exists:generos,id_genero',
            'N_Documento' => 'required|min:8|max:10|unique:administradores,N_Documento,' . $id . ',id_administradores',
            'Celular' => 'required|digist:10|unique:adminstradores,Celular,' . $id . ',id_administradores',
            'Correo' => 'required|email|unique:usuario,Correo,' . $id . ',id_administradores',
            'Password' => [
                'required',
                'confirmed',
                'regex:/^(?=.[0-9])(?=.[a-z])(?=.[A-Z])(?=.\W)(?!.* ).{8,16}$/'
            ]
        ],[
            'Nombres.required' => 'El campo nombres es obligatorio.',
            'Primer_Apellido.required' => 'El primer apellido es obligatorio.',
            'Segundo_Apellido.required' => 'El segundo apellido es obligatorio.',
            'Fecha_Nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'Fecha_Nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'Fecha_Nacimiento.before_or_equal' => 'Debes tener al menos 18 años.',
            'id_genero.required' => 'El género es obligatorio.',
            'id_genero.exists' => 'El género seleccionado no es válido.',
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
        $Editor->Nombres = $Datos->Nombres;
        $Editor->Primer_Apellido = $Datos->Primer_Apellido;
        $Editor->Segundo_Apellido = $Datos->Segundo_Apellido;
        $Editor->Fecha_Nacimiento = $Datos->Fecha_Nacimiento;
        $Editor->id_genero = $Datos->id_genero;
        $Editor->N_Documento = $Datos->N_Documento;
        $Editor->Celular = $Datos->Celular;
        $Editor->Correo = $Datos->Correo;
        if ($Datos->isDirty()) {
            $Editor->save();
            return redirect()->with('Mensaje', 'El usuario fue editado');
        }
        return back()->with('Mensaje', 'El usuario fue editado');
    }

}