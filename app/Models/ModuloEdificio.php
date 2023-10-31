<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ModuloEdificio extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $table = 'modulos_edificios';

    public static function saveData($data)
    {
        return ModuloEdificio::create($data);
    }

    public static function updatePassword($data)
    {
        $modulo_edificio = ModuloEdificio::where('edificio_id', $data['edificio_id'])
            ->where('id', $data['modulo'])
            ->first();
        $modulo_edificio->password = $data['password'];
        $modulo_edificio->updated_at = Carbon::now();



        if ($data['bidones'] !== null && $data['bidones'] !== '') {
            $modulo_edificio->cantidad_bidones += $data['bidones'];
        }

        $modulo_edificio->save();

        return $modulo_edificio;
    }
};
