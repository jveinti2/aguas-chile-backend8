<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use App\Models\User;
use App\Models\FormaPago;
use App\Models\Producto;


use Illuminate\Support\Facades\Hash;

class FirstDataSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'rol_id' => 1,
                'name' => 'Administrador',
                'email' => 'admin@aguas.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('admin'),
                'activo' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'rol_id' => 2,
                'name' => 'Domiciliario',
                'email' => 'domiciliario@aguas.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('admin'),
                'activo' => 1,
                'created_at' => Carbon::now()
            ],
        ];

        $roles = [
            [
                'name' => 'Administrador',
                'guard_name' => 'web',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Domiciliario',
                'guard_name' => 'web',
                'created_at' => Carbon::now()
            ]
        ];

        $model_has_roles = [
            [
                'role_id' => 1,
                'model_type' => 'App\Models\User',
                'model_id' => 1
            ],
            [
                'role_id' => 2,
                'model_type' => 'App\Models\User',
                'model_id' => 2
            ]
        ];

        $forma_pago = [
            [
                'nombre' => 'Efectivo',
                'descripcion' => 'Pago en efectivo',
                'created_at' => Carbon::now()
            ],
            [
                'nombre' => 'Transferencia',
                'descripcion' => 'Pago en transferencia bancaria',
                'created_at' => Carbon::now()
            ]
        ];

        $producto = [
            [
                'referencia' => 'BIDON-1',
                'nombre' => 'Bidón 1 litro',
                'precio' => 10000,
                'cantidad_inventario' => 10000,
                'created_at' => Carbon::now()
            ]
        ];


        User::insert($users);
        DB::table('roles')->insert($roles);
        DB::table('model_has_roles')->insert($model_has_roles);
        Producto::insert($producto);
        FormaPago::insert($forma_pago);
    }
}
