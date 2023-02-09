@extends('themes::default.layout')
@section('content')

    <!-- Header -->
    <header class="ex-header">
      <div class="container">
          <div class="row">
              <div class="col-xl-10 offset-xl-1">
                  <h1 class="text-center">@lang('Log In')</h1>
              </div> <!-- end of col -->
          </div> <!-- end of row -->
      </div> <!-- end of container -->
  </header> <!-- end of ex-header -->
  <!-- end of header -->
  
  
  <!-- Basic -->
  <div class="ex-form-1 pt-5 pb-5">
      <div class="container">
          <div class="row">
              <div class="col-xl-6 offset-xl-3">
                  <div class="text-box mt-5 mb-5">
                      <p class="mb-4">@lang("You don't have a password? Then please") <a class="blue" href="{{ route('register') }}">@lang('Sign Up')</a></p>
                      <form class="actionLogin mb-2" action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="form-group">
                          <input class="form-control-input" placeholder="@lang('Email')" type="text" name="email" required="">
                        </div>
                        <div class="form-group">
                          <input class="form-control-input" placeholder="@lang('Password')" type="password" name="password" required="">
                        </div>
                        
                        <div class="d-flex mb-4 align-items-center">
                          <label class="control control--checkbox mb-0"><span class="caption">@lang("Remember me")</span>
                          <input type="checkbox" id="rememberMe" name="remember"  checked="checked"/>
                          <div class="control__indicator"></div>
                        </label>
                        <span class="ml-auto">
                          <a class="forgot-pass" href="{{ route('password.request') }}">@lang('I forgot password')</a>
                        </span>
                      </div>
                      @if($errors->any())
                      <div class="alert alert-danger">
                        <ul class="list-unstyled mb-0">
                          @foreach ($errors->all() as $error)
                          <li> <i class="fas fa-times text-danger mr-2"></i> {{ $error }}</li>
                          @endforeach
                        </ul>
                      </div>
                      @endif
                      <button class="form-control-submit-button mb-2" type="submit">@lang('Log In')</button>
                      
                    </form>
                    <div class="social-login">
                      @if(config('services.facebook.client_id') && config('services.facebook.client_secret'))
                      <a href="{{ route('login.social', 'facebook') }}" class="facebook btn d-flex justify-content-center align-items-center">
                        <span class="icon-facebook mr-3"></span> @lang('Login with Facebook')
                      </a>
                      @endif
                      @if(config('services.google.client_id') && config('services.google.client_secret'))
                      <a href="{{ route('login.social', 'google') }}" class="google btn d-flex justify-content-center align-items-center">
                        <span class="icon-google mr-3"></span> @lang('Login with Google')
                      </a>
                      @endif
                    </div>

                  </div> <!-- end of text-box -->
              </div> <!-- end of col -->
          </div> <!-- end of row -->
      </div> <!-- end of container -->
  </div> <!-- end of ex-basic-1 -->
  <!-- end of basic -->

@endsection