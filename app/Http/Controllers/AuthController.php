<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(){
        $titulo = "Login de usuarios";
        return view("modules.auth.login", compact("titulo"));
    }

    public function logear(Request $request){
        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Credencial Incorrecta'])->withInput();
        }

        if (!$user->activo) {
            return back()->withErrors(['email' =>'Tu cuenta esta inactiva!']);
        }

        Auth::login($user);
        $request->session()->regenerate();

        // REDIRECCIÓN SEGÚN ROL
        if ($user->rol === 'admin') {
            return redirect()->route('home');
        } else if ($user->rol === 'docente') {
            return redirect()->route('dashboard');
        }

        return redirect()->route('home');
    }

    public function crearAdmin(){
        User::create([
            'name' => 'Ezequiel Mendoza',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'activo' => true,
            'rol' => 'admin'
        ]);
        return 'Admin creado con Exito';
    }

    public function crearUsuario(){
        User::create([
            'name' => 'Usuario Docente',
            'email' => 'docente@test.com',
            'password' => Hash::make('docente'),
            'activo' => true,
            'rol' => 'docente'
        ]);
        return 'Docente creado con Exito';
    }

    public function logout(){
        Auth::logout();
        return to_route('login');
    }
}