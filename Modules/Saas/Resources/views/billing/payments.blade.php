@extends('core::layouts.app')

@section('title', __('Payments'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
     <h1 class="h3 mb-0 text-gray-800">@lang('Payments')</h1>
     <form method="get" action="{{ route('settings.payments') }}" autocomplete="off" class="my-3 my-lg-0 navbar-search">
            <div class="input-group">
                <select name="is_paid" class="form-control">
                    <option value="">@lang('All statuses')</option>
                    <option value="1" {{ (Request::get('is_paid') == '1' ? 'selected' : '') }}>@lang('Paid')</option>
                    <option value="0" {{ (Request::get('is_paid') == '0' ? 'selected' : '') }}>@lang('Not paid')</option>
                </select>

                <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </span>
            </div>
        </form>
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
                                <th>@lang('User')</th>
                                <th>@lang('Package')</th>
                                <th>@lang('Gateway')</th>
                                <th colspan="2">@lang('Total')</th>
                                <th>@lang('Date')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item)
                            <tr>
                                <td>
                                    {{ $item->user->name }}
                                </td>
                                <td>
                                    {{ $item->package->title }}
                                </td>
                                <td>
                                    {{  $item->gateway }}
                                    <div class="small text-muted">{{ $item->reference }}</div>
                                </td>
                                <td>
                                    {{ $item->total }}
                                    {{ $item->currency }}
                                </td>
                                <td>
                                    @if($item->is_paid)
                                        <span class="text-green"><i class="fas fa-check-circle text-success"></i> @lang('Paid')</span>
                                    @else
                                        <span class="text-muted"><i class="fas fa-times-circle text-danger"></i> @lang('Not paid')</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $item->created_at->format('H:i M d, Y') }}
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
                <i class="fe fe-alert-triangle mr-2"></i> @lang('No payments found')
            </div>
        @endif

    </div>
    
</div>

@stop
