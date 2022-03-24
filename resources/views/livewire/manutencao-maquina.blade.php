<div>
    <div class="row">
        <div class="col-md-12 text-right mb-2">
            <button data-toggle="modal" data-target="#cadastrar-manutencao" class="btn btn-sm btn-info">
                <i class="fas fa-plus-circle"></i>
                LANÇAR MANUTENÇÃO/REVISÃO
            </button>
        </div>
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
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>

                                            <button data-toggle="modal" data-target="#modal-enviar-aprovacao"
                                                title="Enviar para aprovação" class="btn btn-sm btn-primary">
                                                <i class="fas fa-file-import"></i>
                                            </button>

                                            <button title="Ver detalhes" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <button data-toggle="modal" data-target="#modal-aprovacao" title="Aprovar"
                                                class="btn btn-sm btn-success">
                                                <i class="fas fa-check"></i>
                                            </button>

                                            <button title="Editar" class="btn btn-sm btn-warning">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <button data-toggle="modal" data-target="#modal-delete" title="Excluir"
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

        <!----------------------- MANUTENÇÕES ENVIADAS PARA VEIRIFICAÇÃO --------------->
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
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
                                    <th>Descrição</th>
                                    <th>Cadastrado por</th>
                                    <th>Veiculo</th>
                                    <th>Data de cadastro</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <button data-toggle="modal" data-target="#modal-enviar-aprovacao"
                                            title="Enviar para aprovação" class="btn btn-sm btn-primary">
                                            <i class="fas fa-file-import"></i>
                                        </button>
                                        <button title="Ver detalhes" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button data-toggle="modal" data-target="#modal-aprovacao" title="Aprovar"
                                            class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button title="Editar" class="btn btn-sm btn-warning">
                                            <i class="far fa-edit"></i>
                                        </button>
                                        <button data-toggle="modal" data-target="#modal-delete" title="Excluir"
                                            class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!------------FIM MANUTENÇÃO ENVIADAS PARA VERIFICAÇÃO ---------------->


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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Descrição manutenção/revisão</label>
                                <input required wire:model="descricao_manutencao" type="text"
                                    name="descricao_manutencao"
                                    class="form-control @error('descricao_manutencao') is-invalid @enderror">
                                @error('descricao_manutencao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Máquinas</label>
                            <select required wire:model="maquina_id" name="maquina_id"
                                class="form-control @error('maquina_id') is-invalid @enderror">
                                <option value="">Selecione uma máquina</option>
                                @foreach ($maquinas as $maquina)
                                    <option value="{{ $maquina->id }}">{{ $maquina->name }}</option>
                                @endforeach
                            </select>
                            @error('maquina_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="">Tipo de Manutenção</label>
                            <select required wire:model="tipo_manutencao" name="tipo_manutencao"
                                class="form-control @error('tipo_manutencao') is-invalid @enderror">
                                <option value="">Selecione o tipo de manutenção</option>
                                <option value="1">Revisão periódica</option>
                                <option value="2">Máquina apresentou defeito</option>
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
                                <textarea wire:model="justificativa" required type="text" name="justificativa"
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
                                    <input wire:model="servico" required type="text" name="servico"
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
                                    <table class="table table-sm table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Descrição do serviço</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($servicos as $servico)
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


</div>
