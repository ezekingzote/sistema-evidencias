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
            return back()
                ->withErrors(['email' => 'Credencial Incorrecta'])
                ->withInput();
        }

        $rolUsuario = strtolower($user->rol);

        if ($rolUsuario === 'docente' && (!$user->docente || !$user->docente->activo)) {
            return back()->withErrors(['email' => 'Tu cuenta está inactiva!']);
        }

        Auth::login($user);
        $request->session()->regenerate();

        $request->session()->put(
            'panel_activo',
            $rolUsuario === 'admin' ? 'admin' : 'docente'
        );

        if ($rolUsuario === 'admin') {
            return redirect()->route('home');
        }

        if ($rolUsuario === 'docente') {
            return redirect()->route('dashboard');
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->withErrors(['email' => 'El usuario no tiene un rol válido.']);
    }

    public function logout()
    {
        Auth::logout();
        return to_route('login');
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
