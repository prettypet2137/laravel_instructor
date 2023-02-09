@extends('core::layouts.app')
@section('title', __('Module managers'))
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">@lang('Modules manager')</h1>
</div>
<div class="row">
	<div class="col-md-3">
        @include('core::partials.admin-sidebar')
    </div>
    <div class="col-md-9">
		@if($data['products'] && count($data) > 0)
		<div class="row row_blog_responsive pt-4 clearfix">
			@foreach($data['products'] as $item)
			@php
				$check = check_product_purchase($item['pd_pid']);
				$product_version = get_latest_version_product_id($item['pd_pid']);
			@endphp
			<div class="col-xl-5 col-lg-6 col-md-4 col-sm-6 col-12 itembb">
				<div class="clearfix blog-bottom blog blogitemlarge">
					
					<div class="content_blog clearfixflex flex-column flex-lg-row">
						<p title="{{$item['pd_name']}}" class="min-h-100 p-2">
							{{$item['pd_details']}}
						</p>
						<div class="p-2">
							<h6 class="font-weight-bold text-secondary text-uppercase mb-1">{{ $item['pd_name'] }}</h6>
						</div>
						@if($check)
							@if($product_version && $product_version['latest_version'] != $check->version)
							<span class="p-2 text-warning">@lang('Version :version is available. Update now',['version' => $product_version['latest_version']])</span>
							@endif
							<div class="d-flex p-2">
								<button href="#" class="btn btn-sm btn-success mr-2" disabled><i class="fas fa-check-circle"></i> @lang('Installed')</button>	
								@if($product_version && $product_version['latest_version'] != $check->version)
									<form method="post" id="formUpdateVersion" action="{{ route('settings.modulesmanager.update', $item['pd_pid']) }}" >
				                      @csrf
				                      <button type="submit" id="btnUpdateVersion" class="btn btn-sm btn-danger">
				                      	<i class="fas fa-download"></i> @lang("Update") {{$product_version['latest_version']}}
				                      </button>
				                    </form>
								@else
									<button href="#" class="btn btn-sm btn-primary" disabled>@lang('Version'): {{$check->version}}</button>
								@endif
							</div>
						@else
							<div class="d-flex p-2">
								<a href="{{$item['pd_url_detail']}}" target="_blank" class="btn btn-sm btn-secondary mr-2"><i class="fas fa-eye"></i> @lang("Detail")</a>
								<a href="#" data-toggle="modal" data-productid="{{$item['pd_pid']}}" data-name="{{$item['pd_name']}}" data-pathmain="{{$item['pd_path_main_file']}}" 
								@if($item['envato_id'])
									 data-verifytype="envato" 
								@else
									 data-verifytype="non_envato" 
								@endif
								data-productname="{{$item['pd_name']}}" 
								data-target="#installModule" class="btninstallModule btn btn-sm btn-primary"><i class="fab fa-instalod"></i> @lang("Install now")</a>
							</div>
						@endif
					</div>
				</div>
			</div>
			@endforeach
		</div>
		@endif
	</div>
</div>
<div class="modal fade" id="installModule" tabindex="-1" role="dialog" aria-labelledby="installModuleLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fas fa-file-archive"></i> @lang('Install') <span id="installModuleTitle"></span> </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form  action="{{route('settings.modulesmanager.install')}}" id="installModuleForm" method="post" enctype='multipart/form-data'>
				@csrf
				<div class="modal-body">
					<input type="text" class="form-control" hidden="" name="verify_type" required="" id="verify_type">
					<input type="text" class="form-control" hidden="" name="path_main" required="" id="path_main">
					<input type="text" class="form-control" hidden="" name="product_id" required="" id="product_id">
					<input type="text" class="form-control" hidden="" name="product_name" required="" id="product_name">
					<div class="form-group">
						<label for="name" class="col-form-label">@lang('Enter License'):</label>
						<input type="text" class="form-control" name="license" required="" id="license">
					</div>
					<div class="form-group">
						<label for="email" class="col-form-label">@lang('Email purchase'):</label>
						<input type="email" class="form-control" name="email_username_purchase" required="" id="email_username_purchase">
					</div>
					<div class="form-group">
						<label for="name" class="col-form-label">@lang('Notes'):</label>
						<div class="alert alert-primary">
							<ul class="mb-0">
								<li>@lang('Feature just can install modules or themes. Cannot use for reinstall main script')</li>
								<li>@lang("Make sure your server doesn't block the permissions to install")</li>
							</ul>
						</div>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
					<button type="submit" id="btnInstallModuleModal" class="btn btn-primary">@lang('Install')</button>
				</div>
			</form>
		</div>
	</div>
</div>


@push('scripts')
      <script src="{{ Module::asset('modulesmanager:js/modulemanager.js') }}" ></script>
 @endpush
@stop