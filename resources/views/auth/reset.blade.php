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
        <p class="login-box-msg">Please fill out all fields to set a new Password</p>
        <form role="form" method="POST" action="{{ URL::action('Auth\PasswordController@postReset') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="token" value="{{ $token }}">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Retype password" name="password_confirmation"/>
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Reset Password</button>
            </div><!-- /.col -->
          </div>
        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

{{-- auth.footer is a stub for a few things JS related --}}
@include('auth.footer')
  </body>
@endsection
