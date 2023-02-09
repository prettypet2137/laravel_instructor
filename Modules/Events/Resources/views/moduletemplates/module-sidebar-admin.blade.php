@can('admin')
<li class="nav-item {{ (request()->is('settings.events*')) ? 'active' : '' }}">
	<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEventsSettings" aria-expanded="false" aria-controls="collapseTwo">
		<i class="fas fa-calendar-day"></i>
		<span>@lang('Events')</span>
	</a>
	<div id="collapseEventsSettings" class="collapse {{ (request()->is('settings/events*')) ? 'show' : '' }}" aria-labelledby="collapseEvents">
		<div class="py-2 collapse-inner rounded">
			<a class="collapse-item {{ routeName() == 'settings.events.emaildefault' ? 'active' : '' }}" href="{{ route('settings.events.emaildefault') }}">@lang('Email default')</a>
		</div>
	</div>
</li>
@endcan


