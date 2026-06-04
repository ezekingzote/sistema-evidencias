<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Imagenes extends Controller
{
    public function index()
    {
        $titulo = "Configuración de PDF";

        return view(
            'modules.imagenes.index',
            compact(
                'titulo'
            )
        );
    }

    public function update(Request $request)
{
    $request->validate([
        'header' => 'nullable|image',
        'footer' => 'nullable|image',
        'firma'  => 'nullable|image',
        'sello'  => 'nullable|image',
    ]);

    $ruta = public_path('img');

    if ($request->hasFile('header')) {
        $request->file('header')->move(
            $ruta,
            'header-pdf-cb.png'
        );
    }

    if ($request->hasFile('footer')) {
        $request->file('footer')->move(
            $ruta,
            'footer-pdf-cb.png'
        );
    }

    if ($request->hasFile('firma')) {
        $request->file('firma')->move(
            $ruta,
            'firma-cb.png'
        );
    }

    if ($request->hasFile('sello')) {
        $request->file('sello')->move(
            $ruta,
            'sello-cb.png'
        );
    }

    return redirect()
        ->back()
        ->with(
            'success',
            'Imágenes actualizadas correctamente'
        );
}
}
