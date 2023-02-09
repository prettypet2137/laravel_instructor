@extends('themes::default.layout')
@section('content')


    <!-- Header -->
    <header class="ex-header">
      <div class="container">
          <div class="row">
              <div class="col-xl-10 offset-xl-1">
                  <h1 class="text-center">@lang('Sign Up')</h1>
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
                    <p class="mb-4"><a href="{{ route('login') }}">@lang('Already have account?')</a></p>
                      <form class="actionLogin mb-2" action="{{ route('register') }}" method="post">
                        @csrf
                        <div class="form-group">
                          <input class="form-control-input" placeholder="Name" type="text" name="name"  required="">
                          <!--<label class="label-control" for="name">@lang('Name')</label>-->
                        </div>
                        <div class="form-group">
                          <input class="form-control-input" placeholder="Email" type="text" name="email" required="">
                          <!--<label class="label-control" for="email">@lang('Email')</label>-->
                        </div>
                        <div class="form-group">
                          <input class="form-control-input" placeholder="Password" type="password" name="password" required="">
                          <!--<label class="label-control" for="password">@lang('Password')</label>-->
                        </div>
                        <div class="form-group">
                          <input class="form-control-input" placeholder="Confirm Password" type="password" name="password_confirmation" required="">
                          <!--<label class="label-control" for="password_confirmation">@lang('Confirm Password ')</label>-->
                        </div>
                        
                      @if(config('recaptcha.api_site_key') && config('recaptcha.api_secret_key'))
                      <div class="form-group">
                        {!! htmlFormSnippet() !!}
                        @if ($errors->has('g-recaptcha-response'))
                        <div class="text-red mt-1">
                          <small><strong>{{ $errors->first('g-recaptcha-response') }}</strong></small>
                        </div>
                        @endif
                      </div>
                      @endif
                      @if($errors->any())
                      <div class="alert alert-danger">
                        <ul class="list-unstyled mb-0">
                          @foreach ($errors->all() as $error)
                          <li> <i class="fas fa-times text-danger mr-2"></i> {{ $error }}</li>
                          @endforeach
                        </ul>
                      </div>
                      @endif
                      <button class="form-control-submit-button mb-2" type="submit">@lang('Sign Up')</button>
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
@if(config('recaptcha.api_site_key') && config('recaptcha.api_secret_key'))
  @push('head')
  {!! htmlScriptTagJsApi() !!}
  @endpush
@endif
@endsection
