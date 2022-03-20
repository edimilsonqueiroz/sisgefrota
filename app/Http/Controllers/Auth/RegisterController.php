<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function render(){
        return view('register');
    }

    public function register(Request $request){
        $data = $request->only([
            'name',
            'email',
            'password', 
            'password_confirmation'
        ]);

        $validator = Validator::make($data,[
            'name'=>['required', 'string'],
            'email'=>['required','string','email','unique:users'],
            'password'=>['required', 'string','min:4','confirmed']
        ]);


        if($validator->fails()){
            return redirect()->route('register')->withErrors($validator)->withInput();
        }else{
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);
            return redirect()->route('login');
        }
    }
}
