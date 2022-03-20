<?php

namespace App\Http\Livewire;


use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Maquina;

class Maquinas extends Component
{
    use WithPagination;
    use WithFileUploads;
   

    protected $paginationTheme = 'bootstrap';

    public $name = '';
    public $ano = '';
    public $horas_trabalhadas = '';
    public $minutos_trabalhados = '';
    public $horas_limite_revisao = '';
    public $minutos_limite_revisao = '';
    public $horas_ultima_revisao = '';
    public $minutos_ultima_revisao = '';
    public $horas_proxima_revisao = '';
    public $minutos_proxima_revisao = '';
    public $status = '';
    public $imagem;


    public function render()
    {
        return view('livewire.maquinas');
    }


    public function createMaquina(){
        
        $this->validate([
            'name' => ['required','string'],
            'ano' => ['required'],
            'horas_trabalhadas' => ['required'],
            'horas_limite_revisao' => ['required'],
            'horas_ultima_revisao' => ['required'],
            'horas_proxima_revisao' => ['required'],
            'status' => ['required', 'string'],
            'imagem' => ['required','mimes:jpg,png','image','max:1024']
        ]);

        
        $path  = $this->imagem->store('app/public/imagens');
        $this->horas_proxima_revisao  = $this->horas_ultima_revisao + $this->horas_limite_revisao;
        $maquina = new Maquina();
        $maquina->name = $this->name;
        $maquina->ano = $this->ano;
        $maquina->horas_trabalhadas = $this->horas_trabalhadas;
        $maquina->horas_limite_revisao = $this->horas_limite_revisao;
        $maquina->horas_ultima_revisao = $this->horas_ultima_revisao;
        $maquina->horas_proxima_revisao = $this->hora_proxima_revisao;
        $maquina->status = $this->status;
        $maquina->imagem = $path;
        $maquina->created_at = date('Y-m-d');
        $maquina->save();
        

        //$this->resetAll();

        session()->flash('mensagem', 'Maquina cadastrada com sucesso.');
        
    }

    public function resetAll(){
        $this->name = '';
        $this->ano = '';
        $this->horas_trabalhadas = '';
        $this->minutos_trabalhados = '';
        $this->horas_limite_revisao = '';
        $this->minutos_limite_revisao = '';
        $this->horas_ultima_revisao = '';
        $this->minutos_ultima_revisao = '';
        $this->horas_proxima_revisao = '';
        $this->minutos_proxima_revisao = '';
        $this->status = '';
        $this->imagem = '';
    }
}
