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
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400;1,600&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ Module::asset('themes:default/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ Module::asset('themes:default/css/fontawesome-all.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ Module::asset('themes:default/css/swiper.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ Module::asset('themes:default/css/magnific-popup.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ Module::asset('themes:default/css/styles.css') }}"/>
    @stack('head')
</head>
<body data-spy="scroll" data-target="#navbarCollapse">
@if (session('success'))
    <div class="alert alert-success border-radius-none">
        <i class="fas fa-check-circle text-success mr-2"></i> {!! session('success') !!}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger border-radius-none">
        <i class="fas fa-times text-danger mr-2"></i> {!! session('error') !!}
    </div>
@endif
@include('themes::default.nav')
@yield('content')
<!-- end of footer -->
<div class="copyright p-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <ul class="list-link-copyright list-unstyled d-flex">
                    <li>@lang('Links'):</li>
                    {!! menuBottomSkins(['pagewebsites' => $pagewebsites]) !!}
                </ul>
            </div> <!-- end of col -->
            <div class="col-md-6 text-right">
                <p class="mb-0">@lang('Copyright') © {{ now()->year }} @lang('Design by') <a
                            href="{{ url('/') }}">{{ __(config('app.name')) }}</a></p>
            </div> <!-- end of col -->
        </div> <!-- enf of row -->
    </div> <!-- end of container -->
</div>

<script src="{{ Module::asset('themes:default/js/jquery.min.js') }}"></script>
<script src="{{ Module::asset('themes:default/js/bootstrap.min.js') }}"></script>
<script src="{{ Module::asset('themes:default/js/jquery.easing.min.js') }}"></script>
<script src="{{ Module::asset('themes:default/js/jquery.magnific-popup.js') }}"></script>
<script src="{{ Module::asset('themes:default/js/swiper.min.js') }}"></script>
<script src="{{ Module::asset('themes:default/js/scripts.js') }}"></script>
@stack('scripts')

</body>
</html>