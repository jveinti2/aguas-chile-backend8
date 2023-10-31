<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edificio extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $table = 'edificios';

    public static function saveData($data)
    {
        return Edificio::create($data);
    }

    public static function updateData($data)
    {
        $edificio = Edificio::find($data['id']);
        $edificio->nombre = $data['nombre'];
        $edificio->direccion = $data['direccion'];
        $edificio->telefono = $data['telefono'];
        $edificio->responsable = $data['responsable'];
        $edificio->save();
        return $edificio;
    }

    public static function switchOffData($data)
    {
        $edificio = Edificio::find($data['id']);
        $edificio->estado = 0;
        $edificio->save();
        return $edificio;
    }
};
