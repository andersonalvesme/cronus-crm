<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{settings()->get('application_name')}}</title>
    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
</head>
<body class="antialiased border-top-wide border-primary d-flex flex-column">
<div class="flex-fill d-flex flex-column justify-content-center">
    <div class="container-tight py-6">
        <div class="text-center mb-4">
            <img src="{{asset('../images/apple-touch-icon.png')}}" height="36" alt="">
            <span class="h1 align-middle pl-2">Cronus</span>
        </div>
        <form class="card card-md" action="/login" method="POST">
            <input type="hidden" name="_token" value="{{csrf_token()}}">

            <div class="card-body">
                <h2 class="mb-5 text-center">Acesse sua conta</h2>

                <div class="mb-3">
                    <label class="form-label">{{__('lang.email')}}</label>
                    <input type="text" name="email" value="{{old('email')}}" class="form-control">
                    @if($errors->has('email'))
                        <small class="invalid-feedback">{{$errors->first('email')}}</small>
                    @endif
                </div>
                <div class="form-group">
                    <label class="form-label">{{__('lang.password')}}
{{--                        <span class="form-label-description">--}}
{{--                            <a href="{{ url('password/reset') }}">Esqueci minha senha</a>--}}
{{--                        </span>--}}
                    </label>
                    <input type="password" name="password" class="form-control">
                    @if($errors->has('password'))
                        <small class="invalid-feedback">{{$errors->first('password')}}</small>
                    @endif
                </div>
                <div class="form-footer">
                    <input type="submit" value="{{__('lang.login')}}" class="btn btn-primary btn-block">
                </div>
            </div>
        </form>
        <div class="text-center text-muted">
            Não possui uma conta? <a href="{{ url('register') }}" tabindex="-1">Cadastre-se</a>
        </div>
    </div>
</body>
</html>
