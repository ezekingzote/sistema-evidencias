<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $query = User::where('rol', 'docente');

        return DataTables::of($query)

            ->addColumn('nombre', function ($row) {
                return strtoupper($row->name);
            })

            ->addColumn('password_btn', function ($row) {
                return '<button class="btn btn-outline-secondary btn-sm reset-btn" data-id="' . $row->id . '">
                        <i class="fa-solid fa-user-lock"></i>
                    </button>';
            })

            ->addColumn('activo_switch', function ($row) {
                $checked = $row->activo ? 'checked' : '';

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

            ->editColumn('rol', function ($row) {
                if ($row->rol === 'admin') {
                    return '<span class="badge bg-danger">ADMIN</span>';
                }

                return '<span class="badge bg-info text-dark">DOCENTE</span>';
            })

            ->rawColumns(['rol', 'password_btn', 'activo_switch', 'editar_btn'])
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


            $emailBase = strtolower(trim($request->email));
            $dominio = ($request->rol == 'admin') ? '@admin.com' : '@docente.com';
            $emailCompleto = $emailBase . $dominio;


            if (User::where('email', $emailCompleto)->exists()) {
                return back()->withInput()->with('error', 'El correo ya existe.');
            }


            $partes = explode(' ', strtolower($nombreCompleto));
            $nombreFormateado = '';
            foreach ($partes as $p) {
                $nombreFormateado .= ucfirst($p);
            }
            $passwordTemporal = "Sistema" . $nombreFormateado;


            $user = new User();
            $user->name = $nombreCompleto;
            $user->email = $emailCompleto;
            $user->password = Hash::make($passwordTemporal);
            $user->rol = $request->rol;
            $user->activo = 1;
            $user->save();

            $urlPdf = route('pdf.descargar', [
                'nombre' => (string)$nombreCompleto,
                'email'  => (string)$emailCompleto,
                'pass'   => (string)$passwordTemporal
            ]);


            return redirect()->route('docentes')
                ->with('success', 'Usuario guardado con éxito!')
                ->with('pdf', $urlPdf);
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
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
        $item = User::find($id);
        return view('modules.docentes.edit', compact('item', 'titulo'));
    }

    public function update(Request $request, string $id)
    {
        try {

            $item = User::find($id);

            if (!$item) {
                return to_route('docentes')->with('error', 'Usuario no encontrado');
            }

            $nombre = strtoupper($request->name);
            $apellidoP = strtoupper($request->apellido_p);
            $apellidoM = strtoupper($request->apellido_m);

            $nombreCompleto = trim("$nombre $apellidoP $apellidoM");

            $email = strtolower(trim($request->email));

            $dominio = $request->rol == 'admin'
                ? '@admin.com'
                : '@docente.com';

            $emailCompleto = $email . $dominio;

            $existeEmail = User::where('email', $emailCompleto)
                ->where('id', '!=', $id)
                ->exists();

            if ($existeEmail) {

                return to_route('docentes.edit', $id)
                    ->with('error', 'El correo ya está registrado');
            }

            $item->name = $nombreCompleto;
            $item->email = $emailCompleto;
            $item->rol = $request->rol;

            $item->save();

            return to_route('docentes')
                ->with('success', 'Usuario actualizado correctamente');
        } catch (Exception $e) {

            return to_route('docentes')
                ->with('error', 'No se pudo actualizar: ' . $e->getMessage());
        }
    }
}
