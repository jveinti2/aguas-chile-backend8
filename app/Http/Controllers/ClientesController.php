<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Cliente;

class ClientesController extends Controller
{
    public function listData(Request $request)
    {
        $mensaje = 'Clientes listados con exito';
        $clientes = Cliente::all();
        return response()->json([
            'status' => 200,
            'mensaje' => $mensaje,
            'clientes' => $clientes
        ], 200);
    }

    public function saveOrUpdateData(Request $request)
    {
        DB::beginTransaction();
        $mensaje = '';

        if ($request->id) {
            $cliente = Cliente::updateData([
                'id' => strtoupper($request->id),
                'identificacion' => strtoupper($request->identificacion),
                'nombres' => strtoupper($request->nombres),
                'apellidos' => strtoupper($request->apellidos),
                'telefono' => strtoupper($request->telefono),
                'direccion_domicilio' => strtoupper($request->direccion_domicilio),
            ]);
            $mensaje = 'Cliente actualizado con exito';
        } else {
            $cliente = Cliente::saveData([
                'identificacion' => strtoupper($request->identificacion),
                'nombres' => strtoupper($request->nombres),
                'apellidos' => strtoupper($request->apellidos),
                'telefono' => strtoupper($request->telefono),
                'direccion_domicilio' => strtoupper($request->direccion_domicilio),
            ]);
            $mensaje = 'Cliente creado con exito';
        }
        DB::commit();
        return response()->json([
            'status' => 200,
            'mensaje' => $mensaje,
            'cliente' => $cliente
        ], 200);
    }
}
