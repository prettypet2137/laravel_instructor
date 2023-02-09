@extends('core::layouts.app')

@section('title', __('Event Email Default'))

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
     <h1 class="h3 mb-0 text-gray-800">@lang('Event Email Default')</h1>
</div>
<div class="row">
    <div class="col-md-3">
        @include('core::partials.admin-sidebar')
    </div>
    <div class="col-md-9">
        <form role="form" method="post" action="{{ route('settings.events.emaildefault.store') }}" autocomplete="off">
            @csrf
            <div class="card">
                    <div class="card-status bg-blue"></div>
                <div class="card-header">
                    <h4 class="card-title">@lang('Event Email Default')</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">@lang('Email default when user create a event')</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <textarea name="EVENT_EMAIL_CONTENT" id="EVENT_EMAIL_CONTENT" rows="4" class="form-control">{{ config('events.EVENT_EMAIL_CONTENT') }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <small>
                                            <p>@lang('Enter the following fields so that the content entered by the guest into the form field will be pasted automatically:')</p>
                                            <ul>
                                                <li>@lang('Event name'): <strong>%event_name%</strong></li>
                                                <li>@lang('Event description'): <strong>%event_description%</strong></li>
                                                <li>@lang('Event address'): <strong>%event_address%</strong></li>
                                                <li>@lang('Event start date'): <strong>%event_start_date%</strong></li>
                                                <li>@lang('QR code'): <strong>%qr_code%</strong></li>

                                                <li>@lang('Guest fullname'): <strong>%guest_fullname%</strong></li>
                                                <li>@lang('Guest email'): <strong>%guest_email%</strong></li>
                                                <li>@lang('Guest ticket name'): <strong>%guest_ticket_name%</strong></li>
                                                <li>@lang('Guest ticket price'): <strong>%guest_ticket_price%</strong></li>
                                                <li>@lang('Guest ticket currency'): <strong>%guest_ticket_currency%</strong></li>
                                            </ul>
                                        </small>
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
@push('scripts')
<script src="{{ Module::asset('events:js/settings/emaildefault.js') }}"></script>    
@endpush
@stop