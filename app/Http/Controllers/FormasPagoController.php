<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\FormaPago;

class FormasPagoController extends Controller
{
    public function listData(Request $request)
    {
        $formas_pago = FormaPago::all();
        return response()->json([
            'status' => 200,
            'mensaje' => 'Domiciliarios listados con exito',
            'formas_pago' => $formas_pago
        ], 200);
    }
}
