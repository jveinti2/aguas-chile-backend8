<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\ModuloEdificio;
use App\Models\Producto;
use PDF;
use Illuminate\Support\Facades\File;

use Carbon\Carbon;


class VentasController extends Controller
{
    public function listData(Request $request)
    {


        $mensaje = 'Ventas listadas con exito';
        $venta = Venta::leftJoin('clientes', 'ventas.cliente_id', '=', 'clientes.id')
            ->leftJoin('edificios', 'ventas.edificio_id', '=', 'edificios.id')
            ->leftJoin('productos', 'ventas.producto_id', '=', 'productos.id')
            ->leftJoin('tipos_estados', 'ventas.estado_domicilio', '=', 'tipos_estados.id')
            ->leftJoin('users', 'ventas.domiciliario_id', '=', 'users.id')
            ->LeftJoin('formas_pago', 'ventas.forma_pago_id', '=', 'formas_pago.id')
            ->whereDate(
                'ventas.fh_creacion',
                '=',
                Carbon::parse($request->fh_creacion)->format('Y-m-d')
            )
            ->select(
                'ventas.id as venta_id',
                'ventas.cliente_id',
                'ventas.edificio_id',
                'ventas.producto_id',
                'ventas.cantidad_bidones',
                'ventas.domicilio',
                'ventas.fh_creacion',
                'ventas.fh_modificacion',
                'ventas.estado_domicilio',
                'ventas.pdf',
                'ventas.direccion_domicilio',
                'tipos_estados.nombre as estado_domicilio_nombre',
                'clientes.identificacion',
                'clientes.nombres as cliente_nombres',
                'clientes.apellidos as cliente_apellidos',
                'clientes.telefono',
                'edificios.nombre as edificio',
                'productos.nombre as producto',
                'productos.precio',
                'users.name as domiciliario_nombres',
                'users.apellidos as domiciliario_apellidos',
                'formas_pago.nombre as forma_pago_nombre',
            )
            ->orderBy('ventas.estado_domicilio', 'desc')
            // ->orWhereNull('ventas.domiciliario_id')
            ->get();
        return response()->json([
            'status' => 200,
            'mensaje' => $mensaje,
            'ventas' => $venta,

        ], 200);
    }

    public function saveOrUpdateData(Request $request)
    {
        DB::beginTransaction();
        $mensaje = '';

        if ($request->venta_id) {

            $venta = Venta::updateData([
                'venta_id' => $request->venta_id,
                'forma_pago_id' => $request->forma_pago,
                'estado_domicilio' => $request->forma_pago == 3 ? 3 : 1,
            ]);
            $mensaje = 'Domicilio actualizado con exito';
        } else {
            $venta = Venta::saveData([
                'modulo' => $request->modulo,
                'cliente_id' => $request->cliente,
                'edificio_id' => $request->edificio,
                'producto_id' => $request->producto,
                'cantidad_bidones' => $request->cantidad_bidones,
                'domicilio' => $request->domicilio,
                'direccion_domicilio' => $request->direccion_domicilio,
                'domiciliario_id' => $request->domiciliario,
                'estado_domicilio' => 2,
                'forma_pago_id' => $request->forma_pago,
                'fh_creacion' => Carbon::now(),
            ]);

            if (!$request->domicilio) {
                $modulo_edificio = ModuloEdificio::find($request->modulo);
                $modulo_edificio->cantidad_bidones = $modulo_edificio->cantidad_bidones - $request->cantidad_bidones;
                $modulo_edificio->save();
            }
            // restarle al inventario del producto si este es id 2
            if ($request->producto == 2) {
                $producto = Producto::find($request->producto);
                $producto->cantidad_inventario = $producto->cantidad_inventario - $request->cantidad_bidones;
                $producto->save();
            }

            $data_pdf = Venta::join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
                ->join('edificios', 'ventas.edificio_id', '=', 'edificios.id')
                ->join('productos', 'ventas.producto_id', '=', 'productos.id')
                ->join('tipos_estados', 'ventas.estado_domicilio', '=', 'tipos_estados.id')
                ->join('modulos_edificios', 'ventas.modulo', '=', 'modulos_edificios.id')
                ->where('ventas.id', '=', $venta->id)
                ->select(
                    'ventas.id as venta_id',
                    'ventas.cliente_id',
                    'ventas.producto_id',
                    'ventas.cantidad_bidones as cantidad_bidones_venta',
                    'ventas.fh_creacion',
                    'clientes.identificacion',
                    'clientes.nombres as cliente_nombres',
                    'clientes.apellidos as cliente_apellidos',
                    'clientes.telefono',
                    'edificios.nombre as edificio_nombre',
                    'edificios.direccion as edificio_direccion',
                    'productos.nombre as producto',
                    'productos.precio as valor_venta',
                    'modulos_edificios.nombre as modulo_nombre',
                    'modulos_edificios.password as modulo_contrasena',
                )
                ->first();

            $pdf = $this->generatePdf($data_pdf);
            $venta->pdf = $pdf;
            $venta->save();
            $mensaje = 'Venta creada con exito';
        }


        DB::commit();
        return response()->json([
            'status' => 200,
            'mensaje' => $mensaje,
            'venta' => $venta,
        ], 200);
    }


    public function generatePdf($data)
    {
        if ($data != null) {
            $data = $data->toArray();
            $pdf = \PDF::loadView('pdf', compact('data'));
            $pdfContent = $pdf->output();

            $pdfPath = storage_path('app/pdfs'); // Define la ubicación donde deseas guardar los PDF
            if (!File::exists($pdfPath)) {
                File::makeDirectory($pdfPath, 0755, true);
            }

            $pdfFileName = 'venta_' . $data['venta_id'] . '.pdf'; // Define el nombre del archivo PDF
            $pdfFilePath = $pdfPath . '/' . $pdfFileName;

            file_put_contents($pdfFilePath, $pdfContent); // Guarda el PDF en la ubicación especificada

            // Generar la URL para ver el PDF
            $pdfViewRoute = route('ventas.pdf', ['filename' => $pdfFileName]);

            // hay quye formatear correctamente esto "http:\/\/localhost:8000\/api\/ventas\/pdf\/venta_22.pdf"
            $pdfViewRoute = str_replace('\\', '', $pdfViewRoute);
            return $pdfViewRoute; // Devuelve la URL del archivo PDF en lugar de la ruta del archivo
        }
    }


    public function PruebaPdf()
    {
        $data = [
            'modulo' => 'Modulo 1',
            'cliente' => 'Cliente 1',
            'edificio' => 'Edificio 1',
            'producto' => 'Producto 1',
            'cantidad_bidones' => '1',
            'forma_pago' => 'Efectivo',
        ];
        $pdf = \PDF::loadView('pdf', compact('data'));
        return $pdf->stream();
    }
}
