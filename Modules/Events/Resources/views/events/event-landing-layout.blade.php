<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
@includeWhen(config('app.GOOGLE_ANALYTICS'), 'core::partials.google-analytics')
<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ __(config('app.name')) }} &mdash; {{ config('app.SITE_SLOGAN') }}</title>
    <meta name="description" content="{{ config('app.SITE_DESCRIPTION') }}">
    <meta name="keywords" content="{{ config('app.SITE_KEYWORDS') }}">
    <link rel="shortcut icon" href="{{ asset(config('app.logo_favicon')) }}">

    <!-- Bootstrap CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
            href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300&display=swap"
            rel="stylesheet"
    />
    <link rel="stylesheet" type="text/css" href="{{ Module::asset('themes:default/css/bootstrap.min.css') }}"  />
    <link rel="stylesheet" type="text/css" href="{{ Module::asset('themes:default/css/fontawesome-all.min.css') }}"  />
    <link rel="stylesheet" type="text/css" href="{{ Module::asset('events:css/event-landing.css') }}"  />
    @stack('head')
</head>
<body data-spy="scroll" data-target="#navbarCollapse">
@if (session('error'))
    <div class="alert alert-danger border-radius-none">
        <i class="fas fa-times text-danger mr-2"></i> {!! session('error') !!}
    </div>
@endif
@yield('content')
<script src="{{ Module::asset('themes:default/js/jquery.min.js') }}"></script>
<script src="{{ Module::asset('themes:default/js/bootstrap.min.js') }}"></script>
@stack('scripts')

</body>
</html>