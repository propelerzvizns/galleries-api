<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;
use App\Models\User;

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
        $realToken = $this->respondWithToken($token);
        info($token);
        if(!$token){

            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // dd($token);
        return ['token' =>  $realToken, 'user' => auth()->user()];
        // return ;
    }
    public function logout(Request $request){
        // dd($request);
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    public function register(CreateUserRequest $request){
        $validated = $request->validated();

        $user = User::create([
            'first_name' => $validated['firstName'],
            'last_name' => $validated['lastName'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);


        $token = auth()->login($user);

        return ['token' => $token , 'user' => auth()->user()];

    }
    public function refresh(Request $request)
    {
        return $this->respondWithToken(auth()->refresh($request));
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }




}
