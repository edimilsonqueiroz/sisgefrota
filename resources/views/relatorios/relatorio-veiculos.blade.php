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


    <h1>VEÍCULOS CADASTRADOS - SISGEFROTA</h1>

    <table>
        <tr class="cabecalho">
            <th>Nome</th>
            <th>Placa</th>
            <th>Ano</th>
            <th>KM Rodados</th>
            <th>Situação</th>
        </tr>
        @foreach ($veiculos as $veiculo)
            <tr>
                <td>{{ $veiculo->name }}</td>
                <td>{{ $veiculo->placa }}</td>
                <td>{{ $veiculo->ano }}</td>
                <td>{{ $veiculo->km_rodado }}</td>
                <td>{{ $veiculo->status }}</td>
            </tr>
        @endforeach
    </table>

    <h2 class='total'>Total de veículos: {{ count($veiculos) }}</h2>
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
