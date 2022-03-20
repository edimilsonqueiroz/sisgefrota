<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'placa',
        'ano',
        'km_rodado',
        'km_limite_revisao',
        'status',
        'imagem'
    ];

    public function manutencoes(){
        return $this->hasMany(VeiculoRevisao::class, 'veiculo_id','id');
    }
}
