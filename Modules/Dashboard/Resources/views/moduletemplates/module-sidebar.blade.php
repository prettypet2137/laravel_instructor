<li class="nav-item {{ (request()->is('dashboard')) ? 'active' : '' }}" data-target="dashboard-tour">
	<a class="nav-link" href="{{ url('dashboard') }}">
		<i class="fas fa-tachometer-alt"></i>
		<span>@lang('Dashboard')</span></a>
</li>
