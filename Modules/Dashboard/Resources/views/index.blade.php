@extends('core::layouts.app')
@section('title', __('Dashboard'))
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Dashboard')</h1>
</div>

<div class="row">
    <div class="col-md-3">
        <a href="{{ route('events.index') }}" class="text-decoration-none">
            <div class="card shadow h-100">
                <div class="card-body bg-primary text-light">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold mb-1">
                                @lang('Events')
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $total_events }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('events.index') }}" class="text-decoration-none">
            <div class="card shadow h-100">
                <div class="card-body bg-info text-light">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold mb-1">
                                @lang('Views')
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $total_views }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-briefcase fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('guests.index') }}" class="text-decoration-none">
            <div class="card shadow h-100">
                <div class="card-body bg-dark text-light">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold mb-1">
                                @lang('Registered Guests')
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $total_registered }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('guests.index') }}" class="text-decoration-none">
            <div class="card shadow h-100">
                <div class="card-body bg-success text-light">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold mb-1">
                                @lang('Joined Guests')
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $total_joined }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tag fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @if($pageviews_visible)
    <div class="col-md-12 mt-5">
        <div class="row">
            <div class="col-md-12"> 
                <canvas id="pageviews_chart"></canvas>
            </div>
            <div class="col-md-12 mt-2">
                <p class="text-center"><span class="">@lang('Event registrants in the last 7 days')</span><p>
            </div>
        </div>
    </div>
    @endif
    @if($column_chart_visible)
    <div class="col-md-7 mt-5">
        <div class="row">
            <div class="col-md-12">
                <canvas id="chart_column_widget" class="animated fadeIn" height="400"></canvas>
            </div>
            <div class="col-md-12 mt-2">
                <p class="text-center"><span class="">@lang('Registrants and Participants by event')</span><p>
            </div>
        </div>
    </div>
    @endif
    @if($guest_by_event_visible)
    <div class="col-md-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <canvas class="chart" height="250" id="guest_by_event_chart"></canvas>
            </div>
            <div class="col-md-12 mt-2">
                <p class="text-center"><span class="">@lang('Events by total guests')</span><p>
            </div>
        </div>
    </div>
    @endif
    
</div>

@stop

@push('scripts')
<script>
    const TRACKLINK_PAGEVIEWS_CHART_LABELS = {!! $pageviews_chart['labels'] !!};
    const TRACKLINK_PAGEVIEWS_CHART_VISITORS = {!! $pageviews_chart['visitors'] ?? '[]' !!};
    const TRACKLINK_PAGEVIEWS_CHART_PAIDS = {!! $pageviews_chart['paids'] ?? '[]' !!};
    const TRACKLINK_PAGEVIEWS_CHART_JOINED = {!! $pageviews_chart['joined'] ?? '[]' !!};
    const DASHBOARD_COLUMNCHART_DATA = {!! json_encode($column_chart) ?? null !!};
    const DASHBOARD_GUEST_BY_EVENT_CHART_DATA = {!! json_encode($guest_by_event_chart) ?? null !!};

    const DASHBOARD_PAGEVIEWS_VISIBLE = {!! $pageviews_visible ? 'true' : 'false' !!};
    const DASHBOARD_COLUMNCHART_VISIBLE = {!! $column_chart_visible ? 'true' : 'false' !!};
    const DASHBOARD_GUESTBYEVENT_VISIBLE = {!! $guest_by_event_visible ? 'true' : 'false' !!};
</script>
@endpush

@push('scripts')
<script src="{{ Module::asset('dashboard:js/index.js') }}"></script>
@endpush