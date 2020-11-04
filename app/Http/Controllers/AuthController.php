<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;

class AuthController extends Controller
{
    //

    public function login(UserLoginRequest $request){
       $validated = $request->validated();

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password']
        ];
        $token = auth()->attempt($credentials);

        info($token);
        if(!$token){

            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return ['token' => $token , 'user' => auth()->user()];
    }



}
