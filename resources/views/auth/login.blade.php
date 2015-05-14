@extends('auth.base')

@section('html_title', 'Login')

@section('content')
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a><b>SeIT</b>|Login</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <form role="form" method="POST" action="{{ URL::action('Auth\AuthController@postLogin') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">    
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox" name="remember"/> Remember Me
                </label>
              </div>                        
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>

        {{--<div class="social-auth-links text-center">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
          <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
        </div><!-- /.social-auth-links -->--}}

        <p><a href="{{ URL::action('Auth\PasswordController@getEmail') }}">I forgot my password</a><br/>
        <a href="{{ URL::action('Auth\AuthController@getRegister') }}" class="text-center">Register a new membership</a></p>
        <p><a href="{{ URL::action('Auth\SSOController@getInitLogin') }}" class="text-center"><img src="{!! URL::asset('img/EVE_SSO_Login_Buttons_Small_Black.png') !!}" alt="Login with EVE Account"/></a></p>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
{{-- auth.footer is a stub for a few things JS related --}}
@include('auth.footer')
  </body>
@endsection
