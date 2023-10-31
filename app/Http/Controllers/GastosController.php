<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Gasto;
use Carbon\Carbon;

class GastosController extends Controller
{
    public function listData(Request $request)
    {
    }

    public function saveOrUpdateData(Request $request)
    {
        DB::beginTransaction();

        $mensaje = '';
        $gasto = Gasto::saveData([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'valor' => $request->valor,
            'fh_creacion' => Carbon::parse($request->fh_creacion)->format('Y-m-d'),
        ]);

        DB::commit();
        return response()->json([
            'status' => 200,
            'mensaje' => $mensaje,
            'gasto' => $gasto
        ], 200);
    }
}
