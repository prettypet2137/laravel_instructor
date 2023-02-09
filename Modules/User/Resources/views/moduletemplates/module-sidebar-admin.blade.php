@can('admin')
    <li class="nav-item">
        <a class="nav-link {{ (request()->is('settings/users*')) ? '' : 'collapsed' }}" href="#" data-toggle="collapse"
           data-target="#collapseUsers" aria-expanded="false" aria-controls="collapseTwo">
            <i class="fas fa-user"></i>
            <span>@lang('Users')</span>
        </a>
        <div id="collapseUsers" class="collapse {{ (request()->is('settings/users*')) ? 'show' : '' }}"
             aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
            <div class="py-2 collapse-inner rounded">
                <a class="collapse-item {{ routeName() == 'settings.users.index' ? 'active' : '' }}"
                   href="{{ route('settings.users.index') }}">
                    <span>@lang('All users')</span>
                </a>
                <a class="collapse-item {{ routeName() == 'settings.users.create' ? 'active' : '' }}"
                   href="{{ route('settings.users.create') }}">
                    <span>@lang('New user')</span>
                </a><a class="collapse-item {{ routeName() == 'users.email' ? 'active' : '' }}"
                       href="{{ route('users.email') }}">
                    <span>@lang('Email All Users')</span>
                </a>
            </div>
        </div>
    </li>
@endcan