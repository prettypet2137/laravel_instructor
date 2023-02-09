@can('admin')
<li class="nav-item {{ (request()->is('settings/contacts')) ? 'active' : '' }}">
	<a class="nav-link" href="{{ route('settings.contacts.index') }}">
		<i class="fas fa-bullhorn"></i>
		<span>@lang('Contacts')</span></a>
</li>
@endcan