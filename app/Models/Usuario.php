<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $table = 'users';

    public static function saveData($data)
    {
        $data['password'] = bcrypt($data['password']);
        return Usuario::create($data);
    }

    public static function updateData($data)
    {
        $usuario = Usuario::find($data['id']);
        $usuario->name = $data['name'];
        $usuario->apellidos = $data['apellidos'];
        $usuario->email = $data['email'];
        $usuario->telefono = $data['telefono'];
        $usuario->rol_id = $data['rol_id'];

        if ($data['password'] != '' && $data['password'] != null) {
            $usuario->password = bcrypt($data['password']);
        }

        $usuario->save();
        return $usuario;
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
