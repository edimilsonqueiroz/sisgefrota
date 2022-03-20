<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Relatório de veículos</title>
    <link rel="stylesheet" type="text/css" href="css/relatorio.css">
</head>

<body>
    <!-- Define header and footer blocks before your content -->
    <header>
        <img class="logo-saude" src="imagens/logomarca.jpg">
        <img src="imagens/logodireita.jpg" class="logo-prefeitura">
        <div class="clear"></div>
    </header>

    <h1>RELATÓRIO DE MANUTENÇÕES DE VEÍCULO - SISGEFROTA</h1>

    <fieldset style="width: 100%; padding:10px 10px; margin:30px 0px;">
        <legend style="padding:0px 10px;">DADOS DO VEÍCULO</legend>
        <table>
            <tr>
                <td><b>Nome do veículo:</b> {{ $veiculo->name }}</td>
                <td><b>Placa:</b> {{ $veiculo->placa }}</td>
                <td><b>Ano:</b> {{ $veiculo->ano }}</td>
            </tr>
        </table>
    </fieldset>
    @foreach ($manutencoes as $manutencao)
        <fieldset style="width: 100%; padding:15px 10px; margin:30px 0px;">
            <legend style="padding:2px 10px; border-radius:20px; background-color: #A24E44; color:white;">
                DADOS DA MANUTENÇÃO/REVISÃO
            </legend>
            <table style="border: 1px solid #ccc;">
                <tr>
                    <td style="border: 1px solid #ccc;" colspan="1"><b>Código:</b>{{ $manutencao['id'] }}</td>
                    <td style="border: 1px solid #ccc;" colspan="3"><b>Descricao da manutenção/revisão:</b>
                        {{ $manutencao['descricao_manutencao'] }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="border: 1px solid #ccc;">
                        <b>Motivo da Manutenção/Revisão:</b><br>
                        @if ($manutencao['tipo_manutencao'] == 1)
                            Revisão Periódica
                        @elseif($manutencao['tipo_manutencao'] == 2)
                            Veiculo apresentou defeito
                        @endif
                    </td>
                    <td colspan="2" style="border: 1px solid #ccc;">
                        <b>Justificativa:</b><br>
                        {{ $manutencao['justificativa'] }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="border: 1px solid #ccc;">
                        <b>Status:</b><br>
                        @if ($manutencao['status'] == 1)
                            Aguardando aprovação
                        @elseif($manutencao['status'] == 2)
                            Aprovada
                        @elseif($manutencao['status'] == 3)
                            Devolvida para correção
                        @endif
                    </td>

                    <td colspan="2" style="border: 1px solid #ccc;">
                        <b>Cadastrado por:</b><br>
                        {{ $manutencao['usuario']->name }}
                    </td>

                </tr>
                <tr>
                    <td colspan="2" style="border: 1px solid #ccc;">
                        <b>Aprovado por:</b><br>
                        {{ $manutencao['user_aprovacao']->name }}
                    </td>
                    <td colspan="2" style="border: 1px solid #ccc;">
                        <b>Devolvido por:</b><br>
                        {{ $manutencao['user_devolucao'] }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <b>Data de criação:</b>
                        {{ date('d/m/Y', strtotime($manutencao['data_criacao'])) }}
                    </td>
                </tr>
            </table>
            <fieldset style="padding:10px 10px;">
                <legend style="padding:0px 10px;">SERVIÇOS REALIZADOS</legend>
                <table>
                    @foreach ($manutencao['servicos'] as $servico)
                        <tr>
                            <td>» {{ $servico->descricao }}</td>
                        </tr>
                    @endforeach
                </table>
            </fieldset>

        </fieldset>
    @endforeach
    <h2 class='total'>Total de manutenções: {{ count($manutencoes) }}</h2>
    <div class="credenciais">
        <hr>
        <p>Data emissão: {{ date('d/m/Y') }}</p>
        <span>Horas: {{ date('H:i:s') }}</span>
        <p>Relatório emitido por: {{ auth()->user()->name }}</p>
    </div>

    <footer>
        <!--
        Copyright &copy; <?php echo date('Y'); ?>
        <span>Secretaria Municipal de Saúde - Palmeirante Tocantins</span><br>
        <span>Departamento de Sistema de Informação em Saúde</span><br>
        <span>Avenida Brasil, Telefone: 3493-1219</span>
      -->
    </footer>
</body>

</html>
