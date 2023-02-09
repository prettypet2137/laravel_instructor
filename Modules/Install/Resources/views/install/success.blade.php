@extends('install::layouts.install')

@section('content')
<div class="container text-center">
    <div class="display-1 text-muted mb-5"> <i class="fas fa-check-circle text-success"></i></div>
    <p class="h4 text-muted font-weight-normal mb-4">The installation was successful...</p>
    <div>
        <a class="btn btn-success" href="{{ url('/') }}">Landing Page</a>
        <a class="btn btn-primary" href="{{ route('login') }}">Login Now</a>
    </div>

    <p class="h4 text-muted font-weight-normal mt-4 mb-4">Account admin default</p>
    <p>Email: <strong>admin@admin.com</strong></p>
    <p>Password: <strong>admin@admin.com</strong></p>
  </div>
@endsection