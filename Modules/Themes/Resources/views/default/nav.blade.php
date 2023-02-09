<!-- Static navbar -->
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg fixed-top navbar-light">
    <div class="container">
        <a class="navbar-brand logo-image"  href="{{ url('/') }}">
            <img src="{{ asset(config('app.logo_frontend'))}}" alt="alternative">
        </a> 

        <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav ml-auto">
                {!! menuHeaderSkins() !!}
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><strong>{{ $user->name }}</strong></a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        @can('admin')
                            <a class="dropdown-item" href="{{ route('settings.index') }}">@lang('Administrator')</a>
                        @endcan
                        <a class="dropdown-item" href="{{ route('dashboard') }}">@lang('Dashboard')</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}">@lang('Logout')</a>
                    </div>
                </li>
                </ul>
                @else
                <span class="nav-item">
                    <a class="btn-outline-sm" href="{{ route('login') }}">@lang('Login')</a>
                </span>
                </ul>
                @endauth
        </div> <!-- end of navbar-collapse -->
    </div> <!-- end of container -->
</nav> <!-- end of navbar -->

