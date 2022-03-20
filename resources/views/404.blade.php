@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>
@stop

@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1></h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="error-page">
                <h2 class="headline text-warning"> 404</h2>
                <div class="error-content">
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Ops! Página não encontrada.</h3>
                    <p>
                        Não foi possível encontrar a página que você estava procurando.
                        <a href="{{ asset('dashboard') }}">Clique aqui para voltar para o painel</a>
                    </p>
                </div>

            </div>

        </section>
    </div>
@stop
