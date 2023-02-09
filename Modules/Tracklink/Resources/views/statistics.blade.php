@extends('core::layouts.app')
@section('title', $page_title )
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-2">
  <h1 class="h3 mb-4 text-gray-800">{{ $page_title }}</h1>
  <div class="ml-auto d-sm-flex">
    <form id="formFilter" action="javascript:void(0);" class="navbar-search">
      <div class="input-group">
        <input id="daterange" class="form-control daterange" type="text" name="daterange"  />
        <div class="input-group-append">
          <button class="btn btn-primary">
              <i class="fas fa-calendar fa-sm"></i>
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="row">
  <div class="col-md-12 pb-2">
      <canvas id="pageviews_chart"></canvas>
  </div>
</div>

@if($tracklinks->count() > 0)
<div class="row">

    <div class="col-12 col-lg-6 my-3">
        <div class="card h-100">
            <div class="card-body">
                <h3 class="h5">@lang('Countries')</h3>
                @foreach($statistics['country_code'] as $key => $value)
                    @if($loop->index >= 5)
                      @break
                    @endif

                    @php 
                      $percentage = round($value / $statistics['country_code_total_sum'] * 100, 1);
                    @endphp

                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-1">
                            <div class="text-truncate">
                              <span class="align-middle">{{ get_country_from_country_code($key) }}</span>
                            </div>
                            <div>
                                <small class="text-muted">{{ nr($percentage) . '%' }}</small>
                                <span class="ml-3">{{ nr($value) }}</span>
                            </div>
                        </div>

                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 my-3">
        <div class="card h-100">
            <div class="card-body">
                <h3 class="h5">@lang('Referrers')</h3>
                @foreach($statistics['referrer_host'] as $key => $value)
                    @if($loop->index >= 5)
                      @break
                    @endif

                    @php 
                      $percentage = round($value / $statistics['referrer_host_total_sum'] * 100, 1);
                    @endphp

                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-1">
                            <div class="text-truncate">
                              <span class="align-middle">
                                @if(!$key)
                                  @lang('Redirect')
                                @elseif($key == 'qr')
                                  @lang('QR')
                                @else
                                  {{ $key }}
                                @endif
                              </span>
                            </div>
                            <div>
                                <small class="text-muted">{{ nr($percentage) . '%' }}</small>
                                <span class="ml-3">{{ nr($value) }}</span>
                            </div>
                        </div>

                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 my-3">
        <div class="card h-100">
            <div class="card-body">
                <h3 class="h5">@lang('Devices')</h3>
                @foreach($statistics['device_type'] as $key => $value)
                    @if($loop->index >= 5)
                      @break
                    @endif

                    @php 
                      $percentage = round($value / $statistics['device_type_total_sum'] * 100, 1);
                    @endphp

                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-1">
                            <div class="text-truncate">
                              <span class="align-middle">
                                @if($key)
                                  {{ $key }}
                                @else
                                  @lang('Unknown')
                                @endif
                              </span>
                            </div>
                            <div>
                                <small class="text-muted">{{ nr($percentage) . '%' }}</small>
                                <span class="ml-3">{{ nr($value) }}</span>
                            </div>
                        </div>

                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 my-3">
        <div class="card h-100">
            <div class="card-body">
                <h3 class="h5">@lang('Operating Systems')</h3>
                @foreach($statistics['os_name'] as $key => $value)
                    @if($loop->index >= 5)
                      @break
                    @endif

                    @php 
                      $percentage = round($value / $statistics['os_name_total_sum'] * 100, 1);
                    @endphp

                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-1">
                            <div class="text-truncate">
                              <span class="align-middle">
                                @if($key)
                                  {{ $key }}
                                @else
                                  @lang('Unknown')
                                @endif
                              </span>
                            </div>
                            <div>
                                <small class="text-muted">{{ nr($percentage) . '%' }}</small>
                                <span class="ml-3">{{ nr($value) }}</span>
                            </div>
                        </div>

                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 my-3">
        <div class="card h-100">
            <div class="card-body">
                <h3 class="h5">@lang('Browsers')</h3>
                @foreach($statistics['browser_name'] as $key => $value)
                    @if($loop->index >= 5)
                      @break
                    @endif

                    @php 
                      $percentage = round($value / $statistics['browser_name_total_sum'] * 100, 1);
                    @endphp

                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-1">
                            <div class="text-truncate">
                              <span class="align-middle">
                                @if($key)
                                  {{ $key }}
                                @else
                                  @lang('Unknown')
                                @endif
                              </span>
                            </div>
                            <div>
                                <small class="text-muted">{{ nr($percentage) . '%' }}</small>
                                <span class="ml-3">{{ nr($value) }}</span>
                            </div>
                        </div>

                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 my-3">
        <div class="card h-100">
            <div class="card-body">
                <h3 class="h5">@lang('Languages')</h3>
                @foreach($statistics['browser_language'] as $key => $value)
                    @if($loop->index >= 5)
                      @break
                    @endif

                    @php 
                      $percentage = round($value / $statistics['browser_language_total_sum'] * 100, 1);
                    @endphp

                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-1">
                            <div class="text-truncate">
                              <span class="align-middle">{{ get_language_from_locale($key) }}</span>
                            </div>
                            <div>
                                <small class="text-muted">{{ nr($percentage) . '%' }}</small>
                                <span class="ml-3">{{ nr($value) }}</span>
                            </div>
                        </div>

                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@else
<div class="row">
  <div class="col-md-12">
    <div class="text-center">
      <div class="error mx-auto mb-3"><i class="fas fa-chart-pie"></i></div>
      <p class="lead text-gray-800">@lang('Not found any data for statistics')</p>
      <a href="{{ route('tracklink.show', ['target_class' => $target_class, 'target_id' => $target_id]) }}" class="btn btn-primary">@lang('Refresh')</a>
    </div>
  </div>
</div>
@endif

@stop

@push('head')
<link rel="stylesheet" href="{{ Module::asset('tracklink:vendor/daterangepicker/daterangepicker.css') }}" />
<link rel="stylesheet" href="{{ Module::asset('tracklink:css/tracklink.css') }}" />
@endpush

@push('scripts')
<script src="{{ Module::asset('tracklink:vendor/daterangepicker/daterangepicker.js') }}"></script>
<script>
  const TRACKLINK_STATISTICS_URL = "{!! route('tracklink.show', ['target_class' => $target_class, 'target_id' => $target_id]) !!}";
  const TRACKLINK_START_DATE = "{{ $start_date }}";
  const TRACKLINK_END_DATE = "{{ $end_date }}";
  const TRACKLINK_PAGEVIEWS = {!! json_encode($pageviews) !!};
  const TRACKLINK_PAGEVIEWS_CHART_LABELS = {!! $pageviews_chart['labels'] !!};
  const TRACKLINK_PAGEVIEWS_CHART_PAGEVIEWS = {!! $pageviews_chart['pageviews'] ?? '[]' !!};
  const TRACKLINK_PAGEVIEWS_CHART_VISITORS = {!! $pageviews_chart['visitors'] ?? '[]' !!};
</script>
<script src="{{ Module::asset('tracklink:js/tracklink.js') }}"></script>
@endpush