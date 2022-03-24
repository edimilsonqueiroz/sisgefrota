<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaquinaRevisao extends Model
{
    use HasFactory;

    protected $table = 'manutencao_maquinas';

    protected $fillable = [
        'user_id',
        'maquina_id',
        'descricao_manutencao',
        'tipo_manutencao',
        'justificativa',
        'status'
    ];

    public function servicos(){
        return $this->hasMany(ServicoMaquina::class, 'manutencaoMaquina_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function maquina(){
        return $this->belongsTo(Maquina::class, 'maquina_id');
    }

    public function userAprovacao(){
        return $this->belongsTo(User::class,'user_aprovacao');
    }

    public function userDevolucao(){
        return $this->belongsTo(User::class, 'user_devolucao');
    }
}
