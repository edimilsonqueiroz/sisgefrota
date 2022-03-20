@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="col-md-4">
                <x-adminlte-small-box title="{{ $veiculos_revisados ? $veiculos_revisados : 0}}" text="Veículos Revisados"
                    icon="fas fa-check text-dark" theme="teal" url="#" url-text="Ver detalhes" />
            </div>
            <div class="col-md-4">
                <x-adminlte-small-box title="{{ $revisao_proxima ? $revisao_proxima : 0}}" text="Próximos de Revisão"
                    icon="fas fa-exclamation-circle text-dark" theme="warning" url="#" url-text="Ver detalhes" />
            </div>
            <div class="col-md-4">
                <x-adminlte-small-box title="{{ $revisao_atrasada ? $revisao_atrasada : 0}}" text="Revisão atrasada" icon="far fa-bell text-dark"
                    theme="danger" url="#" url-text="Ver detalhes" />
            </div>
        </div>
    </div>
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@stop
