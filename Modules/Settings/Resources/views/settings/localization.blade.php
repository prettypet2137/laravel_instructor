@extends('core::layouts.app')

@section('title', __('Localization'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
     <h1 class="h3 mb-0 text-gray-800">@lang('Localization')</h1>
</div>

<div class="row">
    <div class="col-md-3">
        @include('core::partials.admin-sidebar')
    </div>
    <div class="col-md-9">

        <form role="form" method="post" action="{{ route('settings.general.update', 'localization') }}" autocomplete="off">
            @csrf
            <div class="card">
                    <div class="card-status bg-blue"></div>
                    <div class="card-header">
                        <div class="">
                            <h1 class="h3 mb-0 text-gray-800">@lang('Localization')</h1>
                            <small>@lang('You can add new language here'): <a href={{url(config('translation.ui_url'))}}>{{url(config('translation.ui_url'))}}</a></small>
                        </div>
                    </div>
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Currency symbol')</label>
                                <input type="text" name="CURRENCY_SYMBOL" value="{{ $CURRENCY_SYMBOL }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Currency')</label>
                                <select name="CURRENCY_CODE" class="form-control">
                                    @foreach($currencies as $code => $title)
                                        <option value="{{ $code }}" {{ $code == $CURRENCY_CODE ? 'selected' : '' }}>{{ $code }} &mdash; {{ $title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                           
                            <div class="form-group">
                                <label class="form-label">@lang('Default language')</label><br>
                                
                                <select name="APP_LOCALE" class="form-control">
                                    @foreach($languages as $item)
                                        <option value="{{ $item }}" {{ $item == $APP_LOCALE ? 'selected' : '' }}>{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Timezone')</label>
                                <select name="APP_TIMEZONE" class="form-control">
                                    @foreach($time_zones as $zone)
                                        <option value="{{ $zone }}" {{ $zone == $APP_TIMEZONE ? 'selected' : '' }}>{{ $zone }}</option>
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