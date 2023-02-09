@extends('core::layouts.app')

@section('title', __('Saas Settings'))

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
     <h1 class="h3 mb-0 text-gray-800">@lang('Saas Settings')</h1>
</div>
<div class="row">
    <div class="col-md-3">
        @include('core::partials.admin-sidebar')
    </div>
    <div class="col-md-9">
        <form role="form" method="post" action="{{ route('settings.saas.settings.update') }}" autocomplete="off">
            @csrf
            <div class="card">
                    <div class="card-status bg-blue"></div>
                <div class="card-header">
                    <h4 class="card-title">@lang('Saas Settings')</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">@lang('Domain render server')</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" name="DOMAIN_RENDER_SERVER"  class="form-control" value="{{ config('saas.DOMAIN_RENDER_SERVER') }}">
                                        <small>@lang("This is the app's domain name for the custom-domain feature")</small>
                                    </div>
                                </div>
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