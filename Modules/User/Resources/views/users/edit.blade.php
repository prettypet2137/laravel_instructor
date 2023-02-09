@extends('core::layouts.app')

@section('title', __('Update user'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Update')</h1>
</div>
<div class="row">
    <div class="col-md-3">
        @include('core::partials.admin-sidebar')
    </div>
    <div class="col-md-9">
        <form role="form" method="post" action="{{ route('settings.users.update', $user) }}">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Name')</label>
                                <input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="@lang('Name')">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('E-mail')</label>
                                <input type="email" name="email" value="{{ $user->email }}" class="form-control" placeholder="@lang('E-mail')">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">@lang('Password')</label>
                                <input type="password" name="password" value="" class="form-control" placeholder="@lang('Password')">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">@lang('Confirm password')</label>
                                <input type="password" name="password_confirmation" value="" class="form-control" placeholder="@lang('Password')">
                            </div>
                        </div>
                        <div class="col-md-4">
                             <div class="form-group">
                                <label class="form-label">@lang('Role User')</label>
                                <select name="role" class="form-control" id="user_role_select">
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>@lang('User')</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>@lang('Admin')</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="row_package_user">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Package')</label>
                                <select name="package_id" class="form-control">
                                    <option value=""></option>
                                    @foreach($packages as $package)
                                    <option value="{{ $package->id }}" {{ $package->id == $user->package_id ? 'selected' : '' }}>{{ $package->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Package ends at')</label>
                                <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" name="package_ends_at" value="{{ $user->package_ends_at }}" placeholder="@lang('Package ends at')" data-target="#datetimepicker1"/>
                                    <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <a href="{{ route('settings.users.index') }}" class="btn btn-secondary">@lang('Cancel')</a>
                        <button class="btn btn-success ml-auto">@lang('Update user')</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
      <script src="{{ Module::asset('user:js/user.js') }}" ></script>
@endpush
@stop