@extends('core::layouts.app')
@section('title', __('Integrations'))
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Integrations')</h1>
</div>
<div class="row">
    <div class="col-md-3">
        @include('core::partials.admin-sidebar')
    </div>
    <div class="col-md-9">
        <form role="form" method="post" action="{{ route('settings.general.update', 'integrations') }}" autocomplete="off">
            @csrf
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tab_social" data-toggle="tab">
                                @lang('Social login')
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="#tab_miscellaneous" data-toggle="tab">
                                @lang('Miscellaneous')
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="card-body">
                    <div class="tab-content">
                        
                        
                        <div class="tab-pane active" id="tab_social">
                            <div class="d-flex align-items-center justify-content-between">
                                <div><h4>@lang('Login with Facebook')</h4></div>
                                <div><img src="{{ asset('img/facebook.svg') }}" height="60" alt="Facebook"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">@lang('App ID')</label>
                                        <input type="text" name="FACEBOOK_CLIENT_ID" value="{{ config('services.facebook.client_id') }}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">@lang('App Secret')</label>
                                        <input type="text" name="FACEBOOK_CLIENT_SECRET" value="{{ config('services.facebook.client_secret') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p>@lang('Get your App ID and App Secret from:') <a href="https://developers.facebook.com" target="_blank">https://developers.facebook.com</a></p>
                                    <p>@lang('Valid OAuth Redirect URI:') <a href="{{ route('login.callback', 'facebook') }}" target="_blank">{{ route('login.callback', 'facebook') }}</a></p>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between">
                                <div><h4>@lang('Login with Google')</h4></div>
                                <div><img src="{{ asset('img/google.svg') }}" height="60" alt="Google"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Client ID')</label>
                                        <input type="text" name="GOOGLE_CLIENT_ID" value="{{ config('services.google.client_id') }}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">@lang('Client Secret')</label>
                                        <input type="text" name="GOOGLE_CLIENT_SECRET" value="{{ config('services.google.client_secret') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p>@lang('Create a project:') <a href="https://console.developers.google.com/projectcreate" target="_blank">https://console.developers.google.com/projectcreate</a></p>
                                    <p>@lang('Create OAuth client ID credentials:') <a href="https://console.developers.google.com/apis/credentials" target="_blank">https://console.developers.google.com/apis/credentials</a></p>
                                    <p>@lang('Valid OAuth Redirect URI:') <a href="{{ route('login.callback', 'google') }}" target="_blank">{{ route('login.callback', 'google') }}</a></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane" id="tab_miscellaneous">
                            <div class="d-flex align-items-center justify-content-between">
                                <div><h4>@lang('Google Analytics')</h4></div>
                                <div><img src="{{ asset('img/google_analytics.svg') }}" height="60" alt="Google Analytics"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Property ID')</label>
                                        <input type="text" name="GOOGLE_ANALYTICS" value="{{ config('app.GOOGLE_ANALYTICS')  }}" class="form-control" placeholder="UA-XXXXX-Y">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p>@lang("Leave this field empty if you don't want to enable Google Analytics")</p>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between">
                                <div><h4>@lang('Google reCaptcha')</h4></div>
                                <div><img src="{{ asset('img/google_recaptcha.svg') }}" height="60" alt="Google reCaptcha"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Site key')</label>
                                        <input type="text" name="RECAPTCHA_SITE_KEY" value="{{ config('recaptcha.api_site_key')  }}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">@lang('Secret key')</label>
                                        <input type="text" name="RECAPTCHA_SECRET_KEY" value="{{ config('recaptcha.api_secret_key')  }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p>@lang('To protect your registration form, you can use Google reCaptcha service.')</p>
                                    <ul>
                                        <li>@lang('Get your free credentials from <a href=":link" target="_blank">:link</a>', ['link' => 'https://www.google.com/recaptcha/admin'])</li>
                                        <li>@lang('Select "reCAPTCHA v2" as a site key type.')</li>
                                        <li>@lang('Copy & paste the site and secret keys')</li>
                                    </ul>
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