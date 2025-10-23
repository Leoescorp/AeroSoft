<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\administradores;
use App\Models\Documento;
use App\Models\documentos;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function MostrarLogin() {
        if (Auth::check()) {
            $User = Auth::user();
            return match ($User->id_rol) {
                1 => redirect('Admin/Index'),
                2 => redirect('Editor/Index'),
                default => redirect('Perfil/Index')
            };
        }
        return view('Practica.Login.Login');
    }

    public function Login(Request $Datos) {
        $Datos->validate([
            'Correo' => 'required|email',
            'Password' => 'required'
        ]);
        $Admin = \App\Models\administradores::where('Correo', $Datos->Correo)->first();
        if (!$Admin) {
            return back()->withErrors('Solo pueden acceder los administradores.');
        }
        if (!Hash::check($Datos->Password, $Admin->Password)) {
            return back()->withErrors('La contraseña es incorrecta.')->withInput();
        }
        if (Auth::attempt(['Correo' => $Datos->Correo, 'password' => $Datos->Password])) {
            $User = Auth::user();
            if ($User->Activida == 0) {
                Auth::logout();
                return back()->withErrors('Tu cuenta de administrador esta desactivada.');
            }
            session()->flash('bienvenida', "Bienvenido {$User->ROL->Rol} {$User->Nombre} {$User->Primer_Apellido} {$User->Segundo_Apellido}.");
            return match ($User->id_rol) {
                1 => redirect('Admin/Index'),
                2 => redirect('Editor/Index'),
                default => redirect('Perfil/Index')
            };
        }
        return back()->withErrors('No se pudo iniciar sesión. Solo los administradores pueden entrar.');
    }

    public function Logout() {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
