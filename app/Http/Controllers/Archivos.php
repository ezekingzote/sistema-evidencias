<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class Archivos extends Controller
{
    public function index(Request $request)
    {
        $titulo = "Mi Unidad - Almacenamiento";
        $rutaActual = $request->get('ruta', '');

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disco */
        $disco = Storage::disk('public');

        $subidasArray = DB::table('evidencias')->get();

        $directoriosRaw = $disco->directories($rutaActual);
        $carpetas = [];
        foreach ($directoriosRaw as $dir) {
            $carpetas[] = [
                'nombre' => basename($dir),
                'ruta_completa' => $dir
            ];
        }

        $archivosRaw = $disco->files($rutaActual);
        $archivos = [];
        foreach ($archivosRaw as $file) {
            $bytes = $disco->size($file);
            
            if ($bytes >= 1048576) {
                $tamano = number_format($bytes / 1048576, 2) . ' MB';
            } elseif ($bytes >= 1024) {
                $tamano = number_format($bytes / 1024, 2) . ' KB';
            } else {
                $tamano = $bytes . ' bytes';
            }

            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            $archivos[] = [
                'nombre' => basename($file),
                'ruta_completa' => $file,
                'url' => $disco->url($file),
                'tamano' => $tamano,
                'extension' => $extension,
                'fecha' => date("d/m/Y", $disco->lastModified($file))
            ];
        }

        $espacioUsadoBytes = 0;
        foreach ($disco->allFiles() as $f) {
            $espacioUsadoBytes += $disco->size($f);
        }
        $espacioUsadoMB = round($espacioUsadoBytes / 1048576, 2);
        
        $porcentaje = ($espacioUsadoMB / 500) * 100;
        $porcentajeEstilo = "width: " . $porcentaje . "%;";

        $breadcrumbs = array_filter(explode('/', $rutaActual));

        return view('modules.archivos.index', compact(
            'titulo', 
            'carpetas', 
            'archivos', 
            'rutaActual', 
            'breadcrumbs', 
            'espacioUsadoMB',
            'porcentaje',
            'porcentajeEstilo',
            'subidasArray'
        ));
    }
}