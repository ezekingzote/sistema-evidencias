<?php

namespace App\Http\Controllers;

use App\Models\AsignacionMateria;
use App\Models\Materia;
use App\Models\Semestre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AsignarMaterias extends Controller
{
    public function index()
    {
        $titulo = "Asignar Materias";

        $items = AsignacionMateria::with([
            'materia',
            'docente',
            'semestre',
        ])
            ->orderBy('id', 'desc')
            ->get();

        return view('modules.asignar-materias.index', compact('titulo', 'items'));
    }

    public function create()
    {
        $titulo = "Asignar Materia";

        $docentes = User::whereIn('rol', ['admin', 'docente'])
            ->where('activo', 1)
            ->orderBy('name', 'asc')
            ->get();

        $semestreActivo = Semestre::where('activo', 1)->first();

        if ($semestreActivo) {
            $materias = Materia::where('activo', 1)
                ->with(['asignaciones' => function ($q) use ($semestreActivo) {
                    $q->where('semestre_id', $semestreActivo->id)
                        ->where('activo', 1);
                }])
                ->orderBy('nombre')
                ->get()
                ->map(function ($materia) use ($semestreActivo) {

                    // Info de la pivote (cuántos grupos se definieron)
                    $pivote = DB::table('materias_semestres')
                        ->where('semestre_id', $semestreActivo->id)
                        ->where('materia_id', $materia->id)
                        ->first();

                    $totalGruposDefinidos = $pivote->total_grupos ?? null;

                    // Letras ya usadas (ej: ['A','B'])
                    $letrasUsadas = $materia->asignaciones
                        ->map(function ($a) {
                            $partes = explode('-', $a->grupo);
                            $ultimo = end($partes);
                            return (strlen($ultimo) === 1 && ctype_alpha($ultimo))
                                ? strtoupper($ultimo)
                                : null;
                        })
                        ->filter()
                        ->unique()
                        ->values()
                        ->toArray();

                    // ¿La primera asignación es grupo único?
                    $primeraEsUnica = false;
                    if ($materia->asignaciones->count() > 0) {
                        $primera = $materia->asignaciones->sortBy('id')->first();
                        $partes  = explode('-', $primera->grupo);
                        $ultimo  = end($partes);
                        $primeraEsUnica = !(strlen($ultimo) === 1 && ctype_alpha($ultimo));
                    }

                    // Letras disponibles según total_grupos definido
                    if ($totalGruposDefinidos !== null) {
                        // Solo las primeras N letras (A..Z limitado a N)
                        $letrasPosibles = array_slice(range('A', 'Z'), 0, $totalGruposDefinidos);
                    } else {
                        // Aún no definido → todas disponibles
                        $letrasPosibles = range('A', 'Z');
                    }

                    $letrasDisponibles = array_values(array_diff($letrasPosibles, $letrasUsadas));

                    $materia->tiene_asignaciones      = $materia->asignaciones->count() > 0;
                    $materia->total_grupos_definidos  = $totalGruposDefinidos;
                    $materia->letras_usadas           = $letrasUsadas;
                    $materia->letras_disponibles      = $letrasDisponibles;
                    $materia->primera_es_unica        = $primeraEsUnica;

                    // Bloqueada si:
                    //  - Es grupo único ya asignado
                    //  - Ya se completaron todos los grupos definidos
                    $materia->bloqueada = $primeraEsUnica || empty($letrasDisponibles);

                    return $materia;
                })
                ->filter(function ($materia) {
                    return !$materia->bloqueada;
                })
                ->values();
        } else {
            $materias = collect();
        }

        return view('modules.asignar-materias.create', compact(
            'titulo',
            'docentes',
            'materias',
            'semestreActivo'
        ));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'semestre_id'   => 'required|exists:semestres,id',
                'materia_id'    => 'required|exists:materias,id',
                'docente_id'    => 'required|exists:users,id',
                'grupo'         => 'required|string|max:20',
                'alumnos'       => 'required|integer|min:1|max:100',
                'total_grupos'  => 'nullable|integer|min:1|max:26',
            ]);

            // ¿Ya tiene asignaciones esta materia en este semestre?
            $tieneAsignaciones = AsignacionMateria::where('semestre_id', $request->semestre_id)
                ->where('materia_id', $request->materia_id)
                ->where('activo', 1)
                ->exists();

            if (!$tieneAsignaciones) {
                // ── PRIMERA ASIGNACIÓN: debe venir total_grupos ──
                $totalGrupos = (int) $request->input('total_grupos', 0);

                if ($totalGrupos < 1 || $totalGrupos > 26) {
                    return back()->with('error', 'Debe definir cuántos grupos tendrá la materia (1 a 26).');
                }

                // Guardar total_grupos en la pivote
                DB::table('materias_semestres')
                    ->where('semestre_id', $request->semestre_id)
                    ->where('materia_id', $request->materia_id)
                    ->update([
                        'total_grupos' => $totalGrupos,
                        'updated_at'   => now(),
                    ]);

                // Si es grupo único, forzar grupo sin letra
                if ($totalGrupos === 1) {
                    $grupoFinal = preg_replace('/-[A-Z]$/', '', $request->grupo);
                } else {
                    $grupoFinal = $request->grupo;
                    // Si no tiene letra, forzar A
                    if (!preg_match('/-[A-Z]$/', $grupoFinal)) {
                        $grupoFinal .= '-A';
                    }
                }
            } else {
                // ── ASIGNACIÓN ADICIONAL: el grupo ya viene con letra ──
                $grupoFinal = $request->grupo;
            }

            // Evitar duplicado exacto
            $duplicado = AsignacionMateria::where('semestre_id', $request->semestre_id)
                ->where('materia_id', $request->materia_id)
                ->where('grupo', $grupoFinal)
                ->where('activo', 1)
                ->exists();

            if ($duplicado) {
                return back()->with('error', 'Ese grupo ya está asignado para esta materia.');
            }

            AsignacionMateria::create([
                'semestre_id' => $request->semestre_id,
                'materia_id'  => $request->materia_id,
                'docente_id'  => $request->docente_id,
                'grupo'       => $grupoFinal,
                'alumnos'     => $request->alumnos,
                'activo'      => 1,
            ]);

            DB::table('materias_semestres')
                ->where('semestre_id', $request->semestre_id)
                ->where('materia_id', $request->materia_id)
                ->update([
                    'asignada'   => 1,
                    'updated_at' => now(),
                ]);

            DB::commit();

            return redirect()->route('asignar-materias')
                ->with('success', 'Materia asignada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $titulo = "Editar Asignación";
        $item = AsignacionMateria::with(['materia', 'semestre'])->findOrFail($id);

        // Docentes activos
        $docentes = User::whereIn('rol', ['admin', 'docente'])
            ->where('activo', 1)
            ->orderBy('name', 'asc')
            ->get();

        // ¿Es la primera asignación (más antigua) de esta materia en este semestre?
        $primeraAsignacion = AsignacionMateria::where('semestre_id', $item->semestre_id)
            ->where('materia_id', $item->materia_id)
            ->where('activo', 1)
            ->orderBy('id')
            ->first();

        $esPrimera = $primeraAsignacion && $primeraAsignacion->id === $item->id;

        // Total de grupos definido actualmente
        $pivote = DB::table('materias_semestres')
            ->where('semestre_id', $item->semestre_id)
            ->where('materia_id', $item->materia_id)
            ->first();

        $totalGrupos = $pivote->total_grupos ?? 1;

        // Letras ya asignadas
        $letrasUsadas = AsignacionMateria::where('semestre_id', $item->semestre_id)
            ->where('materia_id', $item->materia_id)
            ->where('activo', 1)
            ->get()
            ->map(function ($a) {
                $partes = explode('-', $a->grupo);
                $ultimo = end($partes);
                return (strlen($ultimo) === 1 && ctype_alpha($ultimo))
                    ? strtoupper($ultimo)
                    : null;
            })
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        // Detectar el grupo base (SIS-1) para construir las letras nuevas
        $baseGrupo = preg_replace('/-[A-Z]$/', '', $item->grupo);

        // Calcular la "siguiente letra libre" que se puede asignar ahora (al aumentar)
        // Esta letra sería la A si la materia es grupo único y se aumenta a varios
        // O la siguiente letra después de las usadas + el nuevo total
        $letrasNuevasDisponibles = [];
        for ($i = 0; $i < 26; $i++) {
            $letra = chr(65 + $i);
            if (!in_array($letra, $letrasUsadas)) {
                $letrasNuevasDisponibles[] = $letra;
            }
        }

        return view('modules.asignar-materias.edit', compact(
            'titulo',
            'item',
            'docentes',
            'esPrimera',
            'totalGrupos',
            'letrasUsadas',
            'baseGrupo',
            'letrasNuevasDisponibles'
        ));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $item = AsignacionMateria::findOrFail($id);

            $request->validate([
                'docente_id' => 'required|exists:users,id',
                'alumnos'    => 'required|integer|min:1|max:100',
            ]);

            // ¿Es la primera asignación?
            $primeraAsignacion = AsignacionMateria::where('semestre_id', $item->semestre_id)
                ->where('materia_id', $item->materia_id)
                ->where('activo', 1)
                ->orderBy('id')
                ->first();

            $esPrimera = $primeraAsignacion && $primeraAsignacion->id === $item->id;

            // ─── Procesar cambios de total_grupos solo desde la primera ───
            if ($esPrimera && $request->filled('total_grupos')) {

                $nuevoTotal = (int) $request->total_grupos;

                if ($nuevoTotal < 1 || $nuevoTotal > 26) {
                    DB::rollBack();
                    return back()->with('error', 'El número de grupos debe estar entre 1 y 26.');
                }

                $pivote = DB::table('materias_semestres')
                    ->where('semestre_id', $item->semestre_id)
                    ->where('materia_id', $item->materia_id)
                    ->first();

                $totalActual = $pivote->total_grupos ?? 1;

                // Letras actualmente usadas
                $letrasUsadas = AsignacionMateria::where('semestre_id', $item->semestre_id)
                    ->where('materia_id', $item->materia_id)
                    ->where('activo', 1)
                    ->get()
                    ->map(function ($a) {
                        $partes = explode('-', $a->grupo);
                        $ultimo = end($partes);
                        return (strlen($ultimo) === 1 && ctype_alpha($ultimo))
                            ? strtoupper($ultimo)
                            : null;
                    })
                    ->filter()
                    ->unique()
                    ->values()
                    ->toArray();

                // ─── REDUCCIÓN: validar que no haya letras fuera del nuevo rango ───
                if ($nuevoTotal < $totalActual) {
                    $letrasPermitidas = array_slice(range('A', 'Z'), 0, $nuevoTotal);
                    $letrasFuera = array_values(array_diff($letrasUsadas, $letrasPermitidas));

                    if (!empty($letrasFuera)) {
                        DB::rollBack();
                        $letrasTxt = implode(', ', $letrasFuera);
                        return back()->with(
                            'error',
                            "No se puede reducir a {$nuevoTotal} grupos porque las letras [{$letrasTxt}] ya están asignadas. " .
                                "Elimine primero esas asignaciones y vuelva a intentar."
                        );
                    }
                }

                // ─── AUMENTO: procesar letra nueva (si el usuario eligió una) ───
                if ($nuevoTotal > $totalActual && $request->filled('letra_nueva')) {

                    $letraNueva = strtoupper($request->letra_nueva);

                    // Validar que la letra no esté ya usada
                    if (in_array($letraNueva, $letrasUsadas)) {
                        DB::rollBack();
                        return back()->with('error', "La letra [{$letraNueva}] ya está asignada.");
                    }

                    // Construir el nuevo grupo con la letra
                    $baseGrupo = preg_replace('/-[A-Z]$/', '', $item->grupo);
                    $grupoNuevo = $baseGrupo . '-' . $letraNueva;

                    // Reutilizamos ESTA misma asignación para guardar la letra nueva
                    // PERO eso implicaría que la primera asignación pierda su letra A original.
                    // En su lugar, creamos una NUEVA asignación con la letra elegida
                    // y la asignamos al mismo docente/alumnos indicados.
                    AsignacionMateria::create([
                        'semestre_id' => $item->semestre_id,
                        'materia_id'  => $item->materia_id,
                        'docente_id'  => $request->docente_id,
                        'grupo'       => $grupoNuevo,
                        'alumnos'     => $request->alumnos,
                        'activo'      => 1,
                    ]);

                    // La primera asignación solo guarda total_grupos, NO se modifica
                    // (a menos que sea grupo único → varios, donde hay que quitar/poner letra)
                }

                // ─── Actualizar total_grupos en la pivote ───
                DB::table('materias_semestres')
                    ->where('semestre_id', $item->semestre_id)
                    ->where('materia_id', $item->materia_id)
                    ->update([
                        'total_grupos' => $nuevoTotal,
                        'updated_at'   => now(),
                    ]);

                // ─── Ajustar el grupo de la primera asignación ───
                $partes      = explode('-', $item->grupo);
                $ultimo      = end($partes);
                $tieneLetra  = (strlen($ultimo) === 1 && ctype_alpha($ultimo));
                $grupoBase   = $tieneLetra ? implode('-', array_slice($partes, 0, -1)) : $item->grupo;

                if ($nuevoTotal === 1) {
                    // Vuelve a grupo único
                    $item->grupo = $grupoBase;
                } else {
                    // Si era grupo único y ahora es varios, forzar A
                    if (!$tieneLetra) {
                        $item->grupo = $grupoBase . '-A';
                    }
                    // Si ya tenía letra, se queda
                }
            }

            // ─── Actualizar docente/alumnos de la asignación actual ───
            $item->docente_id = $request->docente_id;
            $item->alumnos    = $request->alumnos;
            $item->save();

            DB::commit();

            return redirect()->route('asignar-materias')
                ->with('success', 'Asignación actualizada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $titulo = "Eliminar Asignación";
        $item = AsignacionMateria::with(['materia', 'semestre'])->findOrFail($id);

        return view('modules.asignar-materias.show', compact('titulo', 'item'));
    }

    public function destroy(Request $request, $id)
    {
        try {
            if (!Hash::check($request->password, Auth::user()->password)) {
                return response()->json(['error' => 'Contraseña incorrecta'], 401);
            }

            DB::beginTransaction();

            $item = AsignacionMateria::findOrFail($id);

            DB::table('materias_semestres')
                ->where('semestre_id', $item->semestre_id)
                ->where('materia_id', $item->materia_id)
                ->update([
                    'asignada'   => 0,
                    'updated_at' => now(),
                ]);

            $item->delete();
            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function estado(Request $request)
    {
        $item = AsignacionMateria::with(['materia', 'docente'])->findOrFail($request->id);

        if ($request->estado == 1) {
            if (!$item->materia || $item->materia->activo == 0) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'No se puede activar: La materia asociada está desactivada.'
                ]);
            }

            if (!$item->docente || $item->docente->activo == 0) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'No se puede activar: El docente asociado está desactivado.'
                ]);
            }
        }

        $item->activo = $request->estado;
        $item->save();

        return response()->json([
            'success' => true,
            'mensaje' => 'Estado actualizado correctamente'
        ]);
    }

    public function tbody()
    {
        $items = AsignacionMateria::with(['materia', 'docente', 'semestre'])->get();

        return view('modules.asignar-materias.tbody', compact('items'));
    }
}
