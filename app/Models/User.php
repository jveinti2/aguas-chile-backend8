<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class User extends Authenticatable implements JWTSubject
{
    // use HasFactory;
    // protected $guarded = [];
    // public $incrementing = false;
    // public $timestamps = false;
    // protected $table = 'users';


    use HasFactory, Notifiable, HasRoles;
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'tercero_id',
        'fecha_ultimo_ingreso',
        'activo'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    // public static function autenticate($email, $password)
    // {
    //     $user = User::join('roles', 'roles.id', '=', 'users.rol_id')
    //         ->where('users.email', $email)
    //         ->select('users.*', 'roles.nombre as rol_nombre')
    //         ->first();

    //     if ($user) {
    //         if (password_verify($password, $user->password)) {
    //             return $user;
    //         }
    //     }
    //     return false;
    // }
    public static function actualizarUltimoAcceso($email)
    {
        $user = User::where('email', $email)->first();
        $user->fecha_ultimo_ingreso = Carbon::now();
        $user->save();
        return $user;
    }
    public static function createUser($data, $password = null)
    {
        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%&');
        $data['password'] = Hash::make($password == null ? substr($random, 0, 10) : $password);
        $data['fecha_registro'] = Carbon::now();
        $user_created = User::create($data);
        return $user_created;
    }
}
