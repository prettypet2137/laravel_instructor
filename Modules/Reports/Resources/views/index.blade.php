@extends('core::layouts.app')
@section('title', __('Reports'))
@push('head')
    <style>
        .cstm-card {
            max-height: 300px;
            overflow-y: auto;
        }

        .ext-margin {
            margin: 10px 0px;
        }
    </style>
@endpush
@section('content')
    {{-- Start Admin Dashboard --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-gray-800">@lang('Reports')</h1>
    </div>
    <div class="row report-row">
        <div class="col-md-4">
            <div class="card ext-margin">
                <div class="card-header">
                    <h4 class="card-title mb-0">Course Registers</h4>
                </div>
                <div class="card-body cstm-card">
                    @forelse($coursesRegisterAndSales as $val)
                        <div class="d-flex justify-content-between mb-2">
                            <p>{{$val["name"]}}</p>
                            <p class="badge badge-success">{{$val["registered"]}}</p>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card ext-margin">
                <div class="card-header">
                    <h4 class="card-title mb-0">Course Ticket Sales</h4>
                </div>
                <div class="card-body cstm-card">
                    @forelse($coursesRegisterAndSales as $val)
                        <div class="d-flex justify-content-between mb-2">
                            <p>{{$val["name"]}}</p>
                            <p class="badge badge-success">${{!empty($val["sales"]) ? $val["sales"] : 0}}</p>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card ext-margin">
                <div class="card-header">
                    <h4 class="card-title mb-0">Course Upsell Sales</h4>
                </div>
                <div class="card-body cstm-card">
                    @forelse($coursesRegisterAndSales as $val)
                        <div class="d-flex justify-content-between mb-2">
                            <p>{{$val["name"]}}</p>
                            <p class="badge badge-success">${{!empty($val["upsell_sales"]) ? $val["upsell_sales"] : 0}}</p>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card ext-margin">
                <div class="card-header">
                    <h4 class="card-title mb-0">30 Days Profit</h4>
                </div>
                <div class="card-body">
                    <h1 class="text-center mb-0 font-weight-bold my-1" style="font-size: 4rem">${{$last30DaysProfit}}</h1>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card ext-margin">
                <div class="card-header">
                    <h4 class="card-title mb-0">Monthly Total Ticket Sales</h4>
                </div>
                <div class="card-body cstm-card">
                    @forelse($coursesSalesMonthly as $key => $val)
                        <div class="d-flex justify-content-between mb-2">
                            <p>{{$val['month']}}</p>
                            <p class="badge badge-success">${{$val['sale']}}</p>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card ext-margin">
                <div class="card-header">
                    <h4 class="card-title mb-0">Monthly Total Upsell Sales</h4>
                </div>
                <div class="card-body cstm-card">
                    @forelse($coursesSalesMonthly as $val)
                        <div class="d-flex justify-content-between mb-2">
                            <p>{{$val["month"]}}</p>
                            <p class="badge badge-success">${{$val["upsell_sale"]}}</p>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    {{-- End Admin Dashboard --}}
@stop
@push('scripts')
@endpush