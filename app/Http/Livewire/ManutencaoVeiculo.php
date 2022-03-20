<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Veiculo;
use App\Models\ServicoVeiculo;
use App\Models\VeiculoRevisao;
use Livewire\WithPagination;

class ManutencaoVeiculo extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $idManutencao = '';
    public $user_id = '';
    public $search = '';
    public $searchEnviadas = '';
    public $searchAprovadas = '';
    public $servico = '';

    public $veiculo = '';
    public $km_atual = '';
    public $descricao = '';
    public $tipo_manutencao = '';
    public $justificativa = '';
    public $userAprovacao = '';
    public $userDevolucao = '';
    public $servicosManutencao = [];
    public $justificativaDevolucao = '';
    public $status  = '';

    

    public function render()
    {
        
        $veiculos = Veiculo::all();
        $servicos_veiculo = ServicoVeiculo::where('user_id',auth()
        ->user()->id)->where('manutencao-veiculo_id', null)->get();

        $manutencoesCadastradas = VeiculoRevisao::where('status', null)
        ->where('user_id', auth()->user()->id)->orderBy('id','desc')->get();

        if(auth()->user()->perfil == 'Funcionario'){

            $manutencoesEnviadas = VeiculoRevisao::where('status','like','%'.$this->searchEnviadas.'%')
            ->where('user_id', auth()->user()->id)
            ->where('status','!=',2)
            ->paginate(10);

            $manutencoesAprovadas = VeiculoRevisao::where('veiculo_id','like','%'.$this->searchAprovadas.'%')
            ->where('user_id', auth()->user()->id)
            ->where('status',2)
            ->paginate(10);

        }elseif(auth()->user()->perfil == 'Gerente'){
            $manutencoesEnviadas = VeiculoRevisao::where('status','like','%'.$this->searchEnviadas.'%')
            ->where('user_id','!=', 1)
            ->where('status','!=', 2)
            ->orderBy('id','desc')
            ->paginate(10);

            $manutencoesAprovadas = VeiculoRevisao::where('veiculo_id','like','%'.$this->searchAprovadas.'%')
            ->where('status',2)
            ->where('user_id','!=', 1)
            ->paginate(10);

        }else{
            $manutencoesEnviadas = VeiculoRevisao::where('status','like','%'.$this->searchEnviadas.'%')
            ->where('status','!=',2)
            ->orderBy('id','desc')
            ->paginate(10);

            $manutencoesAprovadas = VeiculoRevisao::where('veiculo_id','like','%'.$this->searchAprovadas.'%')
            ->where('status',2)->paginate(10);

        }

       

    
        return view('livewire.manutencao-veiculo',[
            'veiculos' => $veiculos,
            'servicos_veiculo' => $servicos_veiculo,
            'manutencoesCadastradas' =>$manutencoesCadastradas,
            'manutencoesEnviadas' => $manutencoesEnviadas,
            'manutencoesAprovadas' => $manutencoesAprovadas,
        ]);
    }

    public function resetAll(){
        $this->idManutencao = '';
        $this->user_id = '';
        $this->veiculo = '';
        $this->km_atual = '';
        $this->descricao = '';
        $this->tipo_manutencao = '';
        $this->justificativa = '';
        $this->userAprovacao = '';
        $this->userDevolucao = '';
        $this->servicosManutencao = [];
        $this->justificativaDevolucao = '';
        $this->status = '';
    }


    public function create(){
        $this->validate([
            'veiculo' =>['required'],
            'km_atual' => ['required'],
            'descricao' =>['required', 'string'],
            'tipo_manutencao' => ['required'],
            'justificativa' =>['required', 'string']
        ]);

        $idManutencao = VeiculoRevisao::insertGetId([
            'veiculo_id' => intval($this->veiculo),
            'km_atual'=> $this->km_atual,
            'user_id' => auth()->user()->id,
            'descricao_manutencao'=>$this->descricao,
            'tipo_manutencao' => intval($this->tipo_manutencao),
            'justificativa' => $this->justificativa,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        

        if(ServicoVeiculo::where('user_id', auth()->user()->id)
        ->where('manutencao-veiculo_id',null)->first()){

            ServicoVeiculo::where('user_id',auth()->user()->id)
            ->where('manutencao-veiculo_id',null)
            ->update([
                'manutencao-veiculo_id' => $idManutencao
            ]);

        }
        
        $this->resetAll();

        session()->flash('mensagem', 'Manutenção cadastrada com sucesso.');

    }

   
    public function detalhes($id){

        $manutencao = VeiculoRevisao::find($id);

        $this->justificativa = $manutencao->justificativa;
        $this->descricao = $manutencao->descricao_manutencao;
        $userAprovacao = $manutencao->userAprovacao()->first();
        $userDevolucao = $manutencao->userDevolucao()->first();
        $servicos = $manutencao->servicos()->get();

        $this->justificativaDevolucao = $manutencao->justificativa_devolucao;

        foreach($servicos as $servico){
            $this->servicosManutencao[$servico->id] = $servico->descricao;
        }

        if($userAprovacao != null){
            $this->userAprovacao = $userAprovacao['name'];
        }else if($userDevolucao != null){
            $this->userDevolucao = $userDevolucao['name'];
        }

        $this->dispatchBrowserEvent('modal-detalhes');

    }

    public function enviarAprovacao($id){
        $this->idManutencao = $id;
    }

    public function enviarAprovacaoAction(){
        $this->dispatchBrowserEvent('modal-enviar-aprovacao');

        VeiculoRevisao::where('id', $this->idManutencao)->update([
            'status' => 1
        ]);
    }

    public function aprovar(int $id){
       $this->idManutencao = $id;
    }

    public function aprovarAction(){

        $this->dispatchBrowserEvent('modal-aprovacao');

        VeiculoRevisao::where('id', $this->idManutencao)->update([
            'user_devolucao' => null,
            'user_aprovacao' => auth()->user()->id,
            'justificativa_devolucao' => null,
            'status' => 2,
        ]);

       
    }

    public function devolver(int $id){
        $this->idManutencao = $id;
    }

    public function devolverAction(){
        $this->validate([
            'justificativaDevolucao' => ['required','string','min:10']
        ]);

        VeiculoRevisao::where('id', $this->idManutencao)->update([
            'user_devolucao' => auth()->user()->id,
            'status' => 3,
            'justificativa_devolucao' => $this->justificativaDevolucao
        ]);

        $this->dispatchBrowserEvent('modal-devolucao');
    }
   

    public function update(int $id){

        $manutencao = VeiculoRevisao::find($id);
        $servicos = $manutencao->servicos()->get();
        

        foreach($servicos as $servico){
            $this->servicosManutencao[$servico->id] = $servico->descricao;
        }

        $this->idManutencao = $id;
        $this->km_atual = $manutencao->km_atual;
        $this->user_id = $manutencao->user_id;
        $this->userDevolucao = $manutencao->user_devolucao;
        $this->veiculo = $manutencao->veiculo_id;
        $this->descricao = $manutencao->descricao_manutencao;
        $this->tipo_manutencao = $manutencao->tipo_manutencao;
        $this->justificativa = $manutencao->justificativa;
        $this->status = $manutencao->status;


        $this->dispatchBrowserEvent('modal-editar');

    }

    public function updateAction(){
        
        VeiculoRevisao::where('id', $this->idManutencao)->update([
            'veiculo_id' => $this->veiculo,
            'km_atual' => $this->km_atual,
            'descricao_manutencao' => $this->descricao,
            'tipo_manutencao' => $this->tipo_manutencao,
            'justificativa' => $this->justificativa
        ]);

        session()->flash('mensagem', 'Manutenção alterada com sucesso.');
        

      
    }

    public function delete(int $id){
        $this->idManutencao = $id;
    }

    public function destroy(){

        ServicoVeiculo::where('manutencao-veiculo_id', $this->idManutencao)->delete();
        VeiculoRevisao::where('id', $this->idManutencao)->delete();

        $this->dispatchBrowserEvent('close-modal-delete');

        $this->idManutencao = '';
    }


    public function addServico(){

        $this->validate([
            'servico' => ['required','string']
        ]);

        ServicoVeiculo::create([
            'user_id' => auth()->user()->id,
            'descricao' => $this->servico
        ]);

        $this->servico = '';
       
    }

    public function createReloadServico(){
        $this->validate([
            'servico' => ['required','string']
        ]);

        ServicoVeiculo::create([
            'user_id' => auth()->user()->id,
            'manutencao-veiculo_id' => $this->idManutencao,
            'descricao' => $this->servico
        ]);

        $manutencao = VeiculoRevisao::find($this->idManutencao);
        $servicos = $manutencao->servicos()->get();
        foreach($servicos as $serv){
            $this->servicosManutencao[$serv->id] = $serv->descricao;
        }

        $this->servico = '';
    }

    public function reloadServico($id){
        $idServico = $id;
        unset( $this->servicosManutencao[$id]);
        ServicoVeiculo::where('id',$idServico)->delete();
    }

    public function deleteServico($id){
        ServicoVeiculo::where('id',$id)->delete();
    }
    
}
