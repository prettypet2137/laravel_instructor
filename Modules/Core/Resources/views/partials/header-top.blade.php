<nav class="navbar navbar-expand topbar mb-4 static-top">
  <button id="sidebarToggleTop" class="btn d-md-none rounded-circle mr-3">
  <i class="fa fa-bars"></i>
  </button>
  <!-- Topbar Navbar -->
  <ul class="navbar-nav">
    {!! menuHeaderTopLeft() !!}
  </ul>
 

  <ul class="navbar-nav ml-auto">
    {!! menuHeaderTop() !!}
    <li class="nav-item">
      <a class="nav-link" href="#" data-toggle="modal" data-target="#new_feature_modal">
        <i class="fas fa-plus fa-lg"></i>
        <span class="d-none d-sm-inline-block ml-2">@lang('Feature Request')</span>
      </a>
    </li>
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">
          @if($active_language)
            {{ $active_language }}
          @endif
        </span>
        <i class="fas fa-language fa-lg"></i>
      </a>
      <!-- Dropdown - User Information -->
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        @foreach($languages as $item)
        <a href="{{ route('localize', $item) }}" rel="alternate" hreflang="{{ $item }}" class="dropdown-item">
          {{ $item }}
        </a>
        @endforeach
      </div>
    </li>
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-target="account-setting">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
        <i class="fas fa-laugh-wink"></i>
      </a>
      <!-- Dropdown - User Information -->
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        @can('admin')
        <a class="dropdown-item" href="{{ route('settings.index') }}">
          <i class="fas fa-user-secret"></i>
          @lang('Administrator')
        </a>
        @endcan
        <a class="dropdown-item" href="{{ route('accountsettings.index') }}">
          <i class="fas fa-user"></i>
          @lang('Account Settings')
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ route('logout') }}">
          <i class="fas fa-sign-out-alt"></i>
          @lang('Logout')
        </a>
      </div>
    </li>
  </ul>
  <div class="modal fade" id="new_feature_modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">@lang('New Feature')</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('feature.store') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group required">
              <label>@lang('Title'):</label>
              <input type="text" class="form-control" name="title" required />
            </div>
            <div class="required">
              <label>@lang('Content'):</label>
              <textarea class="form-control" name="content" rows="8"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Cancel')</button>
            <button type="submit" class="btn btn-primary">@lang('Send Request')</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</nav>