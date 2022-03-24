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

    public $searchMaquinas;
    public $maquinaId;
    public $name;
    public $ano;
    public $horas_trabalhadas;
    public $minutos_trabalhados;
    public $limite_revisao;
    public $minutos_limite;
    public $ultima_revisao;
    public $minutos_ultima;
    public $proxima_revisao;
    public $minutos_proxima;
    public $status;
    public $imagem;
    public $imagemUpdate;

    protected $rules = [
        'name' => 'required',
        'ano' => 'required',
        'horas_trabalhadas' => 'required',
        'limite_revisao' => 'required',
        'ultima_revisao' => 'required',
        'status' => 'required',
        'imagem' => ['required', 'mimes:jpg,png', 'max:1024']
    ];

    public function render()
    {
        return view('livewire.maquinas', [
            'maquinas' => Maquina::where('name', 'like', '%' . $this->searchMaquinas . '%')->paginate(3)
        ]);
    }

    public function create()
    {

        $this->validate();


        $this->proxima_revisao = $this->limite_revisao + $this->ultima_revisao;
        $this->minutos_proxima = intval($this->minutos_limite) + intval($this->minutos_ultima);

        if ($this->minutos_proxima != 0 && $this->minutos_proxima >= 60) {
            $this->proxima_revisao = $this->proxima_revisao + 1;
            $this->minutos_proxima = $this->minutos_proxima - 60;
        }

        $path = $this->imagem->store('imagens');

        if ($path) {

            Maquina::create([
                'name' => $this->name,
                'ano' => $this->ano,
                'horas_trabalhadas' => $this->horas_trabalhadas,
                'minutos_trabalhados' => $this->minutos_trabalhados ? $this->minutos_trabalhados : 0,
                'horas_limite_revisao' => $this->limite_revisao,
                'minutos_limite_revisao' => $this->minutos_limite ? $this->minutos_limite : 0,
                'horas_ultima_revisao' => $this->ultima_revisao,
                'minutos_ultima_revisao' => $this->minutos_ultima ? $this->minutos_ultima : 0,
                'horas_proxima_revisao' => $this->proxima_revisao,
                'minutos_proxima_revisao' => $this->minutos_proxima ? $this->minutos_proxima : 0,
                'status' => $this->status,
                'imagem' => $path
            ]);
        }

        $this->resetAll();
        session()->flash('mensagem', 'Maquina cadastrada com sucesso');
    }


    public function resetAll()
    {
        $this->maquinaId = '';
        $this->name = '';
        $this->ano = '';
        $this->horas_trabalhadas = '';
        $this->minutos_trabalhados = '';
        $this->limite_revisao = '';
        $this->minutos_limite = '';
        $this->ultima_revisao = '';
        $this->minutos_ultima = '';
        $this->proxima_revisao = '';
        $this->minutos_proxima = '';
        $this->status = '';
        $this->imagem = '';
    }

    public function update(int $id)
    {
        $this->maquinaId = intval($id);

        $maquina = Maquina::find($id);

        $this->name = $maquina->name;
        $this->ano = $maquina->ano;
        $this->horas_trabalhadas = $maquina->horas_trabalhadas;
        $this->minutos_trabalhados = $maquina->minutos_trabalhados;
        $this->limite_revisao = $maquina->horas_limite_revisao;
        $this->minutos_limite = $maquina->minutos_limite_revisao;
        $this->ultima_revisao = $maquina->horas_ultima_revisao;
        $this->minutos_ultima = $maquina->minutos_ultima_revisao;
        $this->proxima_revisao = $maquina->horas_proxima_revisao;
        $this->minutos_proxima = $maquina->minutos_proxima_revisao;
        $this->status = $maquina->status;
    }

    public function updateAction()
    {

        
        $this->proxima_revisao = $this->limite_revisao + $this->ultima_revisao;
        $this->minutos_proxima = intval($this->minutos_limite) + intval($this->minutos_ultima);

        if ($this->minutos_proxima != 0 && $this->minutos_proxima >= 60) {
            $this->proxima_revisao = $this->proxima_revisao + 1;
            $this->minutos_proxima = $this->minutos_proxima - 60;
        }


        Maquina::where('id', $this->maquinaId)->update([
            'name' => $this->name,
            'ano' => $this->ano,
            'horas_trabalhadas' => $this->horas_trabalhadas,
            'minutos_trabalhados' => $this->minutos_trabalhados ? $this->minutos_trabalhados : 0,
            'horas_limite_revisao' => $this->limite_revisao,
            'minutos_limite_revisao' => $this->minutos_limite ? $this->minutos_limite : 0,
            'horas_ultima_revisao' => $this->ultima_revisao,
            'minutos_ultima_revisao' => $this->minutos_ultima ? $this->minutos_ultima : 0,
            'horas_proxima_revisao' => $this->proxima_revisao,
            'minutos_proxima_revisao' => $this->minutos_proxima ? $this->minutos_proxima : 0,
            'status' => $this->status
        ]);

        session()->flash('mensagem', 'Alteração feita com sucesso');
    }

    public function updateStatus(int $id){
        $this->maquinaId = intval($id);
        $maquina = Maquina::find($id);

        $this->status = $maquina->status;
    }

    public function updateStatusAction(){
        Maquina::where('id', $this->maquinaId)->update([
            'status' => $this->status
        ]);

        session()->flash('mensagem', 'Alteração feita com sucesso');
    }

    public function updateHorimetro(int $id){
        $maquina = Maquina::find($id);
        $this->maquinaId = $id;
        $this->name = $maquina->name;
        $this->horas_trabalhadas = $maquina->horas_trabalhadas;
        $this->minutos_trabalhados = $maquina->minutos_trabalhados;
        $this->dispatchBrowserEvent('modal-editar');
    }

    public function updateHorimetroAction(){
        Maquina::where('id', $this->maquinaId)->update([
            'horas_trabalhadas' => $this->horas_trabalhadas,
            'minutos_trabalhados' => $this->minutos_trabalhados ? $this->minutos_trabalhados : 0,
        ]);

        session()->flash('mensagem', 'Alteração feita com sucesso');
    }

    public function updateImagem(int $id){
        $this->maquinaId = $id;
        $maquina = Maquina::find($id);
        $this->name = $maquina->name;
        $this->imagemUpdate = $maquina->imagem;
    }

    public function updateImagemAction(){
        
        $this->validate([
            'imagem' => ['required','mimes:jpg,png','image','max:1024']
        ]);
        
        $imagemAtual = explode('/',$this->imagemUpdate);

        if(file_exists(storage_path('app/public/imagens/'.$imagemAtual[1]))){
            unlink(storage_path('app/public/imagens/'.$imagemAtual[1]));
        }

        if($path = $this->imagem->store('imagens')){
            Maquina::where('id',$this->maquinaId)->update([
                'imagem' => $path
            ]);

        }
    

        $this->resetAll();
        $this->dispatchBrowserEvent('close-modal-imagem');
        session()->flash('mensagem-sucesso', 'Imagem alterada com sucesso.');
    
    }

    public function delete($id){
        $this->maquinaId = $id;
    }

    public function destroy(){
        $maquina = Maquina::find($this->maquinaId);
        
        $imagemMaquina = explode('/', $maquina->imagem) ;

        if(file_exists(storage_path('app/public/imagens/'.$imagemMaquina[1]))){
            unlink(storage_path('app/public/imagens/'.$imagemMaquina[1]));
        }
       
        Maquina::destroy($this->maquinaId);
    
        $this->dispatchBrowserEvent('close-modal-delete');
        session()->flash('mensagem-sucesso', 'Veículo apagado com sucesso.');
    
    }
}
