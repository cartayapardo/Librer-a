<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function clients(Request $request)
    {
        $rol = Rol::where('name', 'Cliente')->first();
        $users = User::where('rol_id', $rol->id)->get();
        return ['success' => true, 'data' => $users, 'sms' => 'Datos cargados correctamente'];
    }

    public function register(Request $request){
        $payload = $request->all();
        $payload['password'] = Hash::make($payload['password']);
        $payload['rol_id'] = 1;
        $newUser = User::create($payload);
        if(!$newUser){
            return ['logrado' => false, 'datos' => null, 'sms' => 'Existe un error en la creación del usuario'];
        }
        return ['logrado' => true, 'datos' => $newUser, 'sms' => 'Creación del usuario con éxito'];
    }
}
