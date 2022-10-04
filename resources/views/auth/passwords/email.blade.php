@extends('auth.template')

@section('container')
    <form id="formEmail" class="form-validation card" role="form" method="POST" action="{{ url('password/email') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="card-body p-6">
            <div class="card-title">Esqueceu sua senha?</div>

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
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label class="form-label" for="txtEmail">E-mail</label>
                <input type="email" class="form-control" name="email" id="txtEmail" autocomplete="off" placeholder="E-mail" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block" tabindex="3">Recuperar senha</button>
        </div>
    </form>
    <div class="text-center text-muted">
        Lembrou sua senha? <a href="{{ url('login') }}">Acessar conta.</a>
    </div>

    <script type="text/javascript">
        $(function () {
            $('#txtEmail').focus();
            $('#formEmail').validate();
        });
    </script>
@endsection