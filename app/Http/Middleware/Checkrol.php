<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Checkrol
{
    public function handle(Request $request, Closure $next, string $rol): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $rol = strtolower($rol);
        $rolUsuario = strtolower($user->rol);

        if (!$request->session()->has('panel_activo')) {
            $request->session()->put(
                'panel_activo',
                $rolUsuario === 'admin' ? 'admin' : 'docente'
            );
        }

        $panelActivo = $request->session()->get('panel_activo');

        if ($rol === 'admin') {
            if ($rolUsuario !== 'admin' || $panelActivo !== 'admin') {
                abort(403, 'No tienes acceso al panel de administrador.');
            }
        }

        if ($rol === 'docente') {
            $tienePerfilDocente = $user->docente && $user->docente->activo;

            if (!$tienePerfilDocente || $panelActivo !== 'docente') {
                abort(403, 'No tienes acceso al panel docente.');
            }
        }

        return $next($request);
    }
}
