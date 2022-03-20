@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <h1></h1>
@stop

@section('content')
    {{ $slot }}
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
@stop
@section('js')
    <script>
            window.addEventListener('modal-editar',function() {
                $('#modal-editar').modal('show');
            })

            window.addEventListener('close-modal-editar',function() {
                $('#modal-editar').modal('hide');
            })
            
            window.addEventListener('close-modal-delete',function() {
                $('#modal-delete').modal('hide');
            })

            window.addEventListener('close-modal-reset', function() {
                $('#alterar-senha').modal('hide');
            })

            window.addEventListener('close-modal-imagem', function() {
                $('#editar-imagem').modal('hide');
            })

            window.addEventListener('modal-detalhes', function() {
                $('#modal-visualizar').modal('show');
            })

            window.addEventListener('modal-devolucao', function() {
                $('#modal-devolucao').modal('hide');
            })

            window.addEventListener('modal-enviar-aprovacao', function() {
                $('#modal-enviar-aprovacao').modal('hide');
            })

            window.addEventListener('modal-aprovacao', function() {
                $('#modal-aprovacao').modal('hide');
            })
    </script>
    
@stop
