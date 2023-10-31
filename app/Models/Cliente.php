<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $table = 'clientes';

    public static function saveData($data)
    {
        return Cliente::create($data);
    }

    public static function updateData($data)
    {
        $cliente = Cliente::find($data['id']);
        $cliente->identificacion = $data['identificacion'];
        $cliente->nombres = $data['nombres'];
        $cliente->apellidos = $data['apellidos'];
        $cliente->telefono = $data['telefono'];
        $cliente->direccion_domicilio = $data['direccion_domicilio'];
        $cliente->save();
        return $cliente;
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
