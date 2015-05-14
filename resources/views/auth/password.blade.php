@extends('auth.base')

@section('html_title', 'Reset Password')

@section('content')
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a><b>SeIT</b>|Reset Password</a>
      </div><!-- /.login-logo -->
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
      <div class="login-box-body">
        <p class="login-box-msg">Please enter your E-Mail to request a password reset</p>
        <form role="form" method="POST" action="{{ URL::action('Auth\PasswordController@postEmail') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Send Password Reset Link</button>
            </div><!-- /.col -->
          </div>
        </form>

        <a href="{{ URL::action('Auth\AuthController@getLogin') }}" class="text-center">I already have a membership</a><br/>
        <a href="{{ URL::action('Auth\AuthController@getRegister') }}" class="text-center">Register a new membership</a>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
{{-- auth.footer is a stub for a few things JS related --}}
@include('auth.footer')
  </body>
@endsection
