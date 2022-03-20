<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="n57AVSPQny0vxW8L97roWXcJkaHKyI24vIC9QZex">
    <title>Alterar senha</title>
    <link rel="stylesheet" href="{{ asset('/vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <style type="text/css">
        body {
            background-image: url('imagens/fundo.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }

    </style>
</head>

<body class="register-page">
    <div class="register-box">
        <div class="register-logo">
            <a></a>
        </div>
        <div class="card card-outline">
            <div class="card-header ">
                @if(session()->has('error'))
                    <div class="text-danger text-center">
                        {{ session('error') }}
                    </div>
                @elseif(session()->has('sucesso'))
                    <div class="text-success text-center">
                        <i class="fas fa-check"></i> 
                        {{ session('sucesso') }}
                    </div>
                @else
                    <h3 class="card-title float-none text-center mt-3 mb-3">
                        Informe o seu e-mail cadastrado
                    </h3>
                @endif
            </div>
            <div class="card-body register-card-body ">
                <form method="post" action="{{ route('reset-password') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope "></span>
                            </div>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button style="background: #712419; border:#712419;" type="submit"
                        class="btn btn-lg btn-info btn-block">
                        <span class="fas fa-user-plus"></span>
                        Alterar Senha
                    </button>
                </form>
            </div>
            <div class="card-footer ">
                <p class="my-0 mb-3">
                    <a style="color:#712419;" href="{{ route('login') }}">Voltar para o login</a>
                </p>
            </div>
        </div>
    </div>
    <script src="{{ asset('/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('/vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
