<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Edificio;
use App\Models\ModuloEdificio;

class EdificiosController extends Controller
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

        foreach ($edificios as $edificio) {
            $edificio->modulos = ModuloEdificio::where('edificio_id', $edificio->id)->get();
        }

        return response()->json([
            'status' => 200,
            'mensaje' => $mensaje,
            'edificios' => $edificios
        ], 200);
    }

    public function saveOrUpdateData(Request $request)
    {
        DB::beginTransaction();
        $mensaje = '';
        if ($request->id) {
            $edificio = Edificio::updateData([
                'id' => $request->id,
                'nombre' => $request->nombre,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'responsable' => $request->responsable
            ]);
            $mensaje = 'Edificio actualizado con exito';
        } else {
            $edificio = Edificio::saveData([
                'nombre' => $request->nombre,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'responsable' => $request->responsable
            ]);

            ModuloEdificio::saveData([
                'modulo_id' => 1,
                'nombre' => 'Modulo' . $edificio->id,
                'edificio_id' => $edificio->id,
                'capacidad_bidones' => 1,
                'cantidad_bidones' => 0
            ]);

            $mensaje = 'Edificio creado con exito';
        }

        DB::commit();
        return response()->json([
            'status' => 200,
            'mensaje' => $mensaje,
            'edificio' => $edificio
        ], 200);
    }

    public static function switchOffData(Request $request)
    {
        DB::beginTransaction();
        $mensaje = '';
        $edificio = Edificio::switchOffData([
            'id' => $request->id
        ]);
        $mensaje = 'Edificio anulado con exito';
        DB::commit();
        return response()->json([
            'status' => 200,
            'mensaje' => $mensaje,
            'edificio' => $edificio
        ], 200);
    }
}
