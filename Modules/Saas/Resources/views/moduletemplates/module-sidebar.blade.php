

<li class="nav-item {{ routeName() == 'billing.index' ? 'active' : '' }}">
	<a class="nav-link my-billing-link" href="{{ route('billing.index') }}">
		<i class="fas fa-money-check-alt"></i>
		<span>@lang('My Billing')</span></a>
</li>
@if(!Auth::user()->subscribed())
<li class="d-lg-none d-sm-inline-block nav-item ">
	<a class="nav-link" href="{{route('pricing')}}">
		<i class="far fa-star"></i>
		<span class="">@lang('Upgrade Now')</span>
	</a>
</li>
<div class="p-2 d-none d-sm-inline-block">
	<div class="card card-background-linear-gradient">
		<div class="card-body">
			<div class="row no-gutters align-items-center">
				<div class="col mr-2">
					<div class="h5 mb-0 font-weight-bold">@lang('Go Pro')</div>
					<div class="text-xs">@lang('Get unlimited events, guests, theme & more').</div>
					<a href="{{route('pricing')}}" class="btn btn-success mt-2"><i class="far fa-star"></i> @lang('Upgrade Now')</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endif
