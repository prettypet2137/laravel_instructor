@extends('core::layouts.app')
@section('title', "Event Sales" )
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-2">
  <h1 class="h3 mb-4 text-gray-800">{{ "Event Sales" }}</h1>
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


<div class="row">

    <div class="col-12 col-lg-6 my-3">
        <div class="card h-100">
            <div class="card-body">
                <h3 class="h5">@lang('No. of seats Sold')</h3>
               
              
                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-1">
                           <h5>{{$data["count"]}}</h5>
                        </div>

                       
                    </div>
               
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 my-3">
        <div class="card h-100">
            <div class="card-body">
                <h3 class="h5">@lang('Amount from Seats sold ($)')</h3>
             

                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-1">
                             <h5>{{$data["price"]}}</h5>
                        </div>


                        
                    </div>
               
            </div>
        </div>
    </div>


</div>


@stop

@push('head')
<link rel="stylesheet" href="{{ Module::asset('tracklink:vendor/daterangepicker/daterangepicker.css') }}" />
<link rel="stylesheet" href="{{ Module::asset('tracklink:css/tracklink.css') }}" />
@endpush

@push('scripts')
<script src="{{ Module::asset('tracklink:vendor/daterangepicker/daterangepicker.js') }}"></script>
<script>
  
</script>
<script src="{{ Module::asset('tracklink:js/tracklink.js') }}"></script>
@endpush