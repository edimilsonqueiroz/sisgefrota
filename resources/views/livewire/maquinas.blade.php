<div>
    <div class="row">
        <div class="col-md-6">
            <input wire:model="searchMaquinas" class="form-control mb-2" type="search" placeholder="Pesquisar">
        </div>
        <div class="col-md-6 text-right mb-2">
            <button data-toggle="modal" data-target="#cadastrar-maquinas" class="btn btn-sm btn-info">
                <i class="fas fa-plus-circle"></i>
                CADASTRAR MÁQUINA
            </button>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <h3 class="card-title">Máquinas Cadastradas</h3>
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
                        @foreach ($maquinas as $maquina)
                            <div class="col-md-4">
                                @if ($maquina->status == 'Manutencao')
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
                                            src="{{ asset('/storage/' . $maquina->imagem) }}" alt="">
                                        <div wire:click.prevent="updateImagem({{ $maquina->id }})" data-toggle="modal" data-target="#editar-imagem" style="cursor: pointer;">
                                            <i class="far fa-edit"></i>
                                            Editar Imagem
                                        </div>
                                    </div>
                                    <div class="text-center mb-3">
                                        <h3>{{ $maquina->name }}</h3>
                                    </div>
                                    <div class="card-footer p-0">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a wire:click.prevent="updateHorimetro({{ $maquina->id }})" style="cursor: pointer;" class="nav-link h5">
                                                    Horimetro Total
                                                    <span class="float-right badge bg-primary">
                                                        {{ 
                                                            number_format($maquina->horas_trabalhadas, 0, ',', '.').' Horas' 
                                                        }}
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="nav-item p-2 text-center">
                                                <button wire:click.prevent="updateStatus({{ $maquina->id }})"
                                                    data-toggle="modal" data-target="#alterar-status"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-edit"></i>
                                                    Alterar status
                                                </button>
                                                <button wire:click.prevent ="update({{ $maquina->id }})" data-toggle="modal" data-target="#editar-maquina"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                    Editar
                                                </button>
                                                <button wire:click="delete({{ $maquina->id }})" data-toggle="modal"
                                                    data-target="#modal-delete"
                                                    class="btn btn-sm btn-danger">
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
                    {{ $maquinas->links() }}
                </div>
            </div>

        </div>
    </div>

    <!-------------------------------- MODAIS ---------------------------------------->

    <!-- MODAL CADASTRO DE MÁQUINA -->
    <div class="modal fade" wire:ignore.self data-backdrop="static" id="cadastrar-maquinas" tabindex="-1"
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
                <form method="post" wire:submit.prevent="create">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">Nome da máquina</label>
                                    <input required wire:model="name" type="text" class="form-control">
                                    @error('name')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Ano</label>
                                    <input required wire:model="ano" type="number" class="form-control">
                                    @error('ano')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <fieldset class="border p-2 pt-0">
                                        <legend style="font-size:16px;" class="text-center">
                                            <label for="">Horimetro atual</label>
                                        </legend>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input min="1" required wire:model="horas_trabalhadas"
                                                    name="horas_trabalhadas" type="number" class="form-control mb-2"
                                                    placeholder="Horas">
                                                @error('horas_trabalhadas')
                                                    <span class="error text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <select wire:model="minutos_trabalhados" class="form-control mb-2">
                                                    <option value="0">Minutos</option>
                                                    @for ($i = 1; $i <= 59; $i++)
                                                        @if ($i < 10)
                                                            <option value="{{ $i }}">{{ '0' . $i }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $i }}">{{ $i }}
                                                            </option>
                                                        @endif
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <fieldset class="border p-2 pt-0">
                                        <legend style="font-size:16px;" class="text-center">
                                            <label for="">Horimetro ultima revisao</label>
                                        </legend>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input min="1" required wire:model="ultima_revisao"
                                                    name="ultima_revisao" type="number" class="form-control mb-2"
                                                    placeholder="Horas">
                                                @error('ultima_revisao')
                                                    <span class="error text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <select wire:model="minutos_ultima" class="form-control mb-2">
                                                    <option value="0">Minutos</option>
                                                    @for ($i = 1; $i <= 59; $i++)
                                                        @if ($i < 10)
                                                            <option value="{{ $i }}">{{ '0' . $i }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $i }}">{{ $i }}
                                                            </option>
                                                        @endif
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">

                                    <fieldset class="border p-2 pt-0">
                                        <legend style="font-size:16px;" class="text-center">
                                            <label for="">Horimetro limite revisão</label>
                                        </legend>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input required wire:model="limite_revisao" name="limite_revisao"
                                                    type="number" min="1" class="form-control mb-2" placeholder="Horas">
                                                @error('limite_revisao')
                                                    <span class="error text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <select wire:model="minutos_limite" class="form-control mb-2">
                                                    <option value="0">Minutos</option>
                                                    @for ($i = 1; $i <= 59; $i++)
                                                        @if ($i < 10)
                                                            <option value="{{ $i }}">{{ '0' . $i }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $i }}">{{ $i }}
                                                            </option>
                                                        @endif
                                                    @endfor
                                                </select>

                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Situação da máquina</label>
                                    <select required name="status" wire:model="status" class="form-control">
                                        <option value="">Selecione a situação da máquina</option>
                                        <option value="Funcionando">Funcionando</option>
                                        <option value="Manutencao">Em manutenção/revisão</option>
                                    </select>
                                    @error('status')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Selecione uma imagem</label>
                                    <input required wire:model="imagem" type="file" class="form-control">
                                    @error('imagem')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
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
    </div><!-- FIM MODAL CADASTRO DE MÁQUINA -->

    <!-- MODAL EDITAR MÁQUINA -->
    <div class="modal fade" wire:ignore.self data-backdrop="static" id="editar-maquina" tabindex="-1" role="dialog"
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
                <form method="post" wire:submit.prevent="updateAction">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Nome da máquina</label>
                                    <input required wire:model="name" type="text" class="form-control">
                                    @error('name')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <fieldset class="border p-2 pt-0">
                                        <legend style="font-size:16px;" class="text-center">
                                            <label for="">Horimetro atual</label>
                                        </legend>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input min="1" required wire:model="horas_trabalhadas"
                                                    name="horas_trabalhadas" type="number" class="form-control mb-2"
                                                    placeholder="Horas">
                                                @error('horas_trabalhadas')
                                                    <span class="error text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <select wire:model="minutos_trabalhados" class="form-control mb-2">
                                                    <option value="0">Minutos</option>
                                                    @for ($i = 1; $i <= 59; $i++)
                                                        @if ($i < 10)
                                                            <option value="{{ $i }}">{{ '0' . $i }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $i }}">{{ $i }}
                                                            </option>
                                                        @endif
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <fieldset class="border p-2 pt-0">
                                        <legend style="font-size:16px;" class="text-center">
                                            <label for="">Horimetro ultima revisao</label>
                                        </legend>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input min="1" required wire:model="ultima_revisao"
                                                    name="ultima_revisao" type="number" class="form-control mb-2"
                                                    placeholder="Horas">
                                                @error('ultima_revisao')
                                                    <span class="error text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <select wire:model="minutos_ultima" class="form-control mb-2">
                                                    <option value="0">Minutos</option>
                                                    @for ($i = 1; $i <= 59; $i++)
                                                        @if ($i < 10)
                                                            <option value="{{ $i }}">{{ '0' . $i }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $i }}">{{ $i }}
                                                            </option>
                                                        @endif
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">

                                    <fieldset class="border p-2 pt-0">
                                        <legend style="font-size:16px;" class="text-center">
                                            <label for="">Horimetro limite revisão</label>
                                        </legend>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input required wire:model="limite_revisao" name="limite_revisao"
                                                    type="number" min="1" class="form-control mb-2"
                                                    placeholder="Horas">
                                                @error('limite_revisao')
                                                    <span class="error text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <select wire:model="minutos_limite" class="form-control mb-2">
                                                    <option value="0">Minutos</option>
                                                    @for ($i = 1; $i <= 59; $i++)
                                                        @if ($i < 10)
                                                            <option value="{{ $i }}">{{ '0' . $i }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $i }}">{{ $i }}
                                                            </option>
                                                        @endif
                                                    @endfor
                                                </select>

                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">Situação da máquina</label>
                                    <select required name="status" wire:model="status" class="form-control">
                                        <option value="">Selecione a situação da máquina</option>
                                        <option value="Funcionando">Funcionando</option>
                                        <option value="Manutencao">Em manutenção/revisão</option>
                                    </select>
                                    @error('status')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Ano</label>
                                    <input required wire:model="ano" type="number" class="form-control">
                                    @error('ano')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button wire:click.prevent="resetAll" type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-info">Editar</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- FIM MODAL EDITAR MÁQUINA -->

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
                            <select required wire:model="status" class="form-control">
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

        <!-- MODAL EDITAR HORIMETRO -->
        <div class="modal fade" wire:ignore.self data-backdrop="static" id="modal-editar" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog" role="document">
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
                            <h5 class="text-center">{{ $name }}</h5>
                        </div>
                        <div class="form-group">
                            <fieldset class="border p-2 pt-0">
                                <legend style="font-size:16px;" class="text-center">
                                    <label for="">Horimetro atual</label>
                                </legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input min="1" required wire:model="horas_trabalhadas"
                                            name="horas_trabalhadas" type="number" class="form-control mb-2"
                                            placeholder="Horas">
                                        @error('horas_trabalhadas')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <select wire:model="minutos_trabalhados" class="form-control mb-2">
                                            <option value="0">Minutos</option>
                                            @for ($i = 1; $i <= 59; $i++)
                                                @if ($i < 10)
                                                    <option value="{{ $i }}">{{ '0' . $i }}
                                                    </option>
                                                @else
                                                    <option value="{{ $i }}">{{ $i }}
                                                    </option>
                                                @endif
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button wire:click="resetAll" type="button" class="btn btn-secondary"
                            data-dismiss="modal">Fechar</button>
                        <button wire:click.prevent="updateHorimetroAction" class="btn btn-info">Atualizar km</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- FIM MODAL EDITAR HORIMETRO -->

    <!-- MODAL DE EDITAR IMAGEM -->
    <div class="modal fade" wire:ignore.self data-backdrop="static" id="editar-imagem" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" wire:submit.prevent="updateImagemAction">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="text-center">{{ $name }}</h3>
                                <div class="form-group">
                                    <label for="">Alterar imagem</label>
                                    <input required wire:model="imagem" type="file" name="imagem"
                                        class="form-control">
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

     <!-- MODAL DE EXCLUIR-->
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
                 <button wire:click="destroy" class="btn btn-danger btn-sm">Confirmar</button>
             </div>

         </div>
     </div>
 </div><!-- FIM MODAL DE EXCLUIR -->

</div>
