@extends('themes::default.layout')
@section('content')
    <!-- Header -->
    <header class="ex-header">
      <div class="container">
          <div class="row">
              <div class="col-xl-10 offset-xl-1">
                  <h1 class="text-center">@lang('Reset Password')</h1>
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
                      <p class="text-muted mb-4">@lang("Enter new password!")</p>
                      <form class="actionLogin mb-2" action="{{ route('password.update') }}" method="post">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                          <input class="form-control-input" type="text" name="email" value="{{ old('email') }}" required="">
                          <label class="label-control" for="email">@lang('Email')</label>
                        </div>
                        <div class="form-group first">
                          <input class="form-control-input" type="password" name="password" required="">
                          <label class="label-control" for="password">@lang('Password')</label>

                        </div>
                        <div class="form-group last mb-3">
                          <input class="form-control-input" type="password" name="password_confirmation" required="">
                          <label class="label-control" for="password_confirmation">@lang('Confirm password')</label>
                        </div>

                        <span class="ml-auto">
                          <a href="{{ route('login') }}">@lang("Already have account?")</a>
                        </span>
                      @if($errors->any())
                      <div class="alert alert-danger mt-2">
                        <ul class="list-unstyled mb-0">
                          @foreach ($errors->all() as $error)
                          <li> <i class="fas fa-times text-danger mr-2"></i> {{ $error }}</li>
                          @endforeach
                        </ul>
                      </div>
                      @endif
                      <button class="form-control-submit-button mt-4" type="submit">@lang('Reset Password')</button>
                    </form>
                  </div> <!-- end of text-box -->
              </div> <!-- end of col -->
          </div> <!-- end of row -->
      </div> <!-- end of container -->
  </div> <!-- end of ex-basic-1 -->
  <!-- end of basic -->

@endsection