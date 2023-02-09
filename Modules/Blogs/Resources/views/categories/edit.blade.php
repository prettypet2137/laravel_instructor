@extends('core::layouts.app')

@section('title', __('Edit category'))

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Edit category')</h1>
</div>
<div class="row">
    <div class="col-md-3">
        @include('core::partials.admin-sidebar')
    </div>
    <div class="col-md-9">

        <form role="form" method="post" action="{{ route('settings.blogs.categories.update', $item->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">@lang('Name')</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $item->name) }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-label mb-2">@lang('Thumbnail')</div>
                                <div class="custom-file">
                                    <input type="file" class="" name="thumb" accept="image/*">
                                </div>
                                <small class="help-block">@lang('Recommended size: :size', ['size' => '100x100'])</small>
                            </div>
                        </div>
                        <div class="col-0 col-md-3">
                            @if($item->getThumbLink() != null)
                                <img src="{{ $item->getThumbLink() }}" class="img-preview" />
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Is featured')</label>
                        <div>
                            <label><input type="radio" name="is_featured" value="1" {{ old('is_featured', $item->is_featured) == '1' ? 'checked' : '' }}> @lang('Yes')</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="is_featured" value="0" {{ old('is_featured', $item->is_featured) == '0' ? 'checked' : '' }}> @lang('No')</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Is active')</label>
                        <div>
                            <label><input type="radio" name="is_active" value="1" {{ old('is_active', $item->is_active) == '1' ? 'checked' : '' }}> @lang('Active')</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="is_active" value="0" {{ old('is_active', $item->is_active) == '0' ? 'checked' : '' }}> @lang('In-active')</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <a href="{{ route('settings.blogs.categories.index') }}" class="btn btn-secondary">@lang('Cancel')</a>
                        <button type="submit" class="btn btn-primary ml-auto">@lang('Save')</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
    
</div>
@stop

@push('head')
<link rel="stylesheet" href="{{ Module::asset('blogs:css/global.css') }}">
@endpush