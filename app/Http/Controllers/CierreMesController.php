<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Gasto;
use Carbon\Carbon;

class CierreMesController extends Controller
{
    public function listData(Request $request)
    {
        $mensaje = 'Ventas y gastos listados con éxito';

        // Obtén el año y mes de la fecha proporcionada en el formato "AAAA-MM"
        $yearAndMonth = Carbon::parse($request->fh_creacion)->format('Y-m');

        $venta = Venta::join('productos', 'ventas.producto_id', '=', 'productos.id')
            ->whereYear('ventas.fh_creacion', '=', Carbon::parse($request->fh_creacion)->format('Y'))
            ->whereMonth('ventas.fh_creacion', '=', Carbon::parse($request->fh_creacion)->format('m'))
            ->select(
                'ventas.id as venta_id',
                'ventas.producto_id',
                'ventas.cantidad_bidones',
                'productos.precio',
                'ventas.fh_creacion',
                'ventas.fh_modificacion',
                'ventas.domicilio',
            )
            ->get();

        $gastos = Gasto::whereYear('fh_creacion', '=', Carbon::parse($request->fh_creacion)->format('Y'))
            ->whereMonth('fh_creacion', '=', Carbon::parse($request->fh_creacion)->format('m'))
            ->get();

        return response()->json([
            'status' => 200,
            'mensaje' => $mensaje,
            'ventas' => $venta,
            'gastos' => $gastos
        ], 200);
    }


    // public function saveOrUpdateData(Request $request)
    // {
    //     DB::beginTransaction();
    //     $mensaje = '';

    //     if ($request->venta_id) {

    //         $venta = Venta::updateData([
    //             'venta_id' => $request->venta_id
    //         ]);

    //         $mensaje = 'Domicilio actualizado con exito';
    //     } else {
    //         $venta = Venta::saveData([
    //             'cliente_id' => $request->cliente,
    //             'edificio_id' => $request->edificio,
    //             'producto_id' => $request->producto,
    //             'cantidad_bidones' => $request->cantidad_bidones,
    //             'domicilio' => $request->domicilio,
    //             'domiciliario_id' => $request->domiciliario,
    //             'estado_domicilio' => 2,
    //             'forma_pago_id' => $request->forma_pago,
    //             'fh_creacion' => Carbon::now(),
    //         ]);
    //         $mensaje = 'Venta creada con exito';
    //     }
    //     DB::commit();
    //     return response()->json([
    //         'status' => 200,
    //         'mensaje' => $mensaje,
    //         'venta' => $venta
    //     ], 200);
    // }
}
