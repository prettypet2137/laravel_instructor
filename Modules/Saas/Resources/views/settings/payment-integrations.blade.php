@extends('core::layouts.app')
@section('title', __('Payment Integrations'))
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Payment Integrations')</h1>
</div>
<div class="row">
    <div class="col-md-3">
        @include('core::partials.admin-sidebar')
    </div>
    <div class="col-md-9">
        <form role="form" method="post" action="{{ route('settings.payment-integrations-update') }}" autocomplete="off">
            @csrf
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tab_payments" data-toggle="tab">
                                @lang('Payments')
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_payments">
                            {!! settingPayments() !!}
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