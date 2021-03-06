<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Veiculo;

class DashboardController extends Controller
{
    public function render()
    {

        $veiculos = Veiculo::all();
        $veiculosRevisados = '';
        $veiculosProximoRevisÃ£o = '';
        $revisaoAtrasada = '';

        foreach($veiculos as $veiculo){
            $limite  = 500;
            $resultado = abs($veiculo->km_rodado - $veiculo->km_ultima_revisao);
            $proximaRevisao = abs($veiculo->km_rodado - $veiculo->proxima_revisao);
             
            if(($resultado < $veiculo->km_limite_revisao) && ($proximaRevisao <= $limite) || ($veiculo->km_rodado == $veiculo->proxima_revisao)){
                $veiculosProximoRevisÃ£o++;
            }

            if($resultado < $veiculo->km_limite_revisao){
                $veiculosRevisados++;
            }
            
            if($resultado > $veiculo->km_limite_revisao){
                $revisaoAtrasada++;
            }

        }

        return view('dashboard',[
            'veiculos_revisados' => $veiculosRevisados,
            'revisao_proxima' => $veiculosProximoRevisÃ£o,
            'revisao_atrasada' => $revisaoAtrasada
        ]);
    }
}
