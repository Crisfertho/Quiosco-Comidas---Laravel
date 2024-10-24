<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegistroRequest;

class AuthController extends Controller
{
    public function register(RegistroRequest $request){
        //validar registro
        $data = $request ->validated();

        // crear usuario
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        //retornar
        return [
            'user' => $user,
            'token' => $user->createToken('token')->plainTextToken,   
        ];
    }

    public function login(LoginRequest $request){

        $data = $request->validated();
        // Verificar si el usuario existe por email
        $user = User::where('email', $data['email'])->first();
       
        
         // Si no existe, retorna error
        if (!$user) {
            return response([
                'errors' => ['email' => ['El correo no está registrado']],
            ], 422);
        }

        // Si existe, verificar que la contraseña sea correcta
        if (!Hash::check($data['password'], $user->password)) {
            return response([
                'errors' => ['password' => ['La contraseña es incorrecta']],
            ], 422);
        }

        
        Auth::login($user);
        // Retornar el token
        //$user = Auth::user();
        return [
            'user' => $user,
            'token' => $user->createToken('token')->plainTextToken,
        ];

    }

    public function logout(Request $request){
       
         $user = $request->user();
       $user->currentAccessToken()->delete();

       return [
        'user' => null
       ];
    }
}
