<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeiculoRevisao extends Model
{
    use HasFactory;

    protected $table = 'manutencao_veiculos';

    protected $fillable = [
        'veiculo_id',
        'km_atual',
        'user_id',
        'descricao_manutencao',
        'tipo_manutencao',
        'justificativa'
    ];

    public function servicos(){
        return $this->hasMany(ServicoVeiculo::class, 'manutencao-veiculo_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function veiculo(){
        return $this->belongsTo(Veiculo::class, 'veiculo_id');
    }

    public function userAprovacao(){
        return $this->belongsTo(User::class,'user_aprovacao');
    }

    public function userDevolucao(){
        return $this->belongsTo(User::class, 'user_devolucao');
    }

   
}
