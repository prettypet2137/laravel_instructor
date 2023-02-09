@extends('core::layouts.app')

@section('title', __('Packages'))

@section('content')
<div class="mb-4">
     <h1 class="h3 text-gray-800">@lang('Packages')</h1>
     <p class="text-gray-800">@lang('Find out which plan is right for you')</p>
</div>
<div class="row">
	<div class="col-md-{{ 12 / (count($packages) + 1)}}">
	    <div class="package-item">
	        <div class="item">
	            <div class="header-package">
	                <div class="inner-package">
	                    <div class="top-package-info clearfix flex-middle-lg">
	                        <h3 class="title">@lang('Package Free')</h3>
	                    </div>
	                </div>
	            </div>
	            <div class="bottom-package">
	                <div class="price">
	                    <span class="">@lang('Free')</span>
	                </div>
	                <span class="f-16 text-muted">@lang('Free')</span>
	                <div class="package-des">
	                    <ul>
	                    	@if(config('saas.no_events') == -1)
	                    		<li><i class="fas fa-check text-success"></i>@lang('Unlimited Events')</li>
							@else
								<li><i class="fas fa-check text-success"></i>@lang(':number Events',['number' => config('saas.no_events')])</li>
							@endif
							@if(config('saas.no_guests') == -1)
	                    		<li><i class="fas fa-check text-success"></i>@lang('Unlimited Guests')</li>
							@else
								<li><i class="fas fa-check text-success"></i>@lang(':number Guests',['number' => config('saas.no_guests')])</li>
							@endif
							@foreach(config('saas.PERMISSIONS') as $permission => $description)
								<li>
									<i class="fas @if(config('saas.'.$permission) && config('saas.'.$permission) == true) fa-check text-success 
									@else fa-times text-danger 
									@endif"></i>@lang($description)
								</li>
                             @endforeach
	                    </ul>
	                </div>
	                <div class="button-action">
	                    <div class="add-cart">
	                        <button class="button btn-block" disabled="">
	                            @lang('Free') </button>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	@foreach($packages as $package)
	    <div class="col-md-{{ 12 / (count($packages) + 1)}}">
		    <div class="package-item @if($package->is_featured == 1) is_featured @endif ">
		        <div class="item">
		            <div class="header-package">
		                <div class="inner-package">
		                    <div class="top-package-info clearfix flex-middle-lg">
		                        <h3 class="title">{{ $package->title }}</h3>
		                        @if($package->is_featured == 1)
		                        	<div class="recommended align-right">
		                            @lang('Recommended')</div>
		                        @endif
		                        
		                    </div>
		                </div>
		            </div>
		            <div class="bottom-package">
		                <div class="price">
		                    <span class="">{{ $currency_symbol }}</span>{{ $package->price }}

		                </div>
		                <span class="f-16 text-muted">{{$package->interval_number}} @lang($package->interval)</span>
		                <div class="package-des">
		                    <ul>
							
								@if($package->settings['no_events'] == -1)
									<li><i class="fas fa-check text-success"></i>@lang('Unlimited Events')</li>
								@else
									<li><i class="fas fa-check text-success"></i>@lang(':number Events',['number' => $package->settings['no_events']])</li>
								@endif
								@if($package->settings['no_guests'] == -1)
									<li><i class="fas fa-check text-success"></i>@lang('Unlimited Guests')</li>
								@else
									<li><i class="fas fa-check text-success"></i>@lang(':number Guests',['number' => $package->settings['no_guests']])</li>
								@endif
								@foreach(config('saas.PERMISSIONS') as $permission => $description)
									<li>
										<i class="fas @if($package->hasPermissionTo($permission) && $package->settings[$permission] == true) fa-check text-success 
										@else fa-times text-danger 
										@endif"></i>@lang($description)
									</li>
                             	@endforeach
		                    </ul>
		                </div>
		                <div class="button-action">
		                	<a href="{{ route('billing.package', $package) }}" class="button btn-block">@lang('Upgrade Now')</a>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	@endforeach
	
</div>

@endsection
