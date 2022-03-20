<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class Usuarios extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $search = '';
    public $userId = '';
    public $name = '';
    public $cpf = '';
    public $email = '';
    public $perfil = '';

    

    public function resetAll(){
        $this->name = '';
        $this->email = '';
        $this->cpf = '';
        $this->perfil = '';
    }

    public function render()
    {
        return view('livewire.usuarios',[
            'users' => User::where('name','like', '%'.$this->search.'%')
            ->where('id', '!=', auth()->user()->id)->paginate(10)
        ]);
    }

    public function create(){
        
        $this->validate([
            'name' => 'required|min:6',
            'email' => 'required|email',
            'cpf' => ['required','string','max:11', 'unique:users'],
            'perfil'=> 'required|string'
        ]);

        User::create([
            'name' => $this->name,
            'cpf' => $this->cpf,
            'email' => $this->email,
            'perfil' => $this->perfil,
            'password' => Hash::make($this->cpf)
        ]);
        
        session()->flash('mensagem', 'Usuário cadastrado com sucesso.');

        $this->resetAll();
        
    }

    public function edit($id){
        $user = User::find($id);

       

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->cpf = $user->cpf;
        $this->perfil = $user->perfil;
    }

    public function editAction($id){

        User::where('id', $id)->update([
            'name' => $this->name,
            'email' => $this->email,
            'cpf' => $this->cpf,
            'perfil' => $this->perfil
        ]);

        session()->flash('mensagem', 'Usuário alterado com sucesso.');
    }

    public function resetPassword($id){
        $this->userId = $id;
    }

    public function resetPasswordAction(){
        $user = User::find($this->userId);
        
        User::where('id', $this->userId)->update([
            'password' => Hash::make($user->cpf)
        ]);
        $this->dispatchBrowserEvent('close-modal-reset');
        session()->flash('mensagem-sucesso', 'Senha usuário resetada com sucesso.');
    }

    public function delete($id){
        $this->userId = $id;
    }

    public function destroy(){
       User::destroy($this->userId);
       $this->dispatchBrowserEvent('close-modal-delete');
       session()->flash('mensagem-sucesso', 'Usuário apagado com sucesso.');
    }

    
}
