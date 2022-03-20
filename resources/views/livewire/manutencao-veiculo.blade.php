<div>
    <div class="row">
        <div class="col-md-12 text-right mb-2">
            <button data-toggle="modal" data-target="#cadastrar-manutencao" class="btn btn-sm btn-info">
                <i class="fas fa-plus-circle"></i>
                LANÇAR MANUTENÇÃO/REVISÃO
            </button>
        </div>
    </div>

    <div class="row">
        <!----------------------- MANUTENÇÕES CADASTRADAS --------------->
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title">Manutençoes aguardando envio</h3>
                        </div>
                        <div class="col-md-4">
                            @if (session()->has('mensagem-sucesso'))
                                <div wire:poll.disable class="text-success">
                                    <i class="fas fa-check"></i>
                                    {{ session('mensagem-sucesso') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="card-body table-responsive p-0" style="max-height: 250px;">
                        <table class="table table-head-fixed text-nowrap table-sm">
                            <thead>
                                <tr>
                                    <th>Descrição</th>
                                    <th>Cadastrado por</th>
                                    <th>Veiculo</th>
                                    <th>Data de cadastro</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($manutencoesCadastradas as $cadastradas)
                                    <tr>
                                        <td>{{ $cadastradas->descricao_manutencao }}</td>
                                        @foreach ($cadastradas->user()->get() as $user)
                                            <td>{{ $user->name }}</td>
                                        @endforeach
                                        @foreach ($cadastradas->veiculo()->get() as $veiculo)
                                            <td>{{ $veiculo->name }}</td>
                                        @endforeach

                                        <td>
                                            {{ date('d/m/Y', strtotime($cadastradas->created_at)) }}
                                        </td>
                                        <td>
                                            @if (auth()->user()->perfil == 'Funcionario' || auth()->user()->perfil == 'Gerente')
                                                <button wire:click.prevent="enviarAprovacao({{ $cadastradas->id }})"
                                                    data-toggle="modal" data-target="#modal-enviar-aprovacao"
                                                    title="Enviar para aprovação" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-file-import"></i>
                                                </button>
                                            @endif
                                            <button wire:click="detalhes({{ $cadastradas->id }})" title="Ver detalhes"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if (auth()->user()->perfil == 'Administrador' || auth()->user()->perfil == 'Gerente')
                                                <button wire:click.prevent="aprovar({{ $cadastradas->id }})"
                                                    data-toggle="modal" data-target="#modal-aprovacao" title="Aprovar"
                                                    class="btn btn-sm btn-success">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                            <button wire:click.prevent="update({{ $cadastradas->id }})" title="Editar"
                                                class="btn btn-sm btn-warning">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <button wire:click.prevent="delete({{ $cadastradas->id }})"
                                                data-toggle="modal" data-target="#modal-delete" title="Excluir"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!------------FIM MANUTENÇÃO CADASTRADAS ---------------->



        <!----------MANUTENÇÕES ENVIADAS PARA APROVAÇÃO --------------->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title">Manutençoes enviadas para verificação</h3>
                        </div>
                        <div class="col-md-4">
                            @if (session()->has('mensagem-sucesso'))
                                <div wire:poll.disable class="text-success">
                                    <i class="fas fa-check"></i>
                                    {{ session('mensagem-sucesso') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="card-body table-responsive p-0" style="max-height: 250px;">
                        <table class="table table-head-fixed text-nowrap table-sm">
                            <thead>
                                <tr>
                                    <th>Cadastrado por</th>
                                    <th>Veiculo</th>
                                    <th>Status</th>
                                    <th>Data de criação</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($manutencoesEnviadas as $enviadas)
                                    <tr>
                                        @foreach ($enviadas->user()->get() as $user)
                                            <td>{{ $user->name }}</td>
                                        @endforeach
                                        @foreach ($enviadas->veiculo()->get() as $veiculo)
                                            <td>{{ $veiculo->name }}</td>
                                        @endforeach
                                        @if ($enviadas->status == 1)
                                            <td>
                                                <span class="badge bg-warning">
                                                    Aguardando aprovação
                                                </span>
                                            </td>
                                        @elseif ($enviadas->status == 2)
                                            <td>
                                                <span class="badge bg-success">
                                                    Aprovada
                                                </span>
                                            </td>
                                        @else
                                            <td>
                                                <span class="badge bg-danger">
                                                    Devolvido para correção
                                                </span>
                                            </td>
                                        @endif

                                        <td>
                                            {{ date('d/m/Y', strtotime($enviadas->created_at)) }}
                                        </td>
                                        <td>
                                            <button wire:click="detalhes({{ $enviadas->id }})" title="Ver detalhes"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if ($enviadas->status != 1)
                                                @if ($enviadas->status == 3 && auth()->user()->id == $enviadas->user_id)
                                                    <button wire:click.prevent="update({{ $enviadas->id }})"
                                                        title="Editar" class="btn btn-sm btn-warning">
                                                        <i class="far fa-edit"></i>
                                                    </button>
                                                    <button wire:click.prevent="delete({{ $enviadas->id }})"
                                                        data-toggle="modal" data-target="#modal-delete" title="Excluir"
                                                        class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                @endif
                                            @endif
                                            @if ($enviadas->status == 1 && (auth()->user()->perfil == 'Gerente' || auth()->user()->perfil == 'Administrador'))
                                                @if ($enviadas->user_id != auth()->user()->id)
                                                    <button wire:click.prevent="aprovar({{ $enviadas->id }})"
                                                        data-toggle="modal" data-target="#modal-aprovacao"
                                                        title="Aprovar" class="btn btn-sm btn-success">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button wire:click.prevent="devolver({{ $enviadas->id }})"
                                                        data-toggle="modal" data-target="#modal-devolucao"
                                                        title="Devolver" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-sign-out-alt"></i>
                                                    </button>
                                                @endif
                                            @endif
                                            @if ($enviadas->status == 3 && $enviadas->user_id == auth()->user()->id)
                                                <button wire:click.prevent="enviarAprovacao({{ $enviadas->id }})"
                                                    data-toggle="modal" data-target="#modal-enviar-aprovacao"
                                                    title="Enviar para aprovação" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-file-import"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="card-footer bg-white">
                    {{ $manutencoesEnviadas->links() }}
                </div>
            </div>
        </div>
        <!--------- FIM MANUTENÇÕES ENVIADAS PARA APROVAÇÃO -------------->



        <!-----------MANUTENÇÕES APROVADAS --------------->
        <div class="col-md-6">
            <select wire:model="searchAprovadas" class="form-control mb-2">
                <option value="">Todos os registros</option>
                @foreach ($veiculos as $veiculo)
                    <option value="{{ $veiculo->id }}">{{ $veiculo->name }} - Placa: {{ $veiculo->placa }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title">Manutençoes Aprovadas</h3>
                        </div>
                        <div class="col-md-4">
                            @if (session()->has('mensagem-sucesso'))
                                <div wire:poll.disable class="text-success">
                                    <i class="fas fa-check"></i>
                                    {{ session('mensagem-sucesso') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="card-body table-responsive p-0" style="max-height: 250px;">
                        <table class="table table-head-fixed text-nowrap table-sm">
                            <thead>
                                <tr>
                                    <th>Cadastrado por</th>
                                    <th>Veiculo</th>
                                    <th>Status</th>
                                    <th>Data de criação</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($manutencoesAprovadas as $aprovadas)
                                    <tr>
                                        @foreach ($aprovadas->user()->get() as $user)
                                            <td>{{ $user->name }}</td>
                                        @endforeach
                                        @foreach ($aprovadas->veiculo()->get() as $veiculo)
                                            <td>{{ $veiculo->name }}</td>
                                        @endforeach
                                        @if ($aprovadas->status == 1)
                                            <td>
                                                <span class="badge bg-warning">
                                                    Aguardando aprovação
                                                </span>
                                            </td>
                                        @elseif ($aprovadas->status == 2)
                                            <td>
                                                <span class="badge bg-success">
                                                    Aprovada
                                                </span>
                                            </td>
                                        @else
                                            <td>
                                                <span class="badge bg-danger">
                                                    Devolvido para correção
                                                </span>
                                            </td>
                                        @endif

                                        <td>
                                            {{ date('d/m/Y', strtotime($aprovadas->created_at)) }}
                                        </td>
                                        <td>
                                            <button wire:click="detalhes({{ $aprovadas->id }})" title="Ver detalhes"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if (auth()->user()->perfil == 'Administrador')
                                                <button wire:click.prevent="update({{ $aprovadas->id }})"
                                                    title="Editar" class="btn btn-sm btn-warning">
                                                    <i class="far fa-edit"></i>
                                                </button>
                                                <button wire:click.prevent="delete({{ $aprovadas->id }})"
                                                    data-toggle="modal" data-target="#modal-delete" title="Excluir"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="card-footer bg-white">
                    {{ $manutencoesAprovadas->links() }}
                </div>
            </div>
        </div>
        <!------ FIM MANUTENÇÕES APROVADAS --------->


    </div>

    <!--------------------------------------- MODAIS ---------------------------->

    <!-- MODAL CADASTRO DE MANUTENÇÃO/REVISÃO -->
    <div class="modal fade" wire:ignore.self data-backdrop="static" id="cadastrar-manutencao" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">

                    @if (session()->has('mensagem'))
                        <div wire:poll.disable class="text-center col-md-12 text-success">
                            <i class="fas fa-check"></i>
                            {{ session('mensagem') }}
                        </div>
                    @endif

                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="">Veículos</label>
                            <select wire:model="veiculo" name="veiculo"
                                class="form-control @error('veiculo') is-invalid @enderror">
                                <option value="">Selecione um veículo</option>
                                @foreach ($veiculos as $veiculo)
                                    <option value="{{ $veiculo->id }}">{{ $veiculo->name }} - placa:
                                        {{ $veiculo->placa }}</option>
                                @endforeach
                            </select>
                            @error('veiculo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                       
                        <div class="col-md-6 mb-3">
                            <label for="">Km Atual do Veículo</label>
                            <input wire:model="km_atual" type="number" name="km_atual"
                                class="form-control @error('km_atual') is-invalid @enderror">
                            @error('km_atual')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                       
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Descrição manutenção/revisão</label>
                                <input wire:model="descricao" type="text" name="descricao"
                                    class="form-control @error('descricao') is-invalid @enderror">
                                @error('descricao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="">Tipo de Manutenção</label>
                            <select wire:model="tipo_manutencao" name="tipo_manutencao"
                                class="form-control @error('tipo_manutencao') is-invalid @enderror">
                                <option value="">Selecione o tipo de manutenção</option>
                                <option value="1">Revisão periódica</option>
                                <option value="2">Veículo apresentou defeito</option>
                            </select>
                            @error('tipo_manutencao')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Justificativa</label>
                                <textarea wire:model="justificativa" type="text" name="justificativa"
                                    class="form-control @error('justificativa') is-invalid @enderror">
                                    </textarea>
                                @error('justificativa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Serviços realizados</label>
                                <div class="d-flex">
                                    <input wire:model="servico" type="text" name="servico"
                                        class="form-control mr-2 @error('servico') is-invalid @enderror">

                                    <button wire:click.prevent="addServico" class="btn btn-info">Adicionar</button>
                                </div>
                                @error('servico')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive p-0" style="max-height: 180px;">
                                    <table class="table table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Descrição do serviço</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($servicos_veiculo as $servico)
                                                <tr>
                                                    <td>{{ $servico->descricao }}</td>
                                                    <td>
                                                        <button
                                                            wire:click.prevent="deleteServico({{ $servico->id }})"
                                                            class="btn btn-sm btn-danger">
                                                            <i class="far fa-trash-alt"></i>
                                                            Excluir
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button wire:click.prevent="create" class="btn btn-info">Cadastrar</button>
                </div>

            </div>
        </div>
    </div><!-- FIM MODAL CADASTRO DE MANUTENÇÃO/REVISÃO -->

    <!-- MODAL EDIÇÃO DE MANUTENÇÃO/REVISÃO -->
    <div class="modal fade" wire:ignore.self data-backdrop="static" id="modal-editar" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">

                    @if (session()->has('mensagem'))
                        <div wire:poll.disable class="text-center col-md-12 text-success">
                            <i class="fas fa-check"></i>
                            {{ session('mensagem') }}
                        </div>
                    @endif

                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="">Veículos</label>
                            <select wire:model="veiculo" name="veiculo"
                                class="form-control @error('veiculo') is-invalid @enderror">
                                @foreach ($veiculos as $veiculo)
                                    <option value="{{ $veiculo->id }}">{{ $veiculo->name }} - placa:
                                        {{ $veiculo->placa }}</option>
                                @endforeach
                            </select>
                            @error('veiculo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Km do Veículo</label>
                            <input wire:model="km_atual" type="number" name="km_atual"
                                class="form-control @error('km_atual') is-invalid @enderror">
                            @error('km_atual')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Descrição manutenção/revisão</label>
                                <input wire:model="descricao" type="text" name="descricao"
                                    class="form-control @error('descricao') is-invalid @enderror">
                                @error('descricao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="">Tipo de Manutenção</label>
                            <select wire:model="tipo_manutencao" name="tipo_manutencao"
                                class="form-control @error('tipo_manutencao') is-invalid @enderror">
                                <option value="">Selecione o tipo de manutenção</option>
                                <option value="1">Revisão periódica</option>
                                <option value="2">Veículo apresentou defeito</option>
                            </select>
                            @error('tipo_manutencao')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Justificativa</label>
                                <textarea wire:model="justificativa" type="text" name="justificativa"
                                    class="form-control @error('justificativa') is-invalid @enderror">
                                 </textarea>
                                @error('justificativa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Serviços realizados</label>
                                <div class="d-flex">
                                    <input wire:model="servico" type="text" name="servico"
                                        class="form-control mr-2 @error('servico') is-invalid @enderror">

                                    <button wire:click.prevent="createReloadServico"
                                        class="btn btn-info">Adicionar</button>
                                </div>
                                @error('servico')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive p-0" style="max-height: 180px;">
                                    <table class="table table-sm table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Descrição do serviço</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($servicosManutencao as $key => $servico)
                                                <tr>
                                                    <td>{{ $servico }}</td>
                                                    <td>
                                                        <button wire:click.prevent="reloadServico({{ $key }})"
                                                            class="btn btn-sm btn-danger">
                                                            <i class="far fa-trash-alt"></i>
                                                            Excluir
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click="resetAll" type="button" class="btn btn-secondary"
                        data-dismiss="modal">Fechar</button>
                    <button wire:click.prevent="updateAction" class="btn btn-info">Editar</button>
                </div>

            </div>
        </div>
    </div><!-- FIM MODAL EDIÇÃO DE MANUTENÇÃO/REVISÃO -->

    <!-- MODAL VISUALIZAR MANUTENÇÃO -->
    <div class="modal fade" id="modal-visualizar" wire:ignore.self data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Detalhes da manutenção</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Descrição da manutenção/revisão:</label>
                                <h5></h5>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Tipo de manutenção:</label>
                                <h5></h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Aprovado por:</label>
                                <h5>{{ $userAprovacao }}</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Devolvido por:</label>
                                <h5>{{ $userDevolucao }}</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Informações para correção:</label>
                                <p class="text-danger">{{ $justificativaDevolucao }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Serviços realizados:</label>
                                <ol>
                                    @foreach ($servicosManutencao as $key => $servico)
                                        <li>{{ $servico }}</li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click.prevent="resetAll" class="btn btn-info btn-sm"
                        data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!--- FIM MODAL VISUALIZAR MANUTENÇÃO -->

    <!-- MODAL DE CONFIRMAR ENVIO PARA APROVAÇÃO -->
    <div class="modal fade" id="modal-enviar-aprovacao" wire:ignore.self data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                </div>
                <div class="modal-body">
                    Confirma o envio para aprovação desse lançamento?
                </div>
                <div class="modal-footer">
                    <button wire:click.prevent="resetAll" type="button" class="btn btn-secondary"
                        data-dismiss="modal">Fechar</button>
                    <button wire:click.prevent="enviarAprovacaoAction" type="button"
                        class="btn btn-success">Confirmar</button>
                </div>
            </div>
        </div>
    </div><!-- FIM MODAL CONFIRMAR ENVIO PARA APROVAÇÃO -->

    <!-- MODAL DE CONFIRMAR APROVAÇÃO -->
    <div class="modal fade" id="modal-aprovacao" wire:ignore.self data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                </div>
                <div class="modal-body">
                    Confirma a aprovação desse lançamento?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button wire:click.prevent="aprovarAction" type="button" class="btn btn-success">Confirmar</button>
                </div>
            </div>
        </div>
    </div><!-- FIM MODAL CONFIRMAR APROVAÇÃO -->

    <!-- MODAL DE DEVOLUÇÃO -->
    <div class="modal fade" id="modal-devolucao" wire:ignore.self data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                </div>
                <form method="post" wire:submit.prevent="devolverAction">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Justificativa de devolucão</label>
                            <textarea name="justificativaDevolucao" wire:model="justificativaDevolucao"
                                class="form-control  @error('justificativaDevolucao') is-invalid @enderror"></textarea>
                            @error('justificativaDevolucao')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button wire:click.prevent="resetAll" type="button" class="btn btn-secondary"
                            data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- FIM MODAL DE DEVOLUÇÃO -->

    <!-- MODAL DE EXCLUIR LANÇAMENTO -->
    <div class="modal fade" wire:ignore.self data-backdrop="static" id="modal-delete" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center"></div>
                <div class="modal-body">
                    Deseja realmente excluir esse registro?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                    <button wire:click="destroy({{ $idManutencao }})"
                        class="btn btn-danger btn-sm">Confirmar</button>
                </div>
            </div>
        </div>
    </div><!-- FIM MODAL DE EXCLUIR LANCAMENTO -->

</div>
