<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\ModuloEdificio;

class ModulosController extends Controller
{
    public function listData(Request $request)
    {
        $mensaje = 'Edificios listados con exito';
        $edificios = Edificio::join('modulos_edificios', 'modulos_edificios.edificio_id', '=', 'edificios.id')
            ->select(
                'edificios.*',
                DB::raw('count(modulos_edificios.id) as cantidad_modulos'),
                DB::raw('sum(modulos_edificios.cantidad_bidones) as cantidad_bidones')
            )
            ->groupBy('edificios.id')
            ->where('edificios.estado', 1)
            ->get();
        return response()->json([
            'status' => 200,
            'mensaje' => $mensaje,
            'edificios' => $edificios
        ], 200);
    }

    public function listDataById(Request $request)
    {
        $mensaje = '';
        $modulos = ModuloEdificio::where('edificio_id', $request->id_edificio)
            ->where('estado', 1)
            ->get();
        return response()->json([
            'status' => 200,
            'mensaje' => $mensaje,
            'modulos' => $modulos,
        ], 200);
    }

    public function saveOrUpdateData(Request $request)
    {
        $mensaje = '';
        if ($request->edificioId) {
            $maxModuloId = ModuloEdificio::max('modulo_id');
            $nextModuloId = $maxModuloId + 1;

            $modulo_edificio = ModuloEdificio::saveData([
                'id' => $request->id,
                'nombre' => $request->nombre,
                'edificio_id' => $request->edificioId,
                'modulo_id' => $nextModuloId,
                'capacidad_bidones' => $request->capacidad_bidones,
                'cantidad_bidones' => 2,
                'password' => $request->password,
                'estado' => 1
            ]);
            $mensaje = 'Modulo creado con exito';
        }
        return response()->json([
            'status' => 200,
            'mensaje' => $mensaje,
            'modulo_edificio' => $modulo_edificio
        ], 200);
    }

    public function updatePassword(Request $request)
    {
        $mensaje = '';
        $modulo_edificio = ModuloEdificio::updatePassword([
            'edificio_id' => $request->edificio_id,
            'modulo' => $request->modulo,
            'password' => $request->password,
            'bidones' => $request->bidones
        ]);
        $mensaje = 'Modulo actualizado con exito';
        return response()->json([
            'status' => 200,
            'mensaje' => $mensaje,
            'modulo_edificio' => $modulo_edificio,
        ], 200);
    }
}
