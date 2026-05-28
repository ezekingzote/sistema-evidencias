<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use ZipArchive;

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

    public function descargarCarpetaZip(Request $request)
    {
        $rutaCarpeta = $request->get('ruta');

        if (!$rutaCarpeta) {
            return back()->with('error', 'Ruta inválida.');
        }

        $disco = Storage::disk('public');

        if (!$disco->exists($rutaCarpeta)) {
            return back()->with('error', 'La carpeta no existe.');
        }

        $archivos = $disco->allFiles($rutaCarpeta);

        if (empty($archivos)) {
            return back()->with('error', 'La carpeta está vacía.');
        }

        $nombreZip = basename($rutaCarpeta) . '.zip';
        $zipPath = storage_path('app/public/' . $nombreZip);

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($archivos as $archivo) {
                $realPath = storage_path('app/public/' . $archivo);
                $nombreEnZip = str_replace($rutaCarpeta . '/', '', $archivo);
                
                if (file_exists($realPath)) {
                    $zip->addFile($realPath, $nombreEnZip);
                }
            }
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    // Retorna el archivo con los headers adecuados para evitar bloqueos del navegador
    public function verArchivo(Request $request)
    {
        $rutaParam = $request->get('ruta');
        
        if (!$rutaParam) {
            abort(404, 'Ruta no proporcionada.');
        }

        $ruta = base64_decode($rutaParam);
        
        if (!Storage::disk('public')->exists($ruta)) {
            abort(404, 'El archivo no existe.');
        }

        $path = storage_path('app/public/' . $ruta);
        
        // Retornamos de forma binaria nativa para saltar restricciones perimetrales del Web Server
        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"'
        ]);
    }

    public function descargarArchivo(Request $request)
    {
        $rutaParam = $request->get('ruta');

        if (!$rutaParam) {
            abort(404, 'Ruta no proporcionada.');
        }

        $ruta = base64_decode($rutaParam);

        if (!Storage::disk('public')->exists($ruta)) {
            abort(404, 'El archivo no existe.');
        }

        $path = storage_path('app/public/' . $ruta);
        
        return response()->download($path, basename($path));
    }
}