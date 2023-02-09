<ul class="navbar-nav sidebar background-linear-gradient accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="">
          <img src="{{ asset(config('app.logo_light'))}}" height="40" alt="">
        </div>
      </a>
      @can('admin')
      <li class="nav-item {{ (request()->is('settings*')) ? 'active' : '' }} d-none d-md-block">
        <a class="nav-link" href="{{ route('settings.index') }}" >
          <i class="fas fa-user-secret"></i>
          <span>@lang('Administrator')</span>
        </a>
      </li>
      @endcan
      {!! menuSiderbar() !!}
      {{-- display menu admin for mobile --}}
      @can('admin')
      <div class="d-block d-md-none">
        <hr class="sidebar-divider">
        <div class="sidebar-heading text-light mt-4">
          @lang('Admin Menu')  
        </div>
        {!! menuAdminSettingSiderbar() !!}
        <hr class="sidebar-divider">
      </div>
      @endcan
      
      
</ul>