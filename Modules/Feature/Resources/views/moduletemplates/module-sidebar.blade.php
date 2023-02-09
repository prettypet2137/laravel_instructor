@can('admin')
<li class="nav-item {{ (request()->is('feature*')) ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('feature.index') }}">
        <i class="fa fa-phone"></i>
        <span>@lang('Features')</span>
    </a>
</li>
@endcan
