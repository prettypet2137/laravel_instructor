<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="{{ app()->getLocale() }}" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/png">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}" />
    <title>@yield('title', config('app.name'))</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,900" rel="stylesheet">

    <link rel="stylesheet" href="{{ Module::asset('core:core/core.css') }}">
    <link rel="stylesheet" href="{{ Module::asset('core:app/css/customize.css') }}">

</head>

<body>
    <div class="page">
        <div class="flex-fill">
            <div class="header py-4">
                <div class="container">
                        <div class="d-flex">
                                <span class="header-brand" href="#">
                                    <img src="{{ asset('img/logo.png') }}" class="header-brand-img" alt="">
                                </span>
                </div>
            </div>
            <div class="my-3 my-md-5">
                <div class="container">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="list-unstyled mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="fe fe-check mr-2"></i> {!! session('success') !!}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            <i class="fe fe-alert-triangle mr-2"></i> {!! session('error') !!}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>

        <footer class="footer">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-9">
                            &copy; {{ date('Y') }} <a href="{{ url('/') }}" target="_blank">{{config('app.name')}}</a>
                        </div>
                    </div>
                </div>
            </footer>

    </div>

</body>
</html>