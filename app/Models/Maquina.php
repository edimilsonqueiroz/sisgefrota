<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ano',
        'horas_trabalhadas',
        'minutos_trabalhados',
        'horas_limite_revisao',
        'minutos_limite_revisao',
        'horas_ultima_revisao',
        'minutos_ultima_revisao',
        'horas_proxima_revisao',
        'minutos_proxima_revisao',
        'status',
        'imagem'
    ];

    public function manutencoes(){
        return $this->hasMany(MaquinaRevisao::class, 'maquina_id','id');
    }
}
