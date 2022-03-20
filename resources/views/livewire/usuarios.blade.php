<div>
    <div class="row">
        <div class="col-md-6">
            <input class="form-control mb-2" type="search" wire:model="search" placeholder="Pesquisar">
        </div>
        <div class="col-md-6 text-right mb-2">
            <button data-toggle="modal" data-target="#cadastrar-usuario" class="btn btn-sm btn-info">
                <i class="fas fa-plus-circle"></i>
                ADICIONAR USUÁRIO
            </button>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <h3 class="card-title">Usuários do Sistema</h3>
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

                <div class="card-body table-responsive p-0" style="max-height: 400px;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>

                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Perfil</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->perfil }}</td>
                                    <td>
                                        <button wire:click="edit({{ $user->id }})" data-toggle="modal"
                                            data-target="#editar-usuario" class="btn btn-sm btn-warning">
                                            <i class="fas fa-user-edit"></i>
                                            Editar
                                        </button>
                                        <button wire:click="resetPassword({{ $user->id }})" data-toggle="modal"
                                            data-target="#alterar-senha" class="btn btn-sm btn-info">
                                            <i class="fas fa-power-off"></i>
                                            Resetar Senha
                                        </button>
                                        <button data-toggle="modal" data-target="#modal-delete"
                                            wire:click="delete({{ $user->id }})" class="btn btn-sm btn-danger">
                                            <i class="far fa-trash-alt"></i>
                                            Excluir
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white">
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>


    <!-- MODAL CADASTRO DE USUÁRIO -->
    <div class="modal fade" wire:ignore.self data-backdrop="static" id="cadastrar-usuario" tabindex="-1"
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
                                    <input wire:model="name" type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">CPF</label>
                                    <input wire:model="cpf" type="text" name="cpf"
                                        class="form-control @error('cpf') is-invalid @enderror">
                                    @error('cpf')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">email</label>
                                    <input wire:model="email" type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Perfil</label>
                                <select wire:model="perfil" name="perfil"
                                    class="form-control @error('perfil') is-invalid @enderror">
                                    <option value="">Selecione um perfil</option>
                                    <option value="Gerente">Gerente</option>
                                    <option value="Funcionario">Funcionário</option>
                                </select>
                                @error('perfil')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-info">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- FIM MODAL CADASTRO DE USUÁRIO -->



    <!-- MODAL EDITAR USUÁRIO -->
    <div class="modal fade" wire:ignore.self data-backdrop="static" id="editar-usuario" tabindex="-1" role="dialog"
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
                <form method="POST" wire:submit.prevent="editAction({{ $userId }})">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nome</label>
                                    <input wire:model="name" type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">CPF</label>
                                    <input wire:model="cpf" type="text" name="cpf"
                                        class="form-control @error('cpf') is-invalid @enderror">
                                    @error('cpf')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">email</label>
                                    <input wire:model="email" type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Perfil</label>
                                <select name="perfil" class="form-control @error('perfil') is-invalid @enderror">
                                    @if ($perfil == 'Gerente')
                                        <option selected value="Gerente">Gerente</option>
                                        <option value="Funcionario">Funcionário</option>
                                    @else
                                        <option value="Gerente">Gerente</option>
                                        <option selected value="Funcionario">Funcionário</option>
                                    @endif
                                </select>
                                @error('perfil')
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
    </div><!-- FIM MODAL EDITAR USUÁRIO -->

    <!-- MODAL DE EXCLUIR USUÁRIO -->
    <div class="modal fade" wire:ignore.self data-backdrop="static" id="modal-delete" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header text-center">

                </div>

                <div class="modal-body">
                    Deseja realmente excluir esse usuário?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                    <button wire:click="destroy({{ $userId }})" class="btn btn-danger btn-sm">Confirmar</button>
                </div>

            </div>
        </div>
    </div><!-- FIM MODAL DE EXCLUIR USUÁRIO -->


    <!-- MODAL DE RESETAR SENHA DO USUÁRIO -->
    <div class="modal fade" wire:ignore.self data-backdrop="static" id="alterar-senha" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header text-center">

                </div>

                <div class="modal-body">
                    Deseja realmente resetar a senha do usuário para padrão?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                    <button wire:click="resetPasswordAction({{ $userId }})"
                        class="btn btn-info btn-sm">Confirmar</button>
                </div>

            </div>
        </div>
    </div><!-- FIM MODAL DE RESETAR SENHA DO USUÁRIO -->


</div>
