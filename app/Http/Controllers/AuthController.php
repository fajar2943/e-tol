<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        return view('auth.index');
    }

    public function login(Request $request){
        if(Auth::attempt($request->only('email', 'password'))){
            if(auth()->user()->role == 'Admin'){
                return redirect('/admin');
            }elseif(auth()->user()->role == 'Customer'){                
                return redirect('/');
            }
        }
        return redirect()->back()->with('failed', 'Email atau password salah.');
    }

    public function register(){
        return view('auth.register');
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|max:50|min:1',
            'email' => 'required|unique:users|email|min:2|max:50',
            'password' => 'required|min:3',
            'confirm_password' => 'required|min:3',
        ]);

        if($request->password != $request->confirm_password){
            return redirect()->back()->withInput()->with('failed', 'Password tidak sesuai');
        }
        $request['role'] = 'Customer';
        $user = User::create($request->all());
        Auth::login($user);
        return redirect('/');
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
