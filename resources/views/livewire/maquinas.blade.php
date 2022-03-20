<div>
    <div class="row">
        <div class="col-md-6">
            <input class="form-control mb-2" type="search" wire:model="search" placeholder="Pesquisar">
        </div>
        <div class="col-md-6 text-right mb-2">
            <button data-toggle="modal" data-target="#cadastrar-maquina" class="btn btn-sm btn-info">
                <i class="fas fa-plus-circle"></i>
                CADASTRAR MÁQUINA
            </button>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <h3 class="card-title">Máquinas cadastrados</h3>
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
                        <div class="col-md-4">
                            <div style="background-color: #ebe4e4;" class="card card-widget widget-user-2 shadow-sm">

                                <div class="widget-user-header">
                                    <div data-toggle="modal" data-target="#editar-imagem" style="cursor: pointer;">
                                        <i class="far fa-edit"></i>
                                        Editar Imagem
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h3>Maquina 1</h3>
                                    <p>MVT2030</p>
                                </div>
                                <div class="card-footer p-0">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a style="cursor: pointer;" class="nav-link h5">
                                                Horimetro
                                                <span class="float-right badge bg-primary">15000</span>
                                            </a>
                                        </li>
                                        <li class="nav-item p-2 text-center">
                                            <button data-toggle="modal" data-target="#editar-veiculo"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                                Editar
                                            </button>
                                            <button data-toggle="modal" data-target="#modal-delete"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                                Excluir
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer bg-white">
                    ...
                </div>
            </div>
        </div>
    </div>


    <!--------------------------------- MODAIS ------------------------------------------->


    <!-- MODAL CADASTRO DE MAQUINAS -->
    <div class="modal fade" wire:ignore.self data-backdrop="static" id="cadastrar-maquina" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">

                    @if (session()->has('mensagem'))
                        <div wire:poll.disable class="text-center col-md-12 text-success">
                            <i class="fas fa-check"></i>
                            {{ session('mensagem') }}
                        </div>
                    @endif

                </div>
                <form method="POST" wire:submit.prevent="createMaquina">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Nome</label>
                                    <input wire:model="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="Descrição completa da máquina">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">Horimetro atual</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input wire:model="horas_trabalhadas" type="number"
                                                class="form-control @error('horas_trabalhadas') is-invalid @enderror"
                                                placeholder="Horas">
                                            @error('horas_trabalhadas')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <input wire:model="minutos_trabalhados" type="number" class="form-control"
                                                placeholder="Minutos">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Ano</label>
                                    <input wire:model="ano" type="text"
                                        class="form-control @error('ano') is-invalid @enderror" placeholder="Ano">
                                    @error('ano')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Horimetro limite revisão</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input wire:model="horas_limite_revisao" type="number"
                                                class="form-control @error('horas_limite_revisao') is-invalid @enderror" placeholder="Horas">
                                            @error('horas_limite_revisao')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <input wire:model="minutos_limite_revisao" type="number"
                                                class="form-control" placeholder="Minutos">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Horimetro ultima revisão</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input wire:model="horas_ultima_revisao" type="number"
                                                class="form-control @error('horas_ultima_revisao') is-invalid @enderror" placeholder="Horas">
                                            @error('horas_ultima_revisao')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <input wire:model="minutos_ultima_revisao" type="number"
                                            class="form-control" placeholder="Minutos">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Situação do veículo</label>
                                <select wire:model="status" name="status"
                                    class="form-control @error('status') is-invalid @enderror">
                                    <option value="">Selecione a situação da máquina</option>
                                    <option value="Funcionando">Funcionando</option>
                                    <option value="Manutencao">Em manutenção/revisão</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
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
    </div><!-- FIM MODAL CADASTRO DE MAQUINAS -->

</div>
