<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicoMaquina extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'servicos_maquina';

    protected $fillable = [
        'user_id',
        'manutencaoMaquina_id',
        'descricao'
    ];

    public function manutencao(){
        return $this->belongsTo(ServicoMaquina::class, 'manutencaoMaquina_id');
    }
}
