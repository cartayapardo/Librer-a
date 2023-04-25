<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                "email"       => "email|required",
                "password"    => "required"
            ]);
            $form = $request->all();
            $user = User::where('email', $form['email'])->first();
            if (!$user || !Hash::check($form['password'], $user->password)) {
                return response([
                    'msg' => 'Credenciales incorrectas'
                ], 401);
            }
            $token = $user->createToken('apiToken')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token
            ];
            return response($response, 201);
        } catch (Exception $error) {
            return response()->json([
                "message"     => $error->getMessage(),
                "error"       => $error,
            ], 401);
        }
    }

    public function close(Request $request){
        $user = $request->user();
        $user->tokens()->where('id', explode('|', $request->bearerToken())[0])->delete();
        return ['logrado' => true, 'datos' => null, 'sms' => 'Salida de la aplicación con exito'];
    }
}
