@extends('core::layouts.app')
@section('title', __('Create Category'))
@section('content')

    <div class="row mb-4 justify-content-center">
        <div class="col-md-3">
            @include('core::partials.admin-sidebar')
        </div>
        <div class="col-md-9">
            <h1 class="h3 mb-4 text-gray-800">@lang('Create Category')</h1>
            <form method="post" action="{{ route('settings.events.categories.store') }}">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Name')</label>
                                    <input type="text" name="name" value="{{ old('name', '') }}" class="form-control" />
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex">
                            <a href="{{ route('settings.events.categories.index') }}" class="btn btn-secondary">@lang('Cancel')</a>
                            <button type="submit" class="btn btn-success ml-auto">@lang('Save Category')</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop