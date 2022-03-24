<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Veiculo;
use App\Models\VeiculoRevisao;

class Veiculos extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $veiculoId = '';
    public $nome = '';
    public $placa = '';
    public $ano = '';
    public $km_rodados = '';
    public $km_revisao = '';
    public $ultima_revisao = '';
    public $status = '';
    public $imagem;
    public $imagemUpdate;

    public function resetAll(){
        $this->nome = '';
        $this->placa = '';
        $this->ano = '';
        $this->km_rodados = '';
        $this->km_revisao = '';
        $this->ultima_revisao = '';
        $this->status = '';
        $this->imagem = '';
    }

    public function render()
    {
        return view('livewire.veiculos',[
            'veiculos' => Veiculo::where('name', 'like','%'.$this->search.'%')->paginate(3),
        ]);
    }

    public function atualizaKm(int $id){
        $this->veiculoId = $id;
        $veiculo = Veiculo::find($id);

        $this->nome = $veiculo->name;

        $this->dispatchBrowserEvent('modal-editar');
    }

    public function atualizaKmAction(){

        $this->validate([
            'km_rodados' => ['required', 'numeric']
        ]);

        Veiculo::where('id', $this->veiculoId)->update([
            'km_rodado' => intval($this->km_rodados)
        ]);

        $this->km_rodados = '';

        session()->flash('mensagem', 'Km atualizado com sucesso.');
    }

    public function create(){
        $this->validate([
            'nome' => 'required',
            'placa' => ['required', 'unique:veiculos'],
            'ano' => 'required',
            'km_rodados' => 'required',
            'km_revisao' => 'required',
            'ultima_revisao' => 'required',
            'status' => 'required',
            'imagem' => ['required','mimes:jpg,png','image','max:1024']
        ]);

         if($path = $this->imagem->store('imagens')){
             Veiculo::create([
                 'name' => $this->nome,
                 'placa' => $this->placa,
                 'ano' => $this->ano,
                 'km_rodado' => $this->km_rodados,
                 'km_limite_revisao' => $this->km_revisao,
                 'km_ultima_revisao' => $this->ultima_revisao,
                 'status' => $this->status,
                 'imagem' => $path
             ]);
         }

         $this->resetAll();

         session()->flash('mensagem', 'Veículo cadastrado com sucesso.');
    }


    public function update($id){
        $this->veiculoId = $id;
        $veiculo = Veiculo::find($id);

        $this->nome = $veiculo->name;
        $this->placa = $veiculo->placa;
        $this->ano = $veiculo->ano;
        $this->km_rodados = $veiculo->km_rodado;
        $this->km_revisao = $veiculo->km_limite_revisao;
        $this->ultima_revisao = $veiculo->km_ultima_revisao;
        $this->status = $veiculo->status;
    }

    public function updateAction(){
        $this->validate([
            'nome' => 'required',
            'placa' => ['required'],
            'ano' => 'required',
            'km_rodados' => 'required',
            'km_revisao' => 'required',
            'ultima_revisao' => 'required',
            'status' => 'required',
        ]);

        Veiculo::where('id',$this->veiculoId)->update([
            'name' => $this->nome,
            'placa' => $this->placa,
            'ano' => $this->ano,
            'km_rodado' => $this->km_rodados,
            'km_limite_revisao' => $this->km_revisao,
            'km_ultima_revisao' => $this->ultima_revisao,
            'status' => $this->status,
        ]);

        session()->flash('mensagem', 'Veículo alterado com sucesso.');
    }

    public function updateImagem($id){
        $this->veiculoId = $id;
        $veiculo = Veiculo::find($id);
        $this->nome = $veiculo->name;
        $this->imagemUpdate = $veiculo->imagem;
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
            Veiculo::where('id',$this->veiculoId)->update([
                'imagem' => $path
            ]);

        }
    

        $this->resetAll();
        $this->dispatchBrowserEvent('close-modal-imagem');
        session()->flash('mensagem-sucesso', 'Imagem alterada com sucesso.');
    }
    
    public function updateStatus(int $id){
        $this->veiculoId = $id;
        $veiculo = Veiculo::find($this->veiculoId);
        $this->status = $veiculo->status;
    }

    public function updateStatusAction(){
        Veiculo::where('id', $this->veiculoId)->update([
            'status' => $this->status
        ]);

        session()->flash('mensagem', 'Status alterado com sucesso');
    }

    public function delete($id){
        $this->veiculoId = $id;
    }

    public function destroy(){
        $veiculo = Veiculo::find($this->veiculoId);
        $veiculoRevisao = VeiculoRevisao::where('veiculo_id', $this->veiculoId)->first();

        if(!$veiculoRevisao){
            $imagemVeiculo = explode('/', $veiculo->imagem) ;
            unlink(storage_path('app/public/imagens/'.$imagemVeiculo[1]));
            Veiculo::destroy($this->veiculoId);

            $this->dispatchBrowserEvent('close-modal-delete');
            session()->flash('mensagem-sucesso', 'Veículo apagado com sucesso.');

        }else{
            session()->flash('mensagem-error', 'Veículo possui mautenções/revisões vinculada a ele voçe previsa remover primeiro as manutençoes/revisões.');
        }
    
    }

   
}
