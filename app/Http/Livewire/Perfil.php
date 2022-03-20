<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Perfil extends Component
{

    public function render()
    {
        $user = User::find(auth()->user()->id);

        return view('livewire.perfil',compact('user'));
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'name' =>['required','string'],
            'email' => ['required','email']
        ]);

        if($validator->fails()){
            return redirect()->route('perfil')->withErrors($validator);
        }

        User::where('id', auth()->user()->id)->update([
            'name' => $request->input('name'),
            'email' => $request->input('email')
        ]);

        session()->flash('mensagem', 'Dados do usuário alterado com sucesso!');
        return redirect()->route('perfil');
    }

    public function updatePassword(Request $request){

        $validator = Validator::make($request->all(),[
            'password'=>['required', 'string','min:4','confirmed']
        ]);

        if($validator->fails()){
            return redirect()->route('perfil')->withErrors($validator);
        }

        User::where('id', auth()->user()->id)->update([
            'password' => Hash::make($request->input('password'))
        ]);

        session()->flash('mensagem-password', 'Nova senha cadastrada com sucesso!');
        return redirect()->route('perfil');
    }

    
}
