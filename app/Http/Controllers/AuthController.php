<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    //

    public function login(Request $request){
       
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];
        $token = auth()->attempt($credentials);
        
        info($token);
        if(!$token){
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return ['token' => $token , 'user' => auth()->user()];
    }



}
