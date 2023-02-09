@extends('core::layouts.app')
@section('title', __('Create new package'))
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Create package')</h1>
</div>
<div class="row">
    <div class="col-md-3">
        @include('core::partials.admin-sidebar')
    </div>
    <div class="col-md-9">
        <form role="form" method="post" action="{{ route('settings.packages.store') }}">
            @csrf
            <div class="card">
                <div class="card-body">
                    
                    <div class="row">
                        <input type="text" name="description" hidden="" value="description">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="form-label">@lang('Title')</label>
                                <input type="text" required name="title" value="{{ old('title') }}" class="form-control" placeholder="@lang('Title')">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="form-label">@lang('Price')</label>
                                <input type="number" required min="0" step="0.01" name="price" value="{{ old('price') }}" class="form-control" placeholder="@lang('Price')">
                            </div>
                        </div>
                         <div class="col-sm-3">
                            <div class="form-group">
                                <label class="form-label">@lang('Package num time')</label>
                                <input type="number" required min="1" step="1" name="interval_number" value="{{ old('interval_number') }}" class="form-control" placeholder="@lang('Package num time')">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="form-label">@lang('Package type time')</label>
                                <select name="interval" class="form-control">
                                    <option value="day" {{ old('interval') == 'day' ? 'selected' : '' }}>@lang('Day')</option>
                                    <option value="week" {{ old('interval') == 'week' ? 'selected' : '' }}>@lang('Week')</option>
                                    <option value="month" {{ old('interval') == 'month' ? 'selected' : '' }}>@lang('Month')</option>
                                    <option value="year" {{ old('interval') == 'year' ? 'selected' : '' }}>@lang('Year')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Limit number Events')</label>
                                <small>@lang('(Enter -1 for unlimited)')</small>
                                <input type="number" required min="-1" step="1" name="settings[no_events]"  class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Limit number Guests')</label>
                                <small>@lang('(Enter -1 for unlimited)')</small>
                                <input type="number" required min="-1" step="1" name="settings[no_guests]" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="form-label"><b>@lang('Permissions')</b></div>
                                <div class="custom-controls-stacked">
                                    @foreach($permissions as $permission => $description)
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="settings[{{ $permission }}]" value="true" {{ old('settings.permission_' . $permission) ? 'checked' : '' }}>
                                        <small class="custom-control-label">@lang($description)</small>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="form-label"><b>@lang('Featured')</b></div>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" name="is_featured" value="1" class="custom-control-input" {{ old('is_featured') ? 'checked' : '' }}>
                                    <small class="custom-control-label">@lang('Highlight as most featured package')</small>
                                </label>
                            </div>
                            <div class="form-group">
                                <div class="form-label"><b>@lang('Active Package')</b></div>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" name="is_active" value="1" class="custom-control-input" {{ old('is_active') ? 'checked' : '' }}>
                                    <small class="custom-control-label">@lang('Make this package visible to the public')</small>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <a href="{{ route('settings.packages.index') }}" class="btn btn-secondary">@lang('Back')</a>
                        <button class="btn btn-success ml-auto">@lang('Add package')</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
</div>
@stop