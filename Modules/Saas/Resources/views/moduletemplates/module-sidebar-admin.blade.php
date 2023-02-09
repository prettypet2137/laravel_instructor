@can('admin')
<li class="nav-item">
	<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSAAS" aria-expanded="false" aria-controls="collapseTwo">
		<i class="fas fa-money-bill"></i>
		<span>@lang('SAAS')</span>
	</a>
	<div id="collapseSAAS" class="collapse @if((request()->is('settings/payment*')) || (request()->is('settings/package*'))) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
		<div class="py-2 collapse-inner rounded">
			<a class="collapse-item {{ routeName() == 'settings.payments' ? 'active' : '' }}" href="{{ route('settings.payments') }}">
				<span>@lang('Payments')</span>
			</a>
			<a class="collapse-item {{ routeName() == 'settings.package-free' ? 'active' : '' }}" href="{{ route('settings.package-free') }}">
				<span>@lang('Package Free')</span>
			</a>
			<a class="collapse-item {{ routeName() == 'settings.packages.index' ? 'active' : '' }}" href="{{ route('settings.packages.index') }}">
				<span>@lang('All Packages')</span>
			</a>
			<a class="collapse-item {{ routeName() == 'settings.payment-integrations' ? 'active' : '' }}" href="{{ route('settings.payment-integrations') }}">
				<span>@lang('Integrations')</span>
			</a>
		</div>
	</div>
</li>
@endcan