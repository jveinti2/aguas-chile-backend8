<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domiciliario extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $table = 'domiciliarios';

    public static function saveData($data)
    {
        return Domiciliario::create($data);
    }

    public static function updateData($data)
    {
        $venta = Domiciliario::find($data['id']);
        $venta->cliente_id = $data['cliente_id'];
        $venta->edificio_id = $data['edificio_id'];
        $venta->cantidad_bidones = $data['cantidad_bidones'];
        $venta->domicilio = $data['domicilio'];
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
