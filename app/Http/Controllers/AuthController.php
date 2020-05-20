<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserLogin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(UserLogin $request)
    {
        $user = User::where('username', $request->username)->first();

        if ($user) {

            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                return response(
                    array(
                        'user' => $user,
                        'access_token' => $token
                    ), 200
                );
            } else {
                $response = "El password es incorrecto";
                return response($response, 500);
            }

        } else {
            $response = 'Credenciales incorrectas';
            return response($response, 500);
        }
    }

    public function auth(){
        return Auth::user();
    }

    public function logout(Request $request)
    {
        Auth::user()->token()->revoke = true;
        return response('logout success full', 200);

    }

}
