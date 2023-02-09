@extends('core::layouts.app')

@section('title', __('Settings'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
     <h1 class="h3 mb-0 text-gray-800">@lang('General settings')</h1>
</div>
<div class="row">
    <div class="col-md-3">
        @include('core::partials.admin-sidebar')
    </div>
    <div class="col-md-9">
        <form role="form" method="post" action="{{ route('settings.general.update') }}" autocomplete="off"  enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><i class="fe fe-sliders"></i> @lang('General settings')</h4>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Site URL')</label>
                                <input type="text" name="APP_URL" value="{{ config('app.url') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Site name')</label>
                                <input type="text" name="APP_NAME" value="{{ config('app.name') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Site slogan')</label>
                                <input type="text" name="SITE_SLOGAN" value="{{ config('app.SITE_SLOGAN') }}" class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('SERVER IP')</label>
                                <input type="text" name="SERVER_IP" value="{{ config('app.SERVER_IP') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="form-label">@lang('Favicon')</div>
                                <div class="custom-file">
                                    <input type="file" class="" name="logo_favicon">
                                </div>
                                <small class="help-block">@lang('Recommended size: :size', ['size' => '48x48'])</small>
                            </div>
                        </div>
                        <div class="col-lg-6 text-center">
                            <img src="{{ asset(config('app.logo_favicon'))}}" height="50" alt="">
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="form-label">@lang('Logo')</div>
                                <div class="custom-file">
                                    <input type="file" class="" name="logo_frontend">
                                </div>
                                <small class="help-block">@lang('Recommended size: :size', ['size' => '170x45'])</small>
                            </div>
                        </div>
                        <div class="col-lg-6 text-center">
                            <img src="{{ asset(config('app.logo_frontend')) }}" height="50" alt="">
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="form-label">@lang('Logo Light')</div>
                                <div class="custom-file">
                                    <input type="file" class="" name="logo_light">
                                </div>
                                <small class="help-block">@lang('Recommended size: :size', ['size' => '170x45'])</small>
                            </div>
                        </div>
                        <div class="col-lg-6 text-center p-2" style="background-color: black">
                            <img src="{{ asset(config('app.logo_light')) }}" height="50" alt="">
                        </div>
                    </div>
                    <hr>
                    
                    <div class="form-group">
                        <label class="form-label">@lang('Description')</label>
                        <textarea name="SITE_DESCRIPTION" rows="2" class="form-control">{{ config('app.SITE_DESCRIPTION') }}</textarea>
                        <small class="help-block">@lang('Recommended length of the description is 150-160 characters')</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">@lang('Keywords')</label>
                        <textarea name="SITE_KEYWORDS" rows="3" class="form-control">{{ config('app.SITE_KEYWORDS')}}</textarea>
                    </div>
                  
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Skins')</label>
                                <select name="SITE_LANDING" class="form-control">
                                    @foreach($skins as $item)
                                        <option value="{{ $item }}" {{ $item == config('app.SITE_LANDING') ? 'selected' : '' }}>{{ $item }}</option>
                                    @endforeach
                                </select>
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