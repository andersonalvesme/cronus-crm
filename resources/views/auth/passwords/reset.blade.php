@extends('auth.template')

@section('container')
    <form id="formResetar" class="form-validation" role="form" method="POST" action="{{ url('/password/reset') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="token" value="{{ isset($token) ? $token : '' }}">
        <input type="hidden" name="email" value="{{ isset($email) ? $email : '' }}">

        @if (isset($status))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                {!! $status !!}
            </div>
        @endif

        @if (count($errors) > 0)
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <input type="password" class="form-control" name="password" required minlength="6" id="txtSenha" placeholder="Digite sua nova senha">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password_confirmation" id="txtRepetirSenha" equalTo="#txtSenha" placeholder="Repetir sua nova senha">
        </div>
        <button type="submit" class="btn btn-dark btn-block">Alterar senha</button>
    </form>
    <div class="m-b-lg m-t-xxl text-center">
        <a href="{{ url('login') }}" class="h5 text-muted underline">Voltar para tela de acesso.</a>
    </div>
    <div class="text-center">
        <p>
            <small class="text-muted">Visão Sistemas<br>&copy; 2016</small>
        </p>
    </div>

    <script type="text/javascript">
        $(function () {
            $('#txtSenha').focus();
            $('#formResetar').validate();
        });
    </script>
@endsection