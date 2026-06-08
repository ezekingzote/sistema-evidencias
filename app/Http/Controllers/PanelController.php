<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanelController extends Controller
{
    public function cambiar(Request $request, string $panel)
    {
        $user = $request->user();

        if (!in_array($panel, ['admin', 'docente'], true)) {
            abort(404);
        }

        if ($panel === 'admin') {
            if ($user->rol !== 'admin') {
                abort(403, 'No tienes acceso al panel administrador.');
            }

            $request->session()->put('panel_activo', 'admin');

            return redirect()->route('home');
        }

        if ($panel === 'docente') {
            if (!$user->docente || !$user->docente->activo) {
                abort(403, 'No tienes perfil docente activo.');
            }

            $request->session()->put('panel_activo', 'docente');

            return redirect()->route('dashboard');
        }
    }
}
