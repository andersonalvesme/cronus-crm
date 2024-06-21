<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{settings()->application_name}}</title>
    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
</head>
<body class="antialiased border-top-wide border-primary d-flex flex-column">
<div class="flex-fill d-flex flex-column justify-content-center">
    <div class="container-tight py-6">
        <div class="text-center mb-4">
            <img src="{{asset('../images/apple-touch-icon.png')}}" height="36" alt="">
            <span class="h1 align-middle pl-2">Cronus</span>
        </div>
        <form class="card card-md" action="/register" method="POST">
            <input type="hidden" name="_token" value="{{csrf_token()}}">

            <div class="card-body">
                <h2 class="mb-5 text-center">{{__('auth.create_an_account')}}</h2>
                <div class="mb-3">
                    <label class="form-label">{{__('lang.name')}}</label>
                    <input type="text" name="name" value="{{old('name')}}" class="form-control">
                    @if($errors->has('name'))
                        <small class="invalid-feedback">{{$errors->first('name')}}</small>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">{{__('lang.email')}}</label>
                    <input type="text" name="email" value="{{old('email')}}" class="form-control">
                    @if($errors->has('email'))
                        <small class="invalid-feedback">{{$errors->first('email')}}</small>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">{{__('lang.password')}}</label>
                    <input type="password" name="password" class="form-control">
                    @if($errors->has('password'))
                        <small class="invalid-feedback">{{$errors->first('password')}}</small>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">{{__('lang.password_confirmation')}}</label>
                    <input type="password" name="password_confirmation" class="form-control">
                    @if($errors->has('password_confirmation'))
                        <small class="invalid-feedback">{{$errors->first('password_confirmation')}}</small>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">{{__('lang.number_of_users')}}</label>
                    <input type="number" name="active_users_limit" class="form-control"
                           value="{{ isset($_GET['active_users_limit']) ? $_GET['active_users_limit'] : 5 }}"
                           min="1" max="100">
                    @if($errors->has('active_users_limit'))
                        <small class="invalid-feedback">{{$errors->first('active_users_limit')}}</small>
                    @endif
                </div>
                <div class="mb-3">
                    <input type="submit" value="{{__('lang.register')}}" class="btn btn-primary btn-block">
                </div>
            </div>
        </form>

        <div class="text-center text-muted mb-8">
            {{__('auth.already_have_an_account')}}? <a href="{{ url('login') }}">{{__('lang.login')}}</a>
        </div>
    </div>
</div>
</body>
</html>
