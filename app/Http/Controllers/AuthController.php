<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    //

    public function login(Request $request){
        // dd($request);
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];
        $token = Auth::attempt($credentials);
        dd($token);
        if(!$token){
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this.respondWithToken($token);
    }
    public function respondWithToken($token){
        return response()->json([
            'accesss_token' => $token,
            'token_type' => 'bearer'
            // 'expirens_in' => 3000
        ]);
    }

}
