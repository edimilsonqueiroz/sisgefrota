<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function render(){
        return view('login');
    }

    public function authenticate(Request $request){
        $data = $request->only([
            'email',
            'password'
        ]);

        $validator = Validator::make($data,[
            'email'=>['required','string', 'email'],
            'password'=>['required','string','min:4']
        ]);

        $remember = $request->input('remember');

        if($validator->fails()){
            return redirect()->route('login')->withErrors($validator)->withInput();
        }

        if(Auth::attempt($data,$remember)){
            return redirect()->route('painel');
        }else{
            $validator->errors()->add('password', 'E-mail e/ou senha incorretos!');
            return redirect()->route('login')->withErrors($validator)->withInput();
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
