<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Veiculo;
use App\Models\VeiculoRevisao;
use App\Models\ServicoVeiculo;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatorioVeiculo extends Controller
{
    public function render(){
        $veiculos = Veiculo::all();

        return view('relatorios.relatorio-veiculo',[
            'veiculos' => $veiculos
        ]);
    }

    public function veiculoStatus(Request $request){

       if($request->input('status') == ''){
            $veiculos = Veiculo::all();
       }elseif($request->input('status') == 'Funcionando'){
            $veiculos = Veiculo::where('status', 'Funcionando')->get();
       }elseif($request->input('status') == 'Manutencao'){
            $veiculos = Veiculo::where('status', 'Manutencao')->get();
       }

        
    
        $pdf = PDF::loadView('relatorios.relatorio-veiculos', [
            'veiculos' =>$veiculos
        ]);
       
        //return  $pdf ->download('Relatorio-veiculo.pdf');
     
        return $pdf->stream();
    }

    public function manutencoesVeiculo(Request $request){
        $array = [];

        $data_inicial = $request->input('data_inicial') == null ? '' : date('Y-m-d',strtotime($request->input('data_inicial')));
        $data_final = $request->input('data_final') == null ? '' : date('Y-m-d',strtotime($request->input('data_final')));

        $veiculo = Veiculo::find(intval($request->input('veiculo')));

    

        if($request->input('status') == '' && ($data_inicial == '' || $data_final == '')){
            $manutencoes = VeiculoRevisao::where('veiculo_id', $veiculo->id)->get();
        }elseif($request->input('status') != '' && $data_inicial != '' && $data_final != ''){
            $manutencoes = VeiculoRevisao::where('veiculo_id', $veiculo->id)
            ->where('status', $request->input('status'))
            ->where('created_at', '>=', $data_inicial)
            ->where('created_at', '<=', $data_final)
            ->get();
        }elseif($request->input('status') == '' && $data_inicial != '' && $data_final != ''){
            $manutencoes = VeiculoRevisao::where('veiculo_id', $veiculo->id)
            ->where('created_at', '>=', $data_inicial)
            ->where('created_at', '<=', $data_final)
            ->get();
        }else{
            $manutencoes = VeiculoRevisao::where('veiculo_id', $veiculo->id)
            ->where('status', $request->input('status'))
            ->get();
        }

        foreach($manutencoes as $key => $manutencao){
            $array[$key] = [
                'id' => $manutencao->id,
                'usuario' => User::find($manutencao->user_id),
                'user_aprovacao' => User::find($manutencao->user_aprovacao),
                'user_devolucao' => User::find($manutencao->user_devolucao),
                'servicos' => ServicoVeiculo::where('manutencao-veiculo_id', $manutencao->id)->get(),
                'descricao_manutencao' => $manutencao->descricao_manutencao,
                'tipo_manutencao' => $manutencao->tipo_manutencao,
                'justificativa' => $manutencao->justificativa,
                'status' => $manutencao->status,
                'data_criacao' => $manutencao->created_at
            ];
        }

       
        $pdf = PDF::loadView('relatorios.manutencoes-veiculo', [
            'veiculo' =>$veiculo,
            'manutencoes' => $array
        ])->setPaper('A4', 'portrait');
       
        //return  $pdf ->download('Relatorio-veiculo.pdf');
     
        return $pdf->stream();

    
        
    }
}
