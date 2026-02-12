<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Docentes extends Controller
{
    public function index()
    {
        $titulo = 'Docentes';
        $items = User::all();

        return view('modules.docentes.index', compact('titulo', 'items'));
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
            $dominio = $request->rol == 'admin' ? '@admin.com' : '@docente.com';
            $emailCompleto = $emailBase . $dominio;

            $nombrePartes = explode(' ', $nombreCompleto);

            $nombreFormateado = '';
            foreach ($nombrePartes as $parte) {
                $nombreFormateado .= ucfirst(strtolower($parte));
            }

            $password = "Sistema" . $nombreFormateado;


            if (User::where('email', $emailCompleto)->exists()) {

                return back()
                    ->withInput()
                    ->with('error', 'El correo ya existe. No se puede registrar.');
            }


            $usuarios = User::all();

            foreach ($usuarios as $usuario) {

                if (Hash::check($password, $usuario->password)) {

                    return back()
                        ->withInput()
                        ->with('error', 'La contraseña generada ya existe. No se puede registrar.');
                }
            }


            $user = new User();
            $user->name = $nombreCompleto;
            $user->email = $emailCompleto;
            $user->password = Hash::make($password);
            $user->rol = $request->rol;
            $user->activo = 1;

            $user->save();

            return to_route('docentes')->with('success', 'Usuario guardado con éxito!');
        } catch (Exception $e) {

            return back()
                ->withInput()
                ->with('error', 'Error al guardar usuario');
        }
    }

    public function resetPassword(Request $request, $id)
    {
        try {
            $admin = Auth::user();

            if (!Hash::check($request->password, $admin->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Contraseña incorrecta'
                ]);
            }

            $user = User::findOrFail($id);

            $nombre = explode(' ', strtolower($user->name));
            $nombreFormateado = '';

            foreach ($nombre as $n) {
                $nombreFormateado .= ucfirst($n);
            }

            $nuevaPassword = "Sistema" . $nombreFormateado;

            $user->password = Hash::make($nuevaPassword);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Contraseña restablecida correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error del servidor'
            ]);
        }
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
