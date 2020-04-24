@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'login-page')

@section('body')
    <div class="login-box">
        <div class="login-logo">
            <a href=" ">{!! config('adminlte.logo', ' ') !!}</a>
        </div>
        
        <div class="login-box-body" id="login-box-body">
            <p class="login-box-msg">Selamat Datang</p>
            <form action="{{ route('auth.login') }}" method="POST" id="form_login" autocomplete="off">
                {!! csrf_field() !!}

                <div class="form-group @error('email') has-error @enderror">
                    <div class="inner-addon left-addon">
                        <i class="glyphicon glyphicon-envelope"></i> 
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                           id="email" placeholder="Alamat E-Mail">
                    </div>
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group @error('password') has-error @enderror">
                    <div class="inner-addon left-addon">
                        <i class="glyphicon glyphicon-lock"></i> 
                        <input type="password" name="password" class="form-control"
                           id="password" placeholder="Password E-Mail">
                    </div>
                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-xs-4 col-xs-push-8">
                        <button type="submit" class="btn btn-primary btn-block btn-flat" name="submit" id="btn-login">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('adminlte_js')
    <script src="{{ asset('js/my/login.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
    @yield('js')
@stop
