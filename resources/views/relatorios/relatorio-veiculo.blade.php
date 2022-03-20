@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>
@stop

@section('content')
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Relatório de veículo</h5>
                </div>
                <form target="_blank" method="POST" action="{{ route('veiculos-status') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <select name="status" class="form-control @error('status') is_invalid @enderror">
                                <option value="">Todos os veículos</option>
                                <option value="Funcionando">Funcionando</option>
                                <option value="Manutencao">Em manutencao/revisão</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-sm btn-info" type="submit">Imprimir relatório</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Relatório de manutençoes de veículos</h5>
                </div>
                <form target="_blank" method="post" action="{{ route('manutencoes-veiculo') }}">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Selecionar Veículo</label>
                                    <select name="veiculo" class="form-control">
                                        @foreach ($veiculos as $veiculo)
                                            <option value="{{ $veiculo->id }}">{{ $veiculo->name }} - placa: {{ $veiculo->placa }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Selecionar o status da manutenção</label>
                                    <select name="status" class="form-control">
                                        <option value="">Todas as Manutenções</option>
                                        <option value="1">Aguardando Aprovação</option>
                                        <option value="2">Aprovada</option>
                                        <option value="3">Devolvida para correção</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Data Inicial</label>
                                   <input class="form-control" type="date" name="data_inicial">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Data Final</label>
                                   <input class="form-control" type="date" name="data_final">
                                </div>
                            </div>
                        </div>
                
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-sm btn-info">Imprimir relatório</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@stop
