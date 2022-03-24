<div>
    <div class="row">
        <div class="col-md-6">
            <input class="form-control mb-2" type="search" wire:model="search" placeholder="Pesquisar">
        </div>
        <div class="col-md-6 text-right mb-2">
            <button data-toggle="modal" data-target="#cadastrar-veiculo" class="btn btn-sm btn-info">
                <i class="fas fa-plus-circle"></i>
                CADASTRAR VEÍCULO
            </button>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <h3 class="card-title">Veículos cadastrados</h3>
                        </div>
                        <div class="col-md-9">
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
                    <div class="row">
                        @foreach ($veiculos as $veiculo)
                            <div class="col-md-4">
                                @if ($veiculo->status == 'Manutencao')
                                    <div class="ribbon-wrapper ribbon-xl">
                                        <div class="ribbon bg-warning">
                                            Em manutenção/revisão
                                        </div>
                                    </div>
                                @endif
                                <div style="background-color: #ebe4e4;"
                                    class="card card-widget widget-user-2 shadow-sm">

                                    <div class="widget-user-header">
                                        <img width="100%" height="200"
                                            src="{{ asset('/storage/' . $veiculo->imagem) }}" alt="">
                                        <div data-toggle="modal" data-target="#editar-imagem"
                                            wire:click="updateImagem({{ $veiculo->id }})" style="cursor: pointer;">
                                            <i class="far fa-edit"></i>
                                            Editar Imagem
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <h3>{{ $veiculo->name }}</h3>
                                        <p>Placa: {{ $veiculo->placa }}</p>
                                    </div>
                                    <div class="card-footer p-0">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a wire:click.prevent="atualizaKm({{ $veiculo->id }})"
                                                    style="cursor: pointer;" class="nav-link h5">
                                                    Quilometros Rodados <span
                                                        class="float-right badge bg-primary">{{ number_format($veiculo->km_rodado, 0, ',', '.') }}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item p-2 text-center">
                                                <button wire:click.prevent="updateStatus({{ $veiculo->id }})"
                                                    data-toggle="modal" data-target="#alterar-status"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-edit"></i>
                                                    Alterar status
                                                </button>
                                                <button wire:click="update({{ $veiculo->id }})" data-toggle="modal"
                                                    data-target="#editar-veiculo" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                    Editar
                                                </button>
                                                <button wire:click="delete({{ $veiculo->id }})" data-toggle="modal"
                                                    data-target="#modal-delete" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                    Excluir
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer bg-white">
                    {{ $veiculos->links() }}
                </div>
            </div>

        </div>
    </div>

    <!-- MODAL CADASTRO DE VEÍCULOS -->
    <div class="modal fade" wire:ignore.self data-backdrop="static" id="cadastrar-veiculo" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">

                    @if (session()->has('mensagem'))
                        <div wire:poll.disable class="text-center col-md-12 text-success">
                            <i class="fas fa-check"></i>
                            {{ session('mensagem') }}
                        </div>
                    @endif

                </div>
                <form method="POST" wire:submit.prevent="create">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nome</label>
                                    <input wire:model="nome" type="text"
                                        class="form-control @error('nome') is-invalid @enderror">
                                    @error('nome')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Km da ultima revisão</label>
                                    <input wire:model="ultima_revisao" type="number"
                                        class="form-control @error('ultima_revisao') is-invalid @enderror">
                                    @error('ultima_revisao')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Placa</label>
                                    <input wire:model="placa" type="text" name="placa"
                                        class="form-control @error('placa') is-invalid @enderror">
                                    @error('placa')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Ano</label>
                                    <input wire:model="ano" type="number" name="ano"
                                        class="form-control @error('ano') is-invalid @enderror">
                                    @error('ano')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">KM Rodados</label>
                                    <input wire:model="km_rodados" type="number" name="km_rodados"
                                        class="form-control @error('km_rodados') is-invalid @enderror">
                                    @error('km_rodados')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">KM Limite para Revisão</label>
                                    <input wire:model="km_revisao" type="number" name="km_revisao"
                                        class="form-control @error('km_revisao') is-invalid @enderror">
                                    @error('km_revisao')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label for="">Situação do veículo</label>
                                <select wire:model="status" name="status"
                                    class="form-control @error('status') is-invalid @enderror">
                                    <option value="">Selecione a situação do veículo</option>
                                    <option value="Funcionando">Funcionando</option>
                                    <option value="Manutencao">Em manutenção/revisão</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Imagem</label>
                                    <input wire:model="imagem" type="file" name="imagem"
                                        class="form-control @error('imagem') is-invalid @enderror">
                                    @error('imagem')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button wire:click="resetAll" type="button" class="btn btn-secondary"
                            data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-info">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- FIM MODAL CADASTRO DE VEÍCULO -->


    <!-- MODAL EDITAR -->
    <div class="modal fade" wire:ignore.self data-backdrop="static" id="editar-veiculo" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">

                    @if (session()->has('mensagem'))
                        <div wire:poll.disable class="text-center col-md-12 text-success">
                            <i class="fas fa-check"></i>
                            {{ session('mensagem') }}
                        </div>
                    @endif

                </div>
                <form method="POST" wire:submit.prevent="updateAction">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nome</label>
                                    <input wire:model="nome" type="text"
                                        class="form-control @error('nome') is-invalid @enderror">
                                    @error('nome')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Km da ultima revisão</label>
                                    <input wire:model="ultima_revisao" type="number"
                                        class="form-control @error('ultima_revisao') is-invalid @enderror">
                                    @error('ultima_revisao')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Placa</label>
                                    <input wire:model="placa" type="text" name="placa"
                                        class="form-control @error('placa') is-invalid @enderror">
                                    @error('placa')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Ano</label>
                                    <input wire:model="ano" type="number" name="ano"
                                        class="form-control @error('ano') is-invalid @enderror">
                                    @error('ano')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">KM Rodados</label>
                                    <input wire:model="km_rodados" type="number" name="km_rodados"
                                        class="form-control @error('km_rodados') is-invalid @enderror">
                                    @error('km_rodados')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">KM Limite para Revisão</label>
                                    <input wire:model="km_revisao" type="number" name="km_revisao"
                                        class="form-control @error('km_revisao') is-invalid @enderror">
                                    @error('km_revisao')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label for="">Situação do veículo</label>
                                <select wire:model="status" name="status"
                                    class="form-control @error('status') is-invalid @enderror">
                                    <option value="">Selecione a situação do veículo</option>
                                    <option value="Funcionando">Funcionando</option>
                                    <option value="Manutencao">Em manutenção/revisão</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button wire:click="resetAll" type="button" class="btn btn-secondary"
                            data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-info">Editar</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- FIM MODAL EDITAR -->

    <!-- MODAL EDITAR KM -->
    <div class="modal fade" wire:ignore.self data-backdrop="static" id="modal-editar" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">

                    @if (session()->has('mensagem'))
                        <div wire:poll.disable class="text-center col-md-12 text-success">
                            <i class="fas fa-check"></i>
                            {{ session('mensagem') }}
                        </div>
                    @endif

                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="callout callout-info">
                            <h5 class="text-center">{{ $nome }}</h5>
                        </div>
                        <div class="form-group">
                            <label for="">KM Atual do Veículo</label>
                            <input wire:model="km_rodados" type="number" name="km_rodados"
                                class="form-control @error('km_rodados') is-invalid @enderror">
                            @error('km_rodados')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button wire:click="resetAll" type="button" class="btn btn-secondary"
                            data-dismiss="modal">Fechar</button>
                        <button wire:click.prevent="atualizaKmAction" class="btn btn-info">Atualizar km</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- FIM MODAL EDITAR KM -->

    <!-- MODAL EDITAR STATUS -->
    <div class="modal fade" wire:ignore.self data-backdrop="static" id="alterar-status" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">

                    @if (session()->has('mensagem'))
                        <div wire:poll.disable class="text-center col-md-12 text-success">
                            <i class="fas fa-check"></i>
                            {{ session('mensagem') }}
                        </div>
                    @endif

                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Status do veículo</label>
                            <select wire:model="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="Funcionando">Funcionando</option>
                                <option value="Manutencao">Em Manutenção/Revisão</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button wire:click="resetAll" type="button" class="btn btn-secondary"
                            data-dismiss="modal">Fechar</button>
                        <button wire:click.prevent="updateStatusAction" class="btn btn-info">Editar status</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- FIM MODAL EDITAR STATUS -->

    <!-- MODAL DE EXCLUIR-->
    <div class="modal fade" wire:ignore.self data-backdrop="static" id="modal-delete" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    @if (session()->has('mensagem-error'))
                        <div wire:poll.7000ms class="text-center col-md-12 text-danger">
                            {{ session('mensagem-error') }}
                        </div>
                    @endif
                </div>
                <div class="modal-body">
                    Deseja realmente excluir esse registro?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                    <button wire:click="destroy" class="btn btn-danger btn-sm">Confirmar</button>
                </div>

            </div>
        </div>
    </div><!-- FIM MODAL DE EXCLUIR -->

    <!-- MODAL DE EDITAR IMAGEM -->
    <div class="modal fade" wire:ignore.self data-backdrop="static" id="editar-imagem" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" wire:submit.prevent="updateImagemAction">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="text-center">{{ $nome }}</h3>
                                <div class="form-group">
                                    <label for="">Alterar imagem</label>
                                    <input wire:model="imagem" type="file" name="imagem"
                                        class="form-control @error('imagem') is-invalid @enderror">
                                    @error('imagem')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button wire:click="resetAll" type="button" class="btn btn-sm btn-secondary"
                            data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-info btn-sm">Editar</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- FIM MODAL DE EDITAR IMAGEM -->

</div>
