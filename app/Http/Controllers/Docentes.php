<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class Docentes extends Controller
{
    public function index()
    {
        $titulo = 'Docentes';
        return view('modules.docentes.index', compact('titulo'));
    }

    public function data()
    {
        // 1. Añadimos ->with('docente') para traer ambas tablas en una sola consulta
        $query = User::with('docente')->orderBy('id', 'ASC');

        return DataTables::of($query)

            // Buscamos el celular en la relación docente
            ->editColumn('celular', function ($row) {
                return ($row->docente && $row->docente->celular) ? $row->docente->celular : 'Sin número';
            })

            // Agregamos explícitamente el departamento desde la relación
            ->addColumn('departamento', function ($row) {
                return $row->docente->departamento ?? 'Sin departamento';
            })

            ->addColumn('nombre', function ($row) {
                return strtoupper($row->name);
            })

            ->addColumn('password_btn', function ($row) {
                return '<button class="btn btn-outline-secondary btn-sm reset-btn" data-id="' . $row->id . '">
                        <i class="fa-solid fa-user-lock"></i>
                    </button>';
            })

            // Buscamos el estado activo en la relación docente
            ->addColumn('activo_switch', function ($row) {
                $checked = ($row->docente && $row->docente->activo) ? 'checked' : '';

                return '<div class="form-check form-switch d-flex justify-content-center">
                        <input class="form-check-input cambiar-estado" 
                               type="checkbox" 
                               data-id="' . $row->id . '" 
                               ' . $checked . '>
                    </div>';
            })

            ->addColumn('editar_btn', function ($row) {
                return '<a href="' . route('docentes.edit', $row->id) . '" 
                        class="btn btn-outline-warning btn-sm">
                        <i class="fa-solid fa-user-pen"></i>
                    </a>';
            })

            // Buscamos el cargo en la relación docente
            ->editColumn('cargo', function ($row) {
                $cargo = $row->docente->cargo ?? 'SIN CARGO';

                if ($row->rol === 'admin') {
                    return '<span class="badge bg-danger-subtle text-danger border border-danger">
                    ' . strtoupper($cargo) . '
                </span>';
                }

                return '<span class="badge bg-primary-subtle text-primary border border-primary">
                ' . strtoupper($cargo) . '
            </span>';
            })

            // El rol pertenece a la tabla users, así que se queda igual
            ->editColumn('rol', function ($row) {
                if ($row->rol === 'admin') {
                    return '<span class="badge bg-danger">ADMIN</span>';
                }

                return '<span class="badge bg-info text-dark">DOCENTE</span>';
            })

            ->rawColumns(['cargo', 'rol', 'password_btn', 'activo_switch', 'editar_btn'])
            ->make(true);
    }

    public function create()
    {
        $titulo = 'Crear Docente';

        return view('modules.docentes.create', compact('titulo'));
    }

    public function store(Request $request)
    {
        try {
            $nombre = strtoupper(trim($request->name));
            $apellidoP = strtoupper(trim($request->apellido_p));
            $apellidoM = strtoupper(trim($request->apellido_m));
            $nombreCompleto = "$nombre $apellidoP $apellidoM";
            $email = strtolower(trim($request->email));
            if (User::where('email', $email)->exists()) {
                return back()->withInput()->with('error', 'El correo ya existe en el sistema.');
            }
            $partes = explode(' ', strtolower($nombreCompleto));
            $nombreFormateado = '';
            foreach ($partes as $p) {
                $nombreFormateado .= ucfirst($p);
            }
            $passwordTemporal = "Sistema" . $nombreFormateado;


            DB::transaction(function () use ($request, $nombreCompleto, $email, $passwordTemporal) {


                $user = new User();
                $user->name = $nombreCompleto;
                $user->email = $email;
                $user->password = Hash::make($passwordTemporal);
                $user->rol = $request->rol;
                $user->save();


                $docente = new Docente();
                $docente->user_id = $user->id;
                $docente->celular = $request->celular;
                $docente->departamento = $request->dpto;
                $docente->cargo = ($request->rol == 'admin')
                    ? strtoupper($request->cargo)
                    : 'DOCENTE';
                $docente->activo = 1;
                $docente->save();
            });
            $urlPdf = route('pdf.descargar', [
                'nombre' => (string)$nombreCompleto,
                'email'  => (string)$email,
                'pass'   => (string)$passwordTemporal
            ]);

            return redirect()->route('docentes')
                ->with('success', 'Usuario guardado con éxito!')
                ->with('pdf', $urlPdf);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error al registrar: ' . $e->getMessage());
        }
    }


    public function resetPassword(Request $request, $id)
    {
        try {
            $admin = Auth::user();
            if (!Hash::check($request->password, $admin->password)) {
                return response()->json(['success' => false, 'message' => 'Contraseña de admin incorrecta']);
            }

            $user = User::findOrFail($id);


            $partes = explode(' ', strtolower($user->name));
            $nombreFormateado = '';
            foreach ($partes as $p) {
                $nombreFormateado .= ucfirst($p);
            }
            $nuevaPassword = "Sistema" . $nombreFormateado;

            $user->password = Hash::make($nuevaPassword);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Contraseña restablecida',
                'pdf' => route('pdf.descargar', [
                    'nombre' => $user->name,
                    'email' => $user->email,
                    'pass' => $nuevaPassword
                ])
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function downloadPdf(Request $request)
    {

        $data = [
            'titulo' => 'COMPROBANTE DE CREDENCIALES',
            'nombre' => $request->query('nombre'),
            'email'  => $request->query('email'),
            'pass'   => $request->query('pass'),
            'fecha'  => now()->format('d/m/Y H:i A'),
            'leyenda' => $request->query('leyenda', 'Guarde sus credenciales en un lugar seguro y cambie su contraseña al iniciar sesión.')
        ];

        $pdf = Pdf::loadView('pdfs.comprobante_registro', $data);
        return $pdf->stream("Comprobante_{$request->nombre}.pdf");
    }


    public function tbody()
    {
        $items = User::all();
        return view('modules.docentes.tbody', compact('items'));
    }

    public function estado($id, $estado)
    {
        $user = User::find($id);

        if ($user) {
            $user->activo = $estado;
            $user->save();
            return 1;
        }

        return 0;
    }

    public function edit(string $id)
    {
        $titulo = 'Editar Docente';

        $item = User::with('docente')->findOrFail($id);

        return view('modules.docentes.edit', compact('item', 'titulo'));
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $email = strtolower(trim($request->email));

            if (User::where('email', $email)->where('id', '!=', $id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'El correo ya existe en el sistema.'
                ], 422);
            }

            $nombre = strtoupper(trim($request->name));

            if ($request->filled('apellido_p') || $request->filled('apellido_m')) {
                $apellidoP = strtoupper(trim($request->apellido_p));
                $apellidoM = strtoupper(trim($request->apellido_m));
                $nombreCompleto = trim("$nombre $apellidoP $apellidoM");
            } else {
                $nombreCompleto = $nombre;
            }

            $departamento = $request->input('dpto', $request->input('departamento'));

            DB::transaction(function () use ($request, $user, $nombreCompleto, $email, $departamento) {

                $user->name = $nombreCompleto;
                $user->email = $email;
                $user->rol = $request->rol;
                $user->save();

                $docente = $user->docente;

                if (!$docente) {
                    $docente = new Docente();
                    $docente->user_id = $user->id;
                    $docente->activo = 1;
                }

                $docente->celular = $request->celular;
                $docente->departamento = $departamento;
                $docente->cargo = ($request->rol == 'admin')
                    ? strtoupper($request->cargo)
                    : 'DOCENTE';

                $docente->save();
            });
            return redirect()->route('docentes')
                ->with('success', 'Usuario actualizado con éxito!');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo actualizar: ' . $e->getMessage()
            ], 500);
        }
    }
}
