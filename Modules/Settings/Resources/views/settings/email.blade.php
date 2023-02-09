@extends('core::layouts.app')

@section('title', __('E-mail Settings'))

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
     <h1 class="h3 mb-0 text-gray-800">@lang('E-mail Settings')</h1>
</div>

<div class="row">
    <div class="col-md-3">
        @include('core::partials.admin-sidebar')
    </div>
    <div class="col-md-9">

        <form role="form" method="post" action="{{ route('settings.general.update', 'email') }}" autocomplete="off">
            @csrf

            <div class="card">
                    <div class="card-status bg-blue"></div>
                    <div class="card-header">
                            <h4 class="card-title">@lang('E-mail Settings')</h4>
                        </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('SMTP Host')</label>
                                <input type="text" name="MAIL_HOST" value="{{ config('mail.host') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('SMTP Port')</label>
                                <input type="text" name="MAIL_PORT" value="{{ config('mail.port') }}" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">@lang('SMTP Username')</label>
                                <input type="text" name="MAIL_USERNAME" value="{{ config('mail.username') }}" class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">@lang('SMTP Password')</label>
                                <input type="text" name="MAIL_PASSWORD" value="{{ config('mail.password') }}" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">@lang('SMTP Encryption')</label>
                                @php
                                    $MAIL_ENCRYPTION = config('mail.encryption');
                                @endphp
                                <select name="MAIL_ENCRYPTION" class="form-control">
                                    <option value="" {{ null ==  $MAIL_ENCRYPTION ? 'selected' : '' }}>@lang('No encryption')</option>
                                    <option value="tls" {{ 'tls' == $MAIL_ENCRYPTION ? 'selected' : '' }}>@lang('TLS')</option>
                                    <option value="ssl" {{ 'ssl' == $MAIL_ENCRYPTION ? 'selected' : '' }}>@lang('SSL')</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('From address')</label>
                                <input type="text" name="MAIL_FROM_ADDRESS" value="{{ config('mail.from.address') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('From name')</label>
                                <input type="text" name="MAIL_FROM_NAME" value="{{ config('mail.from.name') }}" class="form-control">
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