<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(){
        return view('login');
    }


    public function loginSubmit(Request $request){
        $validatedData = $request->validate([
            'email' => 'required|email|exists:App\Models\User,email',
            'password' => 'required'
        ]);

        if(Auth::attempt($validatedData)){
            return redirect(route('admin'));
        }
        else{
            return redirect()->back()->withInput()->withErrors([
                'email' => 'Email/Password invalid'
            ]);
        }
    }
}
