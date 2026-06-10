<?php

namespace App\Http\Controllers;

use App\Models\Evidencia;
use App\Models\Revision;
use App\Models\AsignacionMateria;
use App\Models\Docente;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Evidencias extends Controller
{
    public function index()
    {
        $titulo = "Gestión de evidencias";
        $docente_id = Auth::id();

        $materias = Materia::with(['evidencias'])
            ->join('asignacion_materias', 'materias.id', '=', 'asignacion_materias.materia_id')
            ->where('asignacion_materias.docente_id', $docente_id)
            ->select('materias.*')
            ->distinct()
            ->get();

        $revisiones = Revision::orderBy('numero', 'asc')->get();

        return view('modules.evidencias.index', compact('materias', 'titulo', 'revisiones'));
    }

    public function create()
    {
        $docenteId = auth()->id();

        $materiasIds = AsignacionMateria::where('docente_id', $docenteId)
            ->where('activo', 1)
            ->pluck('materia_id');

        $materias = Materia::whereIn('id', $materiasIds)->get();
        $revisiones = Revision::where('activo', true)->get();

        $evidenciasSubidas = Evidencia::whereHas('asignacionMateria', function ($query) use ($docenteId) {
            $query->where('docente_id', $docenteId);
        })->get();

        $subidasArray = [];
        $unidadesUtilizadasPorMateria = [];

        foreach ($evidenciasSubidas as $ev) {
            $subidasArray[] = "{$ev->materia_id}-{$ev->revision_id}";

            $docs = $ev->documentos;
            $unidades = $docs['unidades'] ?? [];

            if (!isset($unidadesUtilizadasPorMateria[$ev->materia_id])) {
                $unidadesUtilizadasPorMateria[$ev->materia_id] = [];
            }

            $unidadesReales = array_filter($unidades, function ($unidad) {
                return (int)$unidad > 0;
            });

            $unidadesUtilizadasPorMateria[$ev->materia_id] = array_merge(
                $unidadesUtilizadasPorMateria[$ev->materia_id],
                $unidadesReales
            );

            $unidadesUtilizadasPorMateria[(string)$ev->materia_id] = array_values(
                array_unique($unidadesUtilizadasPorMateria[$ev->materia_id])
            );
        }

        return view('modules.evidencias.create', compact(
            'materias',
            'revisiones',
            'subidasArray',
            'unidadesUtilizadasPorMateria'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $docente = Docente::where('user_id', $user->id)->first();

        $idsDocentePermitidos = [$user->id];

        if ($docente) {
            $idsDocentePermitidos[] = $docente->id;
        }

        $materia = Materia::findOrFail($request->materia_id);
        $revision = Revision::findOrFail($request->revision_id);

        $asignacion = AsignacionMateria::where('materia_id', $materia->id)
            ->whereIn('docente_id', array_unique($idsDocentePermitidos))
            ->firstOrFail();

        $unidadesInput = array_values(array_unique(array_map(
            'intval',
            $request->input('unidades', [])
        )));

        $primeraRevisionId = (int) Revision::orderBy('id', 'asc')->value('id');
        $esPrimeraRevision = (int) $revision->id === $primeraRevisionId;
        $esCuartaRevision = (int) $revision->id === 4;

        $otrasEvidencias = Evidencia::where('asignacion_materia_id', $asignacion->id)
            ->get();

        $unidadesOcupadas = [];

        foreach ($otrasEvidencias as $otraEvidencia) {
            $datosOtra = is_array($otraEvidencia->documentos)
                ? $otraEvidencia->documentos
                : json_decode($otraEvidencia->documentos ?? '[]', true);

            if (!is_array($datosOtra)) {
                continue;
            }

            foreach (($datosOtra['unidades'] ?? []) as $unidadOtra) {
                $unidadOtra = (int) $unidadOtra;

                if ($unidadOtra !== 0) {
                    $unidadesOcupadas[] = $unidadOtra;
                }
            }
        }

        $unidadesOcupadas = array_values(array_unique($unidadesOcupadas));

        $totalUnidadesMateria = (int) ($materia->unidades ?? 0);

        $unidadesDisponibles = [];

        for ($i = 1; $i <= $totalUnidadesMateria; $i++) {
            if (!in_array($i, $unidadesOcupadas, true)) {
                $unidadesDisponibles[] = $i;
            }
        }

        $sinUnidadesDisponibles = count($unidadesDisponibles) === 0;

        if (empty($unidadesInput) && $sinUnidadesDisponibles) {
            $unidadesInput = [0];
        }

        $esNingunaUnidad = in_array(0, $unidadesInput, true);

        if (empty($unidadesInput)) {
            return back()
                ->withErrors([
                    'unidades' => 'Debes seleccionar al menos una unidad o marcar Ninguna Unidad cuando aplique.',
                ])
                ->withInput();
        }

        if ($esNingunaUnidad && count($unidadesInput) > 1) {
            return back()
                ->withErrors([
                    'unidades' => 'No puedes seleccionar Ninguna Unidad junto con otras unidades.',
                ])
                ->withInput();
        }

        if ($esCuartaRevision) {
            $reglaArchivosCuarta = 'required|file|mimes:pdf|max:5120';

            $request->validate([
                'actas' => $reglaArchivosCuarta,
                'evidencias_segunda_oportunidad' => 'required|array|min:1',
                'evidencias_segunda_oportunidad.*' => 'file|mimes:pdf|max:5120',
            ], [
                'actas.required' => 'El archivo de Actas es obligatorio en la Revisión 4.',
                'actas.mimes' => 'El archivo de Actas debe estar en formato PDF.',
                'actas.max' => 'El archivo de Actas no debe pesar más de 5 MB.',
                'evidencias_segunda_oportunidad.required' => 'Debes subir al menos una evidencia de segunda oportunidad.',
                'evidencias_segunda_oportunidad.*.mimes' => 'Todas las evidencias deben estar en formato PDF.',
                'evidencias_segunda_oportunidad.*.max' => 'Cada evidencia no debe pesar más de 5 MB.',
            ]);
        }

        foreach ($unidadesInput as $unidadSeleccionada) {
            if ($unidadSeleccionada === 0) {
                continue;
            }

            if ($unidadSeleccionada < 1 || $unidadSeleccionada > $totalUnidadesMateria) {
                return back()
                    ->withErrors([
                        'unidades' => "La Unidad {$unidadSeleccionada} no pertenece a esta materia.",
                    ])
                    ->withInput();
            }

            if (in_array($unidadSeleccionada, $unidadesOcupadas, true)) {
                return back()
                    ->withErrors([
                        'unidades' => "La Unidad {$unidadSeleccionada} ya fue evaluada en otra revisión.",
                    ])
                    ->withInput();
            }
        }

        $reglaArchivoGeneral = $esPrimeraRevision
            ? 'required|file|mimes:pdf|max:5120'
            : 'nullable|file|mimes:pdf|max:5120';

        $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'revision_id' => 'required|exists:revisiones,id',
            'unidades' => 'required|array',
            'unidades.*' => 'integer',

            'motivo_no_evaluo' => $esNingunaUnidad
                ? 'required|string|min:5|max:1000'
                : 'nullable|string|max:1000',

            'instrumentacion' => $reglaArchivoGeneral,
            'reporte_inicio' => $reglaArchivoGeneral,
            'acuerdos' => $reglaArchivoGeneral,

            'calificaciones' => $esNingunaUnidad ? 'nullable|array' : 'required|array',
            'calificaciones.*' => 'file|mimes:pdf|max:5120',

            'rac' => 'nullable|array',
            'rac.*' => 'nullable|file|mimes:pdf|max:5120',

            'rac_na' => 'nullable|array',
            'rac_na.*' => 'nullable|boolean',

            'examen_diagnostico' => $reglaArchivoGeneral,
            'analisis_diagnostico' => $reglaArchivoGeneral,

            'rubricas' => $esNingunaUnidad ? 'nullable|array' : 'required|array',
            'rubricas.*' => 'file|mimes:pdf|max:5120',

            'instrumentos' => 'nullable|array',
            'instrumentos.*' => 'array',
            'instrumentos.*.*' => 'file|mimes:pdf|max:5120',
        ], [
            '*.mimes' => 'Todos los archivos deben estar en formato PDF.',
            '*.max' => 'Cada archivo PDF no debe pesar más de 5 MB.',

            'motivo_no_evaluo.required' => 'Debes escribir el motivo por el que no se evaluó ninguna unidad.',
            'motivo_no_evaluo.min' => 'El motivo debe tener al menos 5 caracteres.',
            'motivo_no_evaluo.max' => 'El motivo no debe superar los 1000 caracteres.',

            'instrumentacion.required' => 'La instrumentación didáctica es obligatoria en la primera revisión.',
            'reporte_inicio.required' => 'El reporte de inicio de curso es obligatorio en la primera revisión.',
            'acuerdos.required' => 'Los acuerdos de clase son obligatorios en la primera revisión.',
            'examen_diagnostico.required' => 'El examen diagnóstico es obligatorio en la primera revisión.',
            'analisis_diagnostico.required' => 'El análisis del diagnóstico es obligatorio en la primera revisión.',

            'calificaciones.required' => 'Debes subir la lista de calificaciones de las unidades seleccionadas.',
            'rubricas.required' => 'Debes subir las rúbricas de las unidades seleccionadas.',
        ]);

        $motivoNoEvaluo = $esNingunaUnidad
            ? trim((string) $request->input('motivo_no_evaluo'))
            : null;

        if (!$esNingunaUnidad) {
            $racNaUnidades = $request->input('rac_na', []);
            $errores = [];

            foreach ($unidadesInput as $numUnidad) {
                if (!$request->hasFile("calificaciones.{$numUnidad}")) {
                    $errores["calificaciones.{$numUnidad}"] = "La lista de calificaciones de la Unidad {$numUnidad} es obligatoria.";
                }

                if (!$request->hasFile("rubricas.{$numUnidad}")) {
                    $errores["rubricas.{$numUnidad}"] = "La rúbrica de la Unidad {$numUnidad} es obligatoria.";
                }

                $racEsNoAplica = array_key_exists($numUnidad, $racNaUnidades)
                    || array_key_exists((string) $numUnidad, $racNaUnidades);

                if (!$racEsNoAplica && !$request->hasFile("rac.{$numUnidad}")) {
                    $errores["rac.{$numUnidad}"] = "Debes subir el RAC de la Unidad {$numUnidad} o marcar No aplica.";
                }
            }

            if (!empty($errores)) {
                return back()
                    ->withErrors($errores)
                    ->withInput();
            }
        }

        $semestreNombre = $this->limpiarNombre($asignacion->semestre->nombre ?? 'SIN_SEMESTRE');
        $materiaNombre = $this->limpiarNombre($materia->nombre);
        $revisionNombre = $this->limpiarNombre($revision->nombre);

        $basePath = "evidencias_pdf/{$semestreNombre}/{$materiaNombre}/{$revisionNombre}";

        $documentos = [];
        $evidencias = [];
        $instrumentosGrupales = [];
        $instrumentosNa = false;

        if ($esCuartaRevision) {
            $documentos['acta'] = $request->file('actas')->storeAs(
                $basePath . '/documentos',
                'acta_revision_4.pdf',
                'public'
            );

            $evidenciasSegundaOportunidad = [];
            foreach ($request->file('evidencias_segunda_oportunidad') as $index => $file) {
                $evidenciasSegundaOportunidad[] = $file->storeAs(
                    $basePath . '/evidencias_segunda_oportunidad',
                    "evidencia_segunda_oportunidad_" . ($index + 1) . ".pdf",
                    'public'
                );
            }
            $evidencias['segunda_oportunidad'] = $evidenciasSegundaOportunidad;
        }

        if ($esPrimeraRevision) {
            $globalDocs = [
                'instrumentacion',
                'reporte_inicio',
                'acuerdos',
            ];

            foreach ($globalDocs as $field) {
                $documentos[$field] = $request->file($field)->storeAs(
                    $basePath . '/documentos',
                    $field . '.pdf',
                    'public'
                );
            }

            $globalEvis = [
                'examen_diagnostico',
                'analisis_diagnostico',
            ];

            foreach ($globalEvis as $field) {
                $evidencias[$field] = $request->file($field)->storeAs(
                    $basePath . '/evidencias',
                    $field . '.pdf',
                    'public'
                );
            }
        } else {
            $documentos['instrumentacion'] = [
                'na' => true,
                'archivo' => null,
            ];

            $documentos['reporte_inicio'] = [
                'na' => true,
                'archivo' => null,
            ];

            $documentos['acuerdos'] = [
                'na' => true,
                'archivo' => null,
            ];

            $evidencias['examen_diagnostico'] = [
                'na' => true,
                'archivo' => null,
            ];

            $evidencias['analisis_diagnostico'] = [
                'na' => true,
                'archivo' => null,
            ];
        }

        if ($esNingunaUnidad) {
            $unidades = [0];

            $documentos['calificaciones'] = [
                'na' => true,
                'archivo' => null,
                'motivo' => $motivoNoEvaluo,
            ];

            $documentos['calificaciones_detalladas'] = [
                'u0' => [
                    'na' => true,
                    'archivo' => null,
                    'motivo' => $motivoNoEvaluo,
                ],
            ];

            $documentos['rac'] = [
                'na' => true,
                'archivo' => null,
            ];

            $documentos['rac_detallado'] = [
                'u0' => [
                    'na' => true,
                    'archivo' => null,
                ],
            ];

            $evidencias['rubricas'] = [
                'na' => true,
                'archivo' => null,
            ];

            $evidencias['rubricas_detalladas'] = [
                'u0' => [
                    'na' => true,
                    'archivo' => null,
                ],
            ];

            $instrumentosGrupales = [];
            $instrumentosNa = true;
        } else {
            $unidades = array_values(array_filter($unidadesInput, function ($unidad) {
                return (int) $unidad !== 0;
            }));

            $racNaUnidades = $request->input('rac_na', []);

            foreach ($unidades as $index => $numUnidad) {
                if ($request->hasFile("calificaciones.{$numUnidad}")) {
                    $pathCal = $request->file("calificaciones.{$numUnidad}")->storeAs(
                        $basePath . '/documentos',
                        "calificaciones_u{$numUnidad}.pdf",
                        'public'
                    );

                    $documentos['calificaciones_detalladas']["u{$numUnidad}"] = [
                        'na' => false,
                        'archivo' => $pathCal,
                    ];

                    if ($index === 0) {
                        $documentos['calificaciones'] = [
                            'na' => false,
                            'archivo' => $pathCal,
                        ];
                    }
                }

                $racEsNoAplica = array_key_exists($numUnidad, $racNaUnidades)
                    || array_key_exists((string) $numUnidad, $racNaUnidades);

                if ($racEsNoAplica) {
                    $documentos['rac_detallado']["u{$numUnidad}"] = [
                        'na' => true,
                        'archivo' => null,
                    ];

                    if ($index === 0) {
                        $documentos['rac'] = [
                            'na' => true,
                            'archivo' => null,
                        ];
                    }
                } else {
                    $pathRac = $request->file("rac.{$numUnidad}")->storeAs(
                        $basePath . '/documentos',
                        "RAC_u{$numUnidad}.pdf",
                        'public'
                    );

                    $documentos['rac_detallado']["u{$numUnidad}"] = [
                        'na' => false,
                        'archivo' => $pathRac,
                    ];

                    if ($index === 0) {
                        $documentos['rac'] = [
                            'na' => false,
                            'archivo' => $pathRac,
                        ];
                    }
                }

                if ($request->hasFile("rubricas.{$numUnidad}")) {
                    $pathRub = $request->file("rubricas.{$numUnidad}")->storeAs(
                        $basePath . '/evidencias',
                        "rubricas_u{$numUnidad}.pdf",
                        'public'
                    );

                    $evidencias['rubricas_detalladas']["u{$numUnidad}"] = [
                        'na' => false,
                        'archivo' => $pathRub,
                    ];

                    if ($index === 0) {
                        $evidencias['rubricas'] = [
                            'na' => false,
                            'archivo' => $pathRub,
                        ];
                    }
                }

                if ($request->hasFile("instrumentos.{$numUnidad}")) {
                    foreach ($request->file("instrumentos.{$numUnidad}") as $fileIndex => $file) {
                        if ($fileIndex >= 3) {
                            break;
                        }

                        $nombreInstrumento = "instrumento_u{$numUnidad}_" . ($fileIndex + 1) . ".pdf";

                        $instrumentosGrupales[] = $file->storeAs(
                            $basePath . '/instrumentos',
                            $nombreInstrumento,
                            'public'
                        );
                    }
                }
            }
        }

        $json = [
            'unidades' => $unidades,
            'motivo_no_evaluo' => $motivoNoEvaluo,
            'documentos' => $documentos,
            'evidencias' => $evidencias,
            'instrumentos' => $instrumentosGrupales,
            'instrumentos_na' => $instrumentosNa,
        ];

        Evidencia::updateOrCreate(
            [
                'asignacion_materia_id' => $asignacion->id,
                'revision_id' => $revision->id,
            ],
            [
                'materia_id' => $materia->id,
                'documentos' => $json,
                'estado' => 3,
            ]
        );

        return redirect()
            ->route('evidencias')
            ->with('success', 'Evidencia guardada correctamente');
    }

    public function edit($id)
    {
        $evidencia = Evidencia::with([
            'materia',
            'revision',
            'admin'
        ])->findOrFail($id);

        $user = Auth::user();

        $docente = Docente::where('user_id', $user->id)->first();

        $idsDocentePermitidos = [$user->id];

        if ($docente) {
            $idsDocentePermitidos[] = $docente->id;
        }

        $item = $evidencia;

        $asignacion = AsignacionMateria::where('id', $evidencia->asignacion_materia_id)
            ->whereIn('docente_id', array_unique($idsDocentePermitidos))
            ->firstOrFail();

        $datos = is_array($evidencia->documentos)
            ? $evidencia->documentos
            : json_decode($evidencia->documentos ?? '[]', true);

        if (!is_array($datos)) {
            $datos = [];
        }

        $unidades = $datos['unidades'] ?? [];
        $documentos = $datos['documentos'] ?? [];
        $evidencias = $datos['evidencias'] ?? [];

        $motivoNoEvaluo = $datos['motivo_no_evaluo']
            ?? ($documentos['calificaciones']['motivo'] ?? null)
            ?? ($documentos['calificaciones_detalladas']['u0']['motivo'] ?? null)
            ?? '';

        $unidades = array_values(array_map('intval', $unidades));

        $otrasEvidencias = Evidencia::where('asignacion_materia_id', $evidencia->asignacion_materia_id)
            ->where('id', '!=', $evidencia->id)
            ->get();

        $unidadesOcupadas = [];

        foreach ($otrasEvidencias as $otraEvidencia) {
            $datosOtra = is_array($otraEvidencia->documentos)
                ? $otraEvidencia->documentos
                : json_decode($otraEvidencia->documentos ?? '[]', true);

            if (!is_array($datosOtra)) {
                continue;
            }

            $unidadesOtra = $datosOtra['unidades'] ?? [];

            foreach ($unidadesOtra as $unidad) {
                $unidad = (int) $unidad;

                if ($unidad !== 0) {
                    $unidadesOcupadas[] = $unidad;
                }
            }
        }

        $unidadesOcupadas = array_values(array_unique($unidadesOcupadas));

        $totalUnidadesMateria = (int) ($evidencia->materia->unidades ?? 0);

        $unidadesActualesSinCero = array_values(array_filter($unidades, function ($unidad) {
            return (int) $unidad !== 0;
        }));

        $unidadesDisponiblesParaEditar = [];

        for ($i = 1; $i <= $totalUnidadesMateria; $i++) {
            $unidadEstaOcupada = in_array($i, $unidadesOcupadas, true);
            $unidadEsActual = in_array($i, $unidadesActualesSinCero, true);

            if (!$unidadEstaOcupada || $unidadEsActual) {
                $unidadesDisponiblesParaEditar[] = $i;
            }
        }

        if (count($unidadesDisponiblesParaEditar) === 0 && count($unidadesActualesSinCero) === 0) {
            $unidades = [0];
        }

        return view('modules.evidencias.edit', compact(
            'evidencia',
            'unidades',
            'documentos',
            'evidencias',
            'unidadesOcupadas',
            'item',
            'motivoNoEvaluo'
        ));
    }

    public function update(Request $request, $id)
    {
        $evidencia = Evidencia::with([
            'materia',
            'revision'
        ])->findOrFail($id);

        $estadoActual = strtolower((string) ($evidencia->estado ?? ''));

        // No permitir modificar si está aprobada (estado 2) o rechazada (estado 4)
        if (in_array($estadoActual, ['2', 'aprobado', 'aprobada'], true)) {
            return back()
                ->withErrors([
                    'estado' => 'Esta evidencia ya fue aprobada y no puede modificarse.',
                ])
                ->withInput();
        }

        $user = Auth::user();

        $docente = Docente::where('user_id', $user->id)->first();

        $idsDocentePermitidos = [$user->id];

        if ($docente) {
            $idsDocentePermitidos[] = $docente->id;
        }

        $asignacion = AsignacionMateria::where('id', $evidencia->asignacion_materia_id)
            ->whereIn('docente_id', array_unique($idsDocentePermitidos))
            ->firstOrFail();

        $materia = $evidencia->materia;
        $revision = $evidencia->revision;

        $datosActuales = is_array($evidencia->documentos)
            ? $evidencia->documentos
            : json_decode($evidencia->documentos ?? '[]', true);

        if (!is_array($datosActuales)) {
            $datosActuales = [];
        }

        $datosActuales['documentos'] = $datosActuales['documentos'] ?? [];
        $datosActuales['evidencias'] = $datosActuales['evidencias'] ?? [];
        $datosActuales['instrumentos'] = $datosActuales['instrumentos'] ?? [];
        $datosActuales['instrumentos_na'] = $datosActuales['instrumentos_na'] ?? false;

        $unidadesSeleccionadas = array_values(array_unique(array_map(
            'intval',
            $request->input('unidades', [])
        )));

        $primeraRevisionId = (int) Revision::orderBy('id', 'asc')->value('id');
        $esPrimeraRevision = (int) $revision->id === $primeraRevisionId;

        $otrasEvidencias = Evidencia::where('asignacion_materia_id', $evidencia->asignacion_materia_id)
            ->where('id', '!=', $evidencia->id)
            ->get();

        $unidadesOcupadas = [];

        foreach ($otrasEvidencias as $otraEvidencia) {
            $datosOtra = is_array($otraEvidencia->documentos)
                ? $otraEvidencia->documentos
                : json_decode($otraEvidencia->documentos ?? '[]', true);

            if (!is_array($datosOtra)) {
                continue;
            }

            foreach (($datosOtra['unidades'] ?? []) as $unidadOtra) {
                $unidadOtra = (int) $unidadOtra;

                if ($unidadOtra !== 0) {
                    $unidadesOcupadas[] = $unidadOtra;
                }
            }
        }

        $unidadesOcupadas = array_values(array_unique($unidadesOcupadas));

        $totalUnidadesMateria = (int) ($materia->unidades ?? 0);

        $unidadesActuales = array_values(array_map(
            'intval',
            $datosActuales['unidades'] ?? []
        ));

        $unidadesActualesSinCero = array_values(array_filter($unidadesActuales, function ($unidad) {
            return (int) $unidad !== 0;
        }));

        $unidadesDisponiblesParaEditar = [];

        for ($i = 1; $i <= $totalUnidadesMateria; $i++) {
            $unidadEstaOcupada = in_array($i, $unidadesOcupadas, true);
            $unidadEsActual = in_array($i, $unidadesActualesSinCero, true);

            if (!$unidadEstaOcupada || $unidadEsActual) {
                $unidadesDisponiblesParaEditar[] = $i;
            }
        }

        $sinUnidadesDisponibles = count($unidadesDisponiblesParaEditar) === 0;

        if (empty($unidadesSeleccionadas) && $sinUnidadesDisponibles) {
            $unidadesSeleccionadas = [0];
        }

        $esNingunaUnidad = in_array(0, $unidadesSeleccionadas, true);

        if (empty($unidadesSeleccionadas)) {
            return back()
                ->withErrors([
                    'unidades' => 'Debes seleccionar al menos una unidad o marcar Ninguna Unidad cuando aplique.',
                ])
                ->withInput();
        }

        if ($esNingunaUnidad && count($unidadesSeleccionadas) > 1) {
            return back()
                ->withErrors([
                    'unidades' => 'No puedes seleccionar Ninguna Unidad junto con otras unidades.',
                ])
                ->withInput();
        }

        if ($esNingunaUnidad && !$esPrimeraRevision && !$sinUnidadesDisponibles) {
            return back()
                ->withErrors([
                    'unidades' => 'La opción Ninguna Unidad solo está permitida en la primera revisión o cuando ya no hay unidades disponibles.',
                ])
                ->withInput();
        }

        foreach ($unidadesSeleccionadas as $unidadSeleccionada) {
            if ($unidadSeleccionada === 0) {
                continue;
            }

            if ($unidadSeleccionada < 1 || $unidadSeleccionada > $totalUnidadesMateria) {
                return back()
                    ->withErrors([
                        'unidades' => "La Unidad {$unidadSeleccionada} no pertenece a esta materia.",
                    ])
                    ->withInput();
            }

            if (in_array($unidadSeleccionada, $unidadesOcupadas, true)) {
                return back()
                    ->withErrors([
                        'unidades' => "La Unidad {$unidadSeleccionada} ya fue evaluada en otra revisión.",
                    ])
                    ->withInput();
            }
        }

        $request->validate([
            'instrumentacion' => 'nullable|file|mimes:pdf|max:5120',
            'reporte_inicio' => 'nullable|file|mimes:pdf|max:5120',
            'acuerdos' => 'nullable|file|mimes:pdf|max:5120',

            'calificaciones' => 'nullable|array',
            'calificaciones.*' => 'nullable|file|mimes:pdf|max:5120',

            'rac' => 'nullable|array',
            'rac.*' => 'nullable|file|mimes:pdf|max:5120',

            'rac_na' => 'nullable|array',
            'rac_na.*' => 'nullable|boolean',

            'examen_diagnostico' => 'nullable|file|mimes:pdf|max:5120',
            'analisis_diagnostico' => 'nullable|file|mimes:pdf|max:5120',

            'rubricas' => 'nullable|array',
            'rubricas.*' => 'nullable|file|mimes:pdf|max:5120',

            'instrumentos' => 'nullable|array',
            'instrumentos.*' => 'array',
            'instrumentos.*.*' => 'file|mimes:pdf|max:5120',

            'eliminar_instrumentos' => 'nullable|array',
        ], [
            '*.mimes' => 'Todos los archivos deben estar en formato PDF.',
            '*.max' => 'Cada archivo PDF no debe pesar más de 5 MB.',
        ]);

        $obtenerArchivo = function ($valor) {
            if (is_array($valor)) {
                return $valor['archivo'] ?? null;
            }

            if (is_string($valor) && trim($valor) !== '') {
                return $valor;
            }

            return null;
        };

        $eliminarArchivo = function ($valor) use ($obtenerArchivo) {
            $archivo = $obtenerArchivo($valor);

            if (!empty($archivo)) {
                Storage::disk('public')->delete($archivo);
            }
        };

        $semestreNombre = $this->limpiarNombre($asignacion->semestre->nombre ?? 'SIN_SEMESTRE');
        $materiaNombre = $this->limpiarNombre($materia->nombre);
        $revisionNombre = $this->limpiarNombre($revision->nombre);

        $basePath = "evidencias_pdf/{$semestreNombre}/{$materiaNombre}/{$revisionNombre}";

        $actualizarArchivo = function ($campo, $subcarpeta, $nombreFijo) use (
            $request,
            $basePath,
            &$datosActuales,
            $obtenerArchivo,
            $eliminarArchivo
        ) {
            $archivoActual = $datosActuales[$subcarpeta][$campo] ?? null;

            if ($request->hasFile($campo)) {
                $eliminarArchivo($archivoActual);

                return $request->file($campo)->storeAs(
                    $basePath . '/' . $subcarpeta,
                    $nombreFijo,
                    'public'
                );
            }

            return $obtenerArchivo($archivoActual);
        };

        if ($esPrimeraRevision) {
            $datosActuales['documentos']['instrumentacion'] = $actualizarArchivo(
                'instrumentacion',
                'documentos',
                'instrumentacion.pdf'
            );

            $datosActuales['documentos']['reporte_inicio'] = $actualizarArchivo(
                'reporte_inicio',
                'documentos',
                'reporte_inicio.pdf'
            );

            $datosActuales['documentos']['acuerdos'] = $actualizarArchivo(
                'acuerdos',
                'documentos',
                'acuerdos.pdf'
            );

            $datosActuales['evidencias']['examen_diagnostico'] = $actualizarArchivo(
                'examen_diagnostico',
                'evidencias',
                'examen_diagnostico.pdf'
            );

            $datosActuales['evidencias']['analisis_diagnostico'] = $actualizarArchivo(
                'analisis_diagnostico',
                'evidencias',
                'analisis_diagnostico.pdf'
            );
        } else {
            foreach (['instrumentacion', 'reporte_inicio', 'acuerdos'] as $campo) {
                if (isset($datosActuales['documentos'][$campo])) {
                    $eliminarArchivo($datosActuales['documentos'][$campo]);
                }

                $datosActuales['documentos'][$campo] = [
                    'na' => true,
                    'archivo' => null,
                ];
            }

            foreach (['examen_diagnostico', 'analisis_diagnostico'] as $campo) {
                if (isset($datosActuales['evidencias'][$campo])) {
                    $eliminarArchivo($datosActuales['evidencias'][$campo]);
                }

                $datosActuales['evidencias'][$campo] = [
                    'na' => true,
                    'archivo' => null,
                ];
            }
        }

        if ($esNingunaUnidad) {
            foreach ($datosActuales['documentos']['calificaciones_detalladas'] ?? [] as $archivo) {
                $eliminarArchivo($archivo);
            }

            foreach ($datosActuales['documentos']['rac_detallado'] ?? [] as $archivo) {
                $eliminarArchivo($archivo);
            }

            foreach ($datosActuales['evidencias']['rubricas_detalladas'] ?? [] as $archivo) {
                $eliminarArchivo($archivo);
            }

            foreach ($datosActuales['instrumentos'] ?? [] as $archivo) {
                $eliminarArchivo($archivo);
            }

            $datosActuales['unidades'] = [0];

            $datosActuales['documentos']['calificaciones'] = [
                'na' => true,
                'archivo' => null,
            ];

            $datosActuales['documentos']['calificaciones_detalladas'] = [
                'u0' => [
                    'na' => true,
                    'archivo' => null,
                ],
            ];

            $datosActuales['documentos']['rac'] = [
                'na' => true,
                'archivo' => null,
            ];

            $datosActuales['documentos']['rac_detallado'] = [
                'u0' => [
                    'na' => true,
                    'archivo' => null,
                ],
            ];

            $datosActuales['evidencias']['rubricas'] = [
                'na' => true,
                'archivo' => null,
            ];

            $datosActuales['evidencias']['rubricas_detalladas'] = [
                'u0' => [
                    'na' => true,
                    'archivo' => null,
                ],
            ];

            $datosActuales['instrumentos'] = [];
            $datosActuales['instrumentos_na'] = true;
        } else {
            $unidadesReales = array_values(array_filter($unidadesSeleccionadas, function ($unidad) {
                return (int) $unidad !== 0;
            }));

            $datosActuales['unidades'] = $unidadesReales;
            $datosActuales['instrumentos_na'] = false;

            $datosActuales['documentos']['calificaciones_detalladas'] =
                $datosActuales['documentos']['calificaciones_detalladas'] ?? [];

            $datosActuales['documentos']['rac_detallado'] =
                $datosActuales['documentos']['rac_detallado'] ?? [];

            $datosActuales['evidencias']['rubricas_detalladas'] =
                $datosActuales['evidencias']['rubricas_detalladas'] ?? [];

            $keysSeleccionadas = array_map(function ($unidad) {
                return "u{$unidad}";
            }, $unidadesReales);

            foreach ($datosActuales['documentos']['calificaciones_detalladas'] as $key => $valor) {
                if ($key !== 'u0' && !in_array($key, $keysSeleccionadas, true)) {
                    $eliminarArchivo($valor);
                    unset($datosActuales['documentos']['calificaciones_detalladas'][$key]);
                }
            }

            foreach ($datosActuales['documentos']['rac_detallado'] as $key => $valor) {
                if ($key !== 'u0' && !in_array($key, $keysSeleccionadas, true)) {
                    $eliminarArchivo($valor);
                    unset($datosActuales['documentos']['rac_detallado'][$key]);
                }
            }

            foreach ($datosActuales['evidencias']['rubricas_detalladas'] as $key => $valor) {
                if ($key !== 'u0' && !in_array($key, $keysSeleccionadas, true)) {
                    $eliminarArchivo($valor);
                    unset($datosActuales['evidencias']['rubricas_detalladas'][$key]);
                }
            }

            unset($datosActuales['documentos']['calificaciones_detalladas']['u0']);
            unset($datosActuales['documentos']['rac_detallado']['u0']);
            unset($datosActuales['evidencias']['rubricas_detalladas']['u0']);

            $datosActuales['instrumentos'] = array_values(array_filter(
                $datosActuales['instrumentos'] ?? [],
                function ($path) use ($unidadesReales) {
                    if (!is_string($path)) {
                        return false;
                    }

                    if (preg_match('/instrumento_u(\d+)_/', $path, $matches)) {
                        $unidadArchivo = (int) $matches[1];

                        if (!in_array($unidadArchivo, $unidadesReales, true)) {
                            Storage::disk('public')->delete($path);
                            return false;
                        }
                    }

                    return true;
                }
            ));

            $racNaUnidades = $request->input('rac_na', []);
            $errores = [];

            foreach ($unidadesReales as $unidad) {
                $keyUnidad = "u{$unidad}";

                $calificacionActual = $datosActuales['documentos']['calificaciones_detalladas'][$keyUnidad] ?? null;
                $calificacionActualArchivo = $obtenerArchivo($calificacionActual);

                if (!$request->hasFile("calificaciones.{$unidad}") && empty($calificacionActualArchivo)) {
                    $errores["calificaciones.{$unidad}"] = "La lista de calificaciones de la Unidad {$unidad} es obligatoria.";
                }

                $rubricaActual = $datosActuales['evidencias']['rubricas_detalladas'][$keyUnidad] ?? null;
                $rubricaActualArchivo = $obtenerArchivo($rubricaActual);

                if (!$request->hasFile("rubricas.{$unidad}") && empty($rubricaActualArchivo)) {
                    $errores["rubricas.{$unidad}"] = "La rúbrica de la Unidad {$unidad} es obligatoria.";
                }

                $racActual = $datosActuales['documentos']['rac_detallado'][$keyUnidad] ?? null;
                $racActualArchivo = $obtenerArchivo($racActual);

                $racEsNoAplica = array_key_exists($unidad, $racNaUnidades)
                    || array_key_exists((string) $unidad, $racNaUnidades);

                if (!$racEsNoAplica && !$request->hasFile("rac.{$unidad}") && empty($racActualArchivo)) {
                    $errores["rac.{$unidad}"] = "Debes subir el RAC de la Unidad {$unidad} o marcar No aplica.";
                }
            }

            if (!empty($errores)) {
                return back()
                    ->withErrors($errores)
                    ->withInput();
            }

            foreach ($unidadesReales as $index => $unidad) {
                $keyUnidad = "u{$unidad}";

                $calificacionActual = $datosActuales['documentos']['calificaciones_detalladas'][$keyUnidad] ?? null;
                $calificacionActualArchivo = $obtenerArchivo($calificacionActual);

                if ($request->hasFile("calificaciones.{$unidad}")) {
                    $eliminarArchivo($calificacionActual);

                    $calificacionActualArchivo = $request->file("calificaciones.{$unidad}")->storeAs(
                        $basePath . '/documentos',
                        "calificaciones_u{$unidad}.pdf",
                        'public'
                    );
                }

                $datosActuales['documentos']['calificaciones_detalladas'][$keyUnidad] = [
                    'na' => false,
                    'archivo' => $calificacionActualArchivo,
                ];

                if ($index === 0) {
                    $datosActuales['documentos']['calificaciones'] = [
                        'na' => false,
                        'archivo' => $calificacionActualArchivo,
                    ];
                }

                $racActual = $datosActuales['documentos']['rac_detallado'][$keyUnidad] ?? null;
                $racActualArchivo = $obtenerArchivo($racActual);

                $racEsNoAplica = array_key_exists($unidad, $racNaUnidades)
                    || array_key_exists((string) $unidad, $racNaUnidades);

                if ($racEsNoAplica) {
                    $eliminarArchivo($racActual);

                    $datosActuales['documentos']['rac_detallado'][$keyUnidad] = [
                        'na' => true,
                        'archivo' => null,
                    ];

                    if ($index === 0) {
                        $datosActuales['documentos']['rac'] = [
                            'na' => true,
                            'archivo' => null,
                        ];
                    }
                } else {
                    if ($request->hasFile("rac.{$unidad}")) {
                        $eliminarArchivo($racActual);

                        $racActualArchivo = $request->file("rac.{$unidad}")->storeAs(
                            $basePath . '/documentos',
                            "RAC_u{$unidad}.pdf",
                            'public'
                        );
                    }

                    $datosActuales['documentos']['rac_detallado'][$keyUnidad] = [
                        'na' => false,
                        'archivo' => $racActualArchivo,
                    ];

                    if ($index === 0) {
                        $datosActuales['documentos']['rac'] = [
                            'na' => false,
                            'archivo' => $racActualArchivo,
                        ];
                    }
                }

                $rubricaActual = $datosActuales['evidencias']['rubricas_detalladas'][$keyUnidad] ?? null;
                $rubricaActualArchivo = $obtenerArchivo($rubricaActual);

                if ($request->hasFile("rubricas.{$unidad}")) {
                    $eliminarArchivo($rubricaActual);

                    $rubricaActualArchivo = $request->file("rubricas.{$unidad}")->storeAs(
                        $basePath . '/evidencias',
                        "rubricas_u{$unidad}.pdf",
                        'public'
                    );
                }

                $datosActuales['evidencias']['rubricas_detalladas'][$keyUnidad] = [
                    'na' => false,
                    'archivo' => $rubricaActualArchivo,
                ];

                if ($index === 0) {
                    $datosActuales['evidencias']['rubricas'] = [
                        'na' => false,
                        'archivo' => $rubricaActualArchivo,
                    ];
                }
            }

            if ($request->has('eliminar_instrumentos')) {
                foreach ($request->eliminar_instrumentos as $unidad => $rutas) {
                    foreach ($rutas as $ruta) {
                        Storage::disk('public')->delete($ruta);

                        $datosActuales['instrumentos'] = array_values(array_filter(
                            $datosActuales['instrumentos'] ?? [],
                            function ($item) use ($ruta) {
                                return $item !== $ruta;
                            }
                        ));
                    }
                }
            }

            if ($request->hasFile('instrumentos')) {
                foreach ($request->file('instrumentos') as $unidad => $archivos) {
                    $unidad = (int) $unidad;

                    if (!in_array($unidad, $unidadesReales, true)) {
                        continue;
                    }

                    $existentesUnidad = array_filter(
                        $datosActuales['instrumentos'] ?? [],
                        function ($path) use ($unidad) {
                            return is_string($path) && strpos($path, "instrumento_u{$unidad}_") !== false;
                        }
                    );

                    $numerosUsados = [];

                    foreach ($existentesUnidad as $pathExistente) {
                        if (preg_match("/instrumento_u{$unidad}_(\d+)\.pdf$/", $pathExistente, $matches)) {
                            $numerosUsados[] = (int) $matches[1];
                        }
                    }

                    foreach ($archivos as $file) {
                        $numeroDisponible = null;

                        for ($n = 1; $n <= 3; $n++) {
                            if (!in_array($n, $numerosUsados, true)) {
                                $numeroDisponible = $n;
                                break;
                            }
                        }

                        if ($numeroDisponible === null) {
                            break;
                        }

                        $nombre = "instrumento_u{$unidad}_{$numeroDisponible}.pdf";

                        $path = $file->storeAs(
                            $basePath . '/instrumentos',
                            $nombre,
                            'public'
                        );

                        $datosActuales['instrumentos'][] = $path;
                        $numerosUsados[] = $numeroDisponible;
                    }
                }
            }
        }

        $evidencia->documentos = $datosActuales;
        $evidencia->save();

        return redirect()
            ->route('evidencias')
            ->with('success', 'Evidencia actualizada correctamente');
    }

    private function limpiarNombre($texto)
    {
        $texto = trim($texto);
        $texto = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '', $texto);
        return str_replace(' ', '_', $texto);
    }

    private function tieneCalificacionAprobatoria(Evidencia $evidencia): bool
    {
        $evaluaciones = $evidencia->evaluacion ?? [];

        foreach ($evaluaciones as $evaluacion) {
            if (
                !($evaluacion['na'] ?? false) &&
                isset($evaluacion['calificacion']) &&
                (float)$evaluacion['calificacion'] >= 70
            ) {
                return true;
            }
        }

        return false;
    }

    public function destroy($id, $force = false)
    {
        $evidencia = Evidencia::findOrFail($id);

        $estadoActual = strtolower((string) ($evidencia->estado ?? ''));

        if (!$force && in_array($estadoActual, ['2', 'aprobado', 'aprobada'], true)) {
            return redirect()
                ->route('evidencias')
                ->with('error', 'La evidencia ya fue aprobada y no puede eliminarse.');
        }

        $esRechazada = in_array($estadoActual, ['4', 'rechazado', 'rechazada'], true);

        $datos = is_array($evidencia->documentos)
            ? $evidencia->documentos
            : json_decode($evidencia->documentos ?? '{}', true);

        $eliminarArchivos = function ($item) use (&$eliminarArchivos) {
            if (is_string($item) && !empty($item)) {
                Storage::disk('public')->delete($item);
                return;
            }

            if (is_array($item)) {
                if (isset($item['archivo']) && !empty($item['archivo'])) {
                    Storage::disk('public')->delete($item['archivo']);
                }

                foreach ($item as $valor) {
                    $eliminarArchivos($valor);
                }
            }
        };

        $eliminarArchivos($datos);
        $evidencia->delete();

        // Redirección según el rol o el flag force
        if ($force) {
            // Admin: redirige al seguimiento académico
            return redirect()
                ->route('seguimiento-academico')
                ->with('success', 'La evidencia (incluyendo aprobadas) fue eliminada permanentemente.');
        }

        // Docente: redirige a su lista de evidencias
        $mensaje = $esRechazada
            ? 'La evidencia rechazada fue eliminada correctamente. Ya puedes subir una nueva versión corregida.'
            : 'La evidencia y todos sus archivos fueron eliminados correctamente.';

        return redirect()
            ->route('evidencias')
            ->with('success', $mensaje);
    }

    public function rechazarSinEvidencia(Request $request)
    {
        $asignacionMateriaId = $request->asignacion_materia_id;
        $materiaId = $request->materia_id;
        $revisionId = $request->revision_id;

        $revision = Revision::findOrFail($revisionId);

        // Obtener los datos de evaluación de seguimiento enviados desde el Swal
        $avanceProgramatico = $request->input('evaluaciones.avance_programatico', []);
        $asisteSeguimiento = $request->input('evaluaciones.asiste_seguimiento', []);

        // Construir la estructura base de evaluación (según lógica original)
        $evaluacion = [];

        if ((int)$revision->numero === 1) {
            $evaluacion = [
                'instrumentacion' => [
                    'calificacion' => 0,
                    'observaciones' => 'No se entregó evidencia',
                ],
                'reporte_inicio' => [
                    'calificacion' => 0,
                    'observaciones' => 'No se entregó evidencia',
                ],
                'examen_diagnostico' => [
                    'calificacion' => 0,
                    'observaciones' => 'No se entregó evidencia',
                ],
                'analisis_diagnostico' => [
                    'calificacion' => 0,
                    'observaciones' => 'No se entregó evidencia',
                ],
                'acuerdos' => [
                    'calificacion' => 0,
                    'observaciones' => 'No se entregó evidencia',
                ],
                'calificaciones' => [
                    'calificacion' => 0,
                    'observaciones' => 'No se entregó evidencia',
                ],
                'rac' => [
                    'calificacion' => 0,
                    'observaciones' => 'No se entregó evidencia',
                ],
                'rubricas' => [
                    'calificacion' => 0,
                    'observaciones' => 'No se entregó evidencia',
                ],
                'instrumentos' => [
                    'calificacion' => 0,
                    'observaciones' => 'No se entregó evidencia',
                ],
            ];
        } else {
            $revision1 = Revision::where('numero', 1)->first();
            $evaluacionRevision1 = [];

            if ($revision1) {
                $evidenciaRev1 = Evidencia::where('asignacion_materia_id', $asignacionMateriaId)
                    ->where('revision_id', $revision1->id)
                    ->first();
                $evaluacionRevision1 = $evidenciaRev1?->evaluacion ?? [];
            }

            $camposAuto = [
                'instrumentacion',
                'reporte_inicio',
                'acuerdos',
                'examen_diagnostico',
                'analisis_diagnostico'
            ];

            foreach ($camposAuto as $campo) {
                $evaluacion[$campo] = $evaluacionRevision1[$campo] ?? [
                    'calificacion' => 0,
                    'observaciones' => 'No existe evaluación en revisión 1'
                ];
            }

            $evaluacion['calificaciones'] = [
                'calificacion' => 0,
                'observaciones' => 'No se entregó evidencia',
            ];
            $evaluacion['rac'] = [
                'calificacion' => 0,
                'observaciones' => 'No se entregó evidencia',
            ];
            $evaluacion['rubricas'] = [
                'calificacion' => 0,
                'observaciones' => 'No se entregó evidencia',
            ];
            $evaluacion['instrumentos'] = [
                'calificacion' => 0,
                'observaciones' => 'No se entregó evidencia',
            ];
        }

        // Agregar los dos campos de seguimiento (si vienen del frontend)
        $evaluacion['avance_programatico'] = [
            'calificacion' => $avanceProgramatico['calificacion'] ?? '',
            'observaciones' => $avanceProgramatico['observaciones'] ?? '',
            'na' => $avanceProgramatico['na'] ?? 0,
        ];

        $evaluacion['asiste_seguimiento'] = [
            'calificacion' => $asisteSeguimiento['calificacion'] ?? '',
            'observaciones' => $asisteSeguimiento['observaciones'] ?? '',
            'na' => $asisteSeguimiento['na'] ?? 0,
        ];

        // Crear la evidencia con estado 4 (rechazada)
        Evidencia::create([
            'asignacion_materia_id' => $asignacionMateriaId,
            'materia_id' => $materiaId,
            'revision_id' => $revisionId,
            'estado' => 4,
            'documentos' => [],
            'evaluacion' => $evaluacion,
            'observaciones' => 'No se entregó evidencia',
            'admin_id' => Auth::id(),
            'fecha_revision' => now(),
        ]);

        return response()->json(['success' => true]);
    }
}
