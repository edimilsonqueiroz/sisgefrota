<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="7AGnndlirhGLrdmCIpBEivv0reIhYHcuOVpEWJ2X">
    <title>SISGEFROTA</title>
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</head>

<style type="text/css">
    body {
        background-image: url('imagens/fundo.jpg');
        background-size: cover;
        background-repeat: no-repeat;
    }
</style>

<body class="login-page">
    <div class="login-box">
        <div class="login-logo"></div>
        <div class="card">
            <div class="card-header ">
                <img height="100" width="100%" src="{{ asset('imagens/logomarca.jpg') }}" alt="">
            </div>
            <div class="card-body login-card-body ">
                <form action="{{ route('authenticate') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="Email" autofocus>
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
                    <div class="input-group mb-3">
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Senha">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock "></span>
                            </div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-7">
                            <div class="icheck-primary"
                                title="Keep me authenticated indefinitely or until I manually logout">
                                <input type="checkbox" name="remember" id="remember">
                                <label for="remember">
                                    Lembrar-me
                                </label>
                            </div>
                        </div>
                        <div class="col-5">
                            <button style="background: #712419; border:#712419;" type=submit
                                class="btn btn-lg btn-primary">
                                <span class="fas fa-sign-in-alt"></span>
                                Entrar
                            </button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="card-footer bg-white">
                <p class="my-0">
                    <a style="color:#712419;" href="{{ route('reset-render') }}">Esqueci minha senha</a>
                </p>
                <p class="my-0 mb-3">
                    <a></a>
                </p>
            </div>

        </div>

    </div>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
