@extends('core::layouts.app')
@section('title', __('Packages'))
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Packages')</h1>
    <a href="{{ route('settings.packages.create') }}" class="btn btn-success">
        <i class="fe fe-plus"></i> @lang('Create package')
    </a>
</div>
<div class="row">
    <div class="col-md-3">
        @include('core::partials.admin-sidebar')
    </div>
    <div class="col-md-9">
        @if($data->count() > 0)
        <div class="card mb-3">
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>@lang('Title')</th>
                            <th>@lang('Price')</th>
                            <th>@lang('Type')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>
                                <a href="{{ route('settings.packages.edit', $item) }}">{{ $item->title }}</a>
                                <div class="small text-muted">
                                    {{$item->interval_number}} @lang($item->interval)
                                </div>
                            </td>
                            
                            <td>
                                <span class="tag">{{ config('app.CURRENCY_SYMBOL') }}{{ $item->price }} {{ config('app.CURRENCY_CODE') }}</span>
                            </td>
                            <td>
                                @if($item->is_active)
                                    <span class="small text-success"><i class="fas fa-check-circle"></i> @lang('Active')</span>
                                @else
                                    <span class="small text-danger"><i class="fas fa-times-circle"></i> @lang('No Active')</span>
                                @endif
                                <br>
                                @if($item->is_featured)
                                    <span class="small text-primary"><i class="fas fa-check-circle"></i> @lang('Featured')</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    <div class="p-1 ">
                                        <a href="{{ route('settings.packages.edit', $item) }}" class="btn btn-sm btn-primary">@lang('Edit')</a>
                                    </div>
                                    <div class="p-1 ">
                                        <form method="post" action="{{ route('settings.packages.destroy', $item) }}" onsubmit="return confirm('@lang('Confirm delete? All users using this package will lose their subscription')');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-clean">
                                            @lang('Delete')
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        {{ $data->appends( Request::all() )->links() }}
        @if($data->count() == 0)
        <div class="alert alert-primary text-center">
            <i class="fe fe-alert-triangle mr-2"></i> @lang('No packages found')
        </div>
        @endif
    </div>
    
</div>
@stop