<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evidencia;

class EvaluacionController extends Controller
{
    // Función centralizada para el cálculo
    public function calcularPromedio(array $datos)
    {
        $suma = 0;
        $contador = 0;

        foreach ($datos as $valor) {
            // Solo cuenta si es numérico y no es "NA" o vacío
            if ($valor !== 'NA' && $valor !== null && $valor !== "") {
                $suma += (float)$valor;
                $contador++;
            }
        }
        
        return ($contador > 0) ? ($suma / $contador) : 0;
    }

    public function actualizarEvaluacion(Request $request, $id)
    {
        $evidencia = Evidencia::findOrFail($id);
        
        // Supongamos que recibes un array 'valores' desde el formulario
        $nuevosValores = $request->input('valores'); 
        
        $promedio = $this->calcularPromedio($nuevosValores);

        $evidencia->update([
            'evaluacion' => [
                'detalles' => $nuevosValores,
                'promedio_final' => $promedio
            ],
            'estado' => 2 // Cambias el estado a aprobado o lo que necesites
        ]);

        return response()->json(['success' => true, 'promedio' => $promedio]);
    }
}