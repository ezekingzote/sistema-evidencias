<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Checkrol
{
    /**
     * Maneja la petición verificando el rol.
     *
     * Un admin puede "bajar" temporalmente a modo docente usando
     * session('rol_activo'). Un docente NUNCA puede subir a admin.
     */
    public function handle(Request $request, Closure $next, string $rol): Response
    {
        if (!Auth::check()) {
            abort(403, 'No tienes permiso para acceder a esta Página!!');
        }

        $user = Auth::user();

        // Rol real del usuario
        $rolReal = $user->rol;

        // Modo activo guardado en sesión (por defecto el rol real)
        $modoActivo = session('rol_activo', $rolReal);

        // Seguridad: un docente jamás puede estar en modo admin
        if ($rolReal === 'docente' && $modoActivo === 'admin') {
            $modoActivo = 'docente';
            session(['rol_activo' => 'docente']);
        }

        // Verificar contra el rol requerido por la ruta
        if ($modoActivo !== $rol) {
            abort(403, 'No tienes permiso para acceder a esta Página!!');
        }

        return $next($request);
    }
}
