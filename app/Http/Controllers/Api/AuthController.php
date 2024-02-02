<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request){      
        $this->validate($request, [
            'name' => 'required|max:50', 
            'email' => 'required|max:50|email|unique:users', 
            'password' => 'required|min:3|max:50|confirmed', 
            'password_confirmation' => 'required|min:3|max:50',
        ]);
        
        $request['role'] = 'Customer';
        $user = User::create($request->all());
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json($token, Response::HTTP_CREATED);
    }
    
    public function login(Request $request){
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }
        $user = User::whereEmail($request->email)->first();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json($token, Response::HTTP_OK);
    }
}
