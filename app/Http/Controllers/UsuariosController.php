<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Carbon\Carbon;

class UsuariosController extends Controller
{
    public function listData(Request $request)
    {
        $usuario = Usuario::join('roles', 'users.rol_id', '=', 'roles.id')
            ->select(
                'users.id as usuario_id',
                'roles.id as rol_id',
                'users.name',
                'users.apellidos',
                'users.email',
                'users.telefono',
                'roles.name as rol',
            )
            ->get();
        return response()->json([
            'status' => 200,
            'mensaje' => 'Usuarios listados con exito',
            'usuarios' => $usuario
        ], 200);
    }

    public function saveOrUpdateData(Request $request)
    {
        DB::beginTransaction();
        $mensaje = '';

        if ($request->usuario_id) {
            $usuario = Usuario::updateData([
                'id' => $request->usuario_id,
                'name' => $request->name,
                'apellidos' => $request->apellidos,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'password' => $request->password,
                'rol_id' => $request->rol_id
            ]);
            $mensaje = 'Usuario actualizado con exito';
        } else {
            $usuario = Usuario::saveData([
                'name' => $request->name,
                'apellidos' => $request->apellidos,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'password' => $request->password,
                'rol_id' => $request->rol_id,
                'activo' => '1',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ]);
            $mensaje = 'Usuario creado con exito';
        }
        DB::commit();
        return response()->json([
            'status' => 200,
            'mensaje' => $mensaje,
            'usuario' => $usuario
        ], 200);
    }
}
