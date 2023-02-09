@can('admin')
<li class="nav-item {{ (request()->is('settings/modulesmanager*')) ? 'active' : '' }}">
	<a class="nav-link" href="{{ route('settings.modulesmanager.index') }}" >
		<i class="fas fa-box"></i>
		<span>@lang('Modules')</span>
	</a>
</li>
@endcan