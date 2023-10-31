<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Producto;

class ProductosController extends Controller
{
    public function listData(Request $request)
    {
        $mensaje = 'Producto listados con exito';
        $producto = Producto::all();
        return response()->json([
            'status' => 200,
            'mensaje' => $mensaje,
            'productos' => $producto
        ], 200);
    }

    public function saveOrUpdateData(Request $request)
    {
        DB::beginTransaction();
        $mensaje = '';

        if ($request->id) {
            $producto = Producto::updateData([
                'id' => $request->id,
                'referencia' => $request->referencia,
                'nombre' => $request->nombre,
                'precio' => $request->precio,
                'cantidad_inventario' => $request->cantidad_inventario,
            ]);
            $mensaje = 'Producto actualizado con exito';
        } else {
            $producto = Producto::saveData([
                'referencia' => $request->referencia,
                'nombre' => $request->nombre,
                'precio' => $request->precio,
                'cantidad_inventario' => $request->cantidad_inventario,
            ]);
            $mensaje = 'Producto creado con exito';
        }
        DB::commit();
        return response()->json([
            'status' => 200,
            'mensaje' => $mensaje,
            'producto' => $producto
        ], 200);
    }
}
