<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        $titulo = "Login de usuarios";
        return view("modules.auth.login", compact("titulo"));
    }

    public function logear(Request $request)
    {
        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Credencial Incorrecta'])->withInput();
        }

        if (!$user->activo) {
            return back()->withErrors(['email' => 'Tu cuenta esta inactiva!']);
        }

        Auth::login($user);
        $request->session()->regenerate();

        // 👇 Inicializar modo activo = rol real del usuario
        session(['rol_activo' => $user->rol]);

        if ($user->rol === 'admin') {
            return redirect()->route('home');
        } else if ($user->rol === 'docente') {
            return redirect()->route('dashboard');
        }

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('login');
    }

    public function cambiarModo()
    {
        $user = Auth::user();

        if (!$user || $user->rol !== 'admin') {
            return back()->with('error', 'No tienes permisos para cambiar de modo.');
        }

        $modoActual = session('rol_activo', 'admin');
        $nuevoModo  = $modoActual === 'admin' ? 'docente' : 'admin';

        // Guardar en sesión
        session(['rol_activo' => $nuevoModo]);

        // 👇 FORZAR el guardado de la sesión ANTES de redirigir
        session()->save();

        return $nuevoModo === 'admin'
            ? redirect()->route('home')->with('success', 'Ahora estás en modo Administrador.')
            : redirect()->route('dashboard')->with('success', 'Ahora estás en modo Docente.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.confirmed' => 'Las nuevas contraseñas no coinciden.',
            'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.'
        ]);

        $user = User::findOrFail(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Tu contraseña actual no coincide con nuestros registros.');
        }

        if (Hash::check($request->password, $user->password)) {
            return back()->with('error', 'La nueva contraseña debe ser diferente a la anterior.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', '¡Contraseña actualizada con éxito!');
    }
}
