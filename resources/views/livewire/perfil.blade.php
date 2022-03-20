<div>
    <div  class="card">
        <div class="card-header">
    <div class="row">
        <div class="col-md-4">
            <h3 class="card-title">Informações do usuário</h3>
        </div>
        <div class="col-md-8">
            @if (session()->has('mensagem'))
            <div wire:poll.disable class="col-md-12 text-success">
                <i class="fas fa-check"></i>
                {{ session('mensagem') }}
            </div>
            @endif
        </div>
    </div>
            
        </div>
        <form method="POST" class="form-horizontal" action="{{ route('update') }}" >
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nome</label>
                    <div class="col-sm-10">
                        <input value="{{ $user->name }}"  type="text" name="name" class="form-control @error('email') is-invalid @enderror" placeholder="Nome">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input value="{{ $user->email }}"  type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info">Editar</button>
            </div>
        </form>
        
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                    <h3 class="card-title">Cadastrar nova senha</h3>
                </div>
                <div class="col-md-8">
                    @if (session()->has('mensagem-password'))
                    <div wire:poll.disable class="col-md-12 text-success">
                        <i class="fas fa-check"></i>
                        {{ session('mensagem-password') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <form class="form-horizontal" method="POST" action="{{ route('update-password') }}">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Nova Senha</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Nova senha">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Confirmar nova senha</label>
                    <div class="col-sm-10">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmação da nova senha">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info">Cadastrar</button>
            </div>
        </form>
    </div>
</div>
