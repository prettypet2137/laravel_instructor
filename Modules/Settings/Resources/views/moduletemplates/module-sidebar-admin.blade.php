@can('admin')
	<li class="nav-item">
		@php
			$sub_menu = ["settings.index","settings.localization","settings.email","settings.integrations","settings.manage-ads","settings.landing-page"];
		@endphp
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><i class="fas fa-fw fa-cog"></i><span>@lang('Website settings')</span>
		</a>
		<div id="collapseTwo" class="collapse {{ in_array(routeName(), $sub_menu) ? 'show' : ''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
			<div class="py-2 collapse-inner rounded">
				<a class="collapse-item {{ routeName() == 'settings.index' ? 'active' : '' }}" href="{{ route('settings.index') }}">
					<span>@lang('General settings')</span>
				</a>
				<a class="collapse-item {{ routeName() == 'settings.localization' ? 'active' : '' }}" href="{{ route('settings.localization') }}">
					<span>@lang('Localization')</span>
				</a>
				<a class="collapse-item " href="{{ url(config('translation.ui_url')) }}">
					<span>@lang('Languages')</span>
				</a>
				<a class="collapse-item {{ routeName() == 'settings.email' ? 'active' : '' }}" href="{{ route('settings.email') }}">
					<span>@lang('E-mail Settings')</span>
				</a>
				<a class="collapse-item {{ routeName() == 'settings.integrations' ? 'active' : '' }}" href="{{ route('settings.integrations') }}">
					<span>@lang('Integrations')</span>
				</a>
				<a class="collapse-item {{ routeName() == 'settings.landing-page' ? 'active' : '' }}" href="{{ route('settings.landing-page') }}">
					<span>@lang('Landing Page')</span>
				</a>
				<a class="collapse-item {{ routeName() == 'settings.video.index' ? 'active' : '' }}" href="{{ route('settings.video.index') }}">
					<span>@lang('Video')</span>
				</a>
			</div>
		</div>
	</li>
@endcan
