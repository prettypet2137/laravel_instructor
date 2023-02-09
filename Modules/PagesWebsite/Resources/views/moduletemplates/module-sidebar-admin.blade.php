@can('admin')
<li class="nav-item {{ (request()->is('settings/pagewebsites*')) ? 'active' : '' }}">
	<a class="nav-link" href="{{ route('settings.pagewebsites.index') }}" >
		<i class="fas fa-pager"></i>
		<span>@lang('Pages Website')</span>
	</a>
</li>
@endcan