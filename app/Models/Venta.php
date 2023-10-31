<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $table = 'ventas';

    public static function saveData($data)
    {
        return Venta::create($data);
    }

    public static function updateData($data)
    {
        $venta = Venta::find($data['venta_id']);
        $venta->estado_domicilio = $data['estado_domicilio'];
        $venta->forma_pago_id = $data['forma_pago_id'];
        $venta->save();
        return $venta;
    }

    // public static function updateData($data)
    // {
    //     $edificio = Edificio::find($data['id']);
    //     $edificio->nombre = $data['nombre'];
    //     $edificio->direccion = $data['direccion'];
    //     $edificio->telefono = $data['telefono'];
    //     $edificio->responsable = $data['responsable'];
    //     $edificio->save();
    //     return $edificio;
    // }

    // public static function switchOffData($data)
    // {
    //     $edificio = Edificio::find($data['id']);
    //     $edificio->estado = 0;
    //     $edificio->save();
    //     return $edificio;
    // }
};
