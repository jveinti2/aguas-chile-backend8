<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;



class AuthApiController extends Controller
{

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['activo'] = true;
        $token = JWTAuth::attempt($credentials, Carbon::now()->addDays(7)->timestamp);
        try {
            if (!$token) {
                return response()->json([
                    'response' => 500,
                    'message' => 'Credenciales no válidas'
                ], 500);
            }
        } catch (JWTException $e) {
            return response()->json([
                'response' => 500,
                'message' => 'Error al acceder con las credenciales'
            ], 500);
        }
        User::actualizarUltimoAcceso($request->email);
        $user = \Auth::user();
        return response()->json([
            'response' => 200,
            'message' => 'Ingreso exitoso',
            'data' => [
                'token' => $token,
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' =>  $user->rol_id,
            ]
        ], 200);


        // $email = $request->input('email');
        // $password = $request->input('password');

        // $user = User::autenticate($email, $password);
        // if ($user) {
        //     // El usuario se autenticó con éxito, puedes generar un token JWT aquí si lo deseas.
        //     // Luego, retornar la respuesta con el token y cualquier otra información que desees incluir.
        //     return response()->json([
        //         'status' => 200,
        //         'mensaje' => 'Usuario autenticado con éxito',
        //         'user' => $user
        //         // Puedes agregar un token JWT aquí si estás utilizando JWT para autenticación.
        //     ], 200);
        // } else {
        //     // Las credenciales son inválidas.
        //     return response()->json([
        //         'status' => 401,
        //         'mensaje' => 'Credenciales inválidas'
        //     ], 401);
        // }
    }
}
