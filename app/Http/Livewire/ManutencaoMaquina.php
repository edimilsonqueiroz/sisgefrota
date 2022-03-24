<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Maquina;
use App\Models\MaquinaRevisao;
use App\Models\ServicoMaquina;
use App\Models\User;

class ManutencaoMaquina extends Component
{
    public $user_id;
    public $maquina_id;
    public $user_aprovacao;
    public $user_devolucao;
    public $justificativa_devolucao;
    public $descricao_manutencao;
    public $tipo_manutencao;
    public $justificativa;
    public $status;
    public $servico;

    public function render()
    {
        $manutencoesCadastradas = [];
        $servicos = ServicoMaquina::where('user_id', auth()->user()->id)->where('manutencaoMaquina_id', null)->get();
        $maquinas = Maquina::all();

        $manutencoesCadastradas = MaquinaRevisao::where('status', null)
        ->where('user_id', auth()->user()->id)
        ->orderBy('id','desc')->get();


        return view('livewire.manutencao-maquina',[
            'maquinas' => $maquinas,
            'servicos' => $servicos,
            'manutencoesCadastradas' =>$manutencoesCadastradas
        ]);
    }

    public function resetAll(){
        $this->maquina_id = '';
        $this->descricao_manutencao = '';
        $this->tipo_manutencao = '';
        $this->justificativa = '';
    }

    public function create(){
        $this->validate([
            'descricao_manutencao' => ['required','string'],
            'maquina_id' => ['required'],
            'tipo_manutencao' => ['required'],
            'justificativa'=>['required'],
        ]);

        $idManutencao = MaquinaRevisao::insertGetId([
            'user_id' => auth()->user()->id,
            'maquina_id'=>$this->maquina_id,
            'descricao_manutencao'=>$this->descricao_manutencao,
            'tipo_manutencao'=>$this->tipo_manutencao,
            'justificativa'=>$this->justificativa,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        if(ServicoMaquina::where('user_id', auth()->user()->id)
        ->where('manutencaoMaquina_id',null)->first()){

            ServicoMaquina::where('user_id',auth()->user()->id)
            ->where('manutencaoMaquina_id',null)
            ->update([
                'manutencaoMaquina_id' => $idManutencao
            ]);

        }
        
        $this->resetAll();

        session()->flash('mensagem', 'Manutenção cadastrada com sucesso.');
    }

    public function addServico(){

        $this->validate([
            'servico' => ['required','string']
        ]);

        ServicoMaquina::create([
            'user_id' => auth()->user()->id,
            'descricao' => $this->servico
        ]);

        $this->servico = '';
       
    }

    public function deleteServico(int $id){
        ServicoMaquina::where('id',$id)->delete();
    }
}
