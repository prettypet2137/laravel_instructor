@extends('core::layouts.app')

@section('title', __('Create Page websites'))

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Create Page websites')</h1>
</div>
<div class="row">
    <div class="col-md-3">
        @include('core::partials.admin-sidebar')
    </div>
    <div class="col-md-9">
        <form role="form" method="post" action="{{ route('settings.pagewebsites.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label class="form-label">@lang('Title')</label>
                                <input type="text" name="title" value="{{ old('name') }}" class="form-control" placeholder="@lang('Title')">
                            </div>
                            <div class="form-group">
                                <div class="form-label">@lang('Active')</div>
                                <label class="custom-switch">
                                    <input type="checkbox" name="is_active" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">@lang('Allow active')</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Slug')</label>
                                <input type="text" name="slug" value="{{ old('slug') }}" class="form-control" placeholder="@lang('Slug')">
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Description')</label>
                                <textarea name="description" id="description_pages_website" rows="4" class="form-control">{{ old('description') }}</textarea>
                            </div>
                            
                        </div>
     
                    </div>

                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <a href="{{ route('settings.pagewebsites.index') }}" class="btn btn-secondary">@lang('Cancel')</a>
                        <button class="btn btn-primary ml-auto">@lang('Save')</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
    
</div>


@stop