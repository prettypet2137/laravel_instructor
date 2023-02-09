@extends('core::layouts.app')
@section('title', __('Package free'))
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Package free')</h1>
</div>
<div class="row">
    <div class="col-md-3">
        @include('core::partials.admin-sidebar')
    </div>
    <div class="col-md-9">
        <form role="form" method="post" action="{{ route('settings.package-free-update') }}" autocomplete="off">
            @csrf
            <div class="card">
                <div class="card-status bg-blue"></div>
                <div class="card-header">
                    <h4 class="card-title">@lang('Package free')</h4>
                    <small>@lang('The default feature when a employer registers to the application').</small>
                </div>
               
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Limit number Events')</label>
                                <small>@lang('(Enter -1 for unlimited)')</small>
                                <input type="number" required min="-1" step="1" name="no_events" value="{{ config('saas.no_events') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Limit number Guests')</label>
                                <small>@lang('(Enter -1 for unlimited)')</small>
                                <input type="number" required min="-1" step="1" name="no_guests" value="{{ config('saas.no_guests') }}" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-label"><b>@lang('Permissions')</b></div>
                                @foreach($permissions as $permission => $description)
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="{{ $permission }}" value="true" {{ config('saas.'.$permission) ? 'checked' : '' }}>
                                        <small class="custom-control-label">@lang($description)</small>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary btn-block">
                    <i class="fe fe-save mr-2"></i> @lang('Save settings')
                    </button>
                </div>
            </div>
        </form>
    </div>
    
</div>
@stop