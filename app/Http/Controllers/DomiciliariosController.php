<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Domiciliario;
use App\Models\User;


class DomiciliariosController extends Controller
{
    public function listData(Request $request)
    {
        $domiciliario = User::where('rol_id', 2)
            ->select(
                'users.id',
                'users.name as nombres',
                'users.apellidos',
                'users.telefono',
            )
            ->get();
        return response()->json([
            'status' => 200,
            'mensaje' => 'Domiciliarios listados con exito',
            'domiciliarios' => $domiciliario
        ], 200);
    }

    public function saveOrUpdateData(Request $request)
    {
        DB::beginTransaction();
        $mensaje = '';

        if ($request->id) {
            $domiciliario = Domiciliario::updateData([
                'id' => $request->id,
                'identificacion' => $request->identificacion,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'telefono' => $request->telefono,
            ]);
            $mensaje = 'domiciliario actualizado con exito';
        } else {
            $domiciliario = Domiciliario::saveData([
                'identificacion' => $request->identificacion,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'telefono' => $request->telefono,
            ]);
            $mensaje = 'domiciliario creado con exito';
        }
        DB::commit();
        return response()->json([
            'status' => 200,
            'mensaje' => $mensaje,
            'domiciliario' => $domiciliario
        ], 200);
    }
}
