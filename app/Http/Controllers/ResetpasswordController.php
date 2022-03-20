<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\Email;

class ResetpasswordController extends Controller
{
    public function render(){
        return view('reset-password');
    }

    public function resetPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email']
        ]);

        if($validator->fails()){
            return redirect()->route('reset-password')->withErrors($validator);
        }else{
            
            $user = User::where('email', $request->input('email'))->first();
            

            if(!$user){
                session()->flash('error', 'Nenhum usuário encontrado com esse email');
                return redirect()->route('reset-password');
            }else{
                $login = $user->email;
                $senha  = $this->gerar_senha(8,true,true,true,true);
                $senhaBanco = Hash::make($senha);

                $array = [
                    'email' => $login,
                    'senha' => $senha
                ];
            }

           
    
            try {

                Mail::send(new Email($array));
    
                User::where('email', $user->email)->update([
                    'password' => $senhaBanco
                ]);

                session()->flash('sucesso', 'Senha alterada. Sua nova senha foi enviada para o seu email');
                return redirect()->route('reset-password');

            } catch (\Exception $e) {

                session()->flash('error', 'Não foi possível enviar o email verifique sua conexao');
                return redirect()->route('reset-password');

            }
        }
    }

    public static function gerar_senha($tamanho, $maiusculas, $minusculas, $numeros, $simbolos)
    {
        $password = '';
        $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
        $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
        $nu = "0123456789"; // $nu contem os números
        $si = "@#$%&"; // $si contem os símbolos

        if ($maiusculas) {
            // se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha
            $password .= str_shuffle($ma);
        }

        if ($minusculas) {
            // se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha
            $password .= str_shuffle($mi);
        }

        if ($numeros) {
            // se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha
            $password .= str_shuffle($nu);
        }

        if ($simbolos) {
            // se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha
            $password .= str_shuffle($si);
        }

        // retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
        return substr(str_shuffle($password), 0, $tamanho);
    }
}
