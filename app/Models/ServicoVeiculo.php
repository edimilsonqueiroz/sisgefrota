<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicoVeiculo extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'servicos_veiculo';

    protected $fillable = [
        'user_id',
        'manutencao-veiculo_id',
        'descricao'
    ];


    public function manutencao(){
        return $this->belongsTo(ServicoVeiculo::class, 'manutencao-veiculo_id');
    }
}
