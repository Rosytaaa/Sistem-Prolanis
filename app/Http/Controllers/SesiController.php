<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    function index(){
        return view('login');
    }

    function login(Request $request){
        $request->validate([
            'username'=>'required',
            'password'=>'required'
        ],
        [
          'username.required'=>'Email wajib diisi',
          'password.required'=>'Password wajib diisi'
        ]);

        $infologin =[
            'username'=>$request->username,
            'password'=>$request->password,
        ];

        if(Auth::attempt($infologin)){
            return redirect()->route('dashboard');
        }
        else{
            return redirect('')->withErrors('Username dan password yang dimasukan tidak sesuai')->withInput();
        }
    }
}
